<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipment;
use App\Models\EquipmentAlert;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class EquipmentController extends Controller
{
    /**
     * Obtener todos los equipos con paginación y búsqueda
     */
    public function index(Request $request): JsonResponse
    {
        $query = Equipment::query();

        // Búsqueda por nombre o SKU
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where('name', 'like', "%{$search}%")
                  ->orWhere('sku', 'like', "%{$search}%");
        }

        // Filtro por laboratorio
        if ($request->has('laboratory')) {
            $query->where('laboratory', $request->input('laboratory'));
        }

        // Filtro por estado
        if ($request->has('status')) {
            $query->where('status', $request->input('status'));
        }

        // Filtro por categoría
        if ($request->has('category')) {
            $query->where('category', $request->input('category'));
        }

        $equipment = $query->paginate($request->input('per_page', 15));

        return response()->json($equipment);
    }

    /**
     * Crear nuevo equipo
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'sku' => 'required|string|unique:equipment,sku|max:50',
            'name' => 'required|string|max:255',
            'laboratory' => 'required|string|max:255',
            'quantity_available' => 'required|integer|min:0',
            'quantity_total' => 'required|integer|min:1',
            'status' => 'required|in:operational,maintenance,damaged,inactive',
            'category' => 'required|in:electronics,microscopes,computing,chemicals,tools,other',
            'last_maintenance' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validar que cantidad disponible no supere el total
        if ($validated['quantity_available'] > $validated['quantity_total']) {
            return response()->json([
                'message' => 'La cantidad disponible no puede superar la cantidad total',
                'errors' => ['quantity_available' => 'No puede ser mayor al total']
            ], 422);
        }

        $equipment = Equipment::create($validated);

        // Crear alerta si el stock está bajo
        if ($equipment->isLowStock()) {
            EquipmentAlert::create([
                'equipment_id' => $equipment->id,
                'alert_type' => 'low_stock',
                'message' => "Stock bajo para {$equipment->name}",
            ]);
        }

        return response()->json([
            'message' => 'Equipo creado exitosamente',
            'data' => $equipment
        ], 201);
    }

    /**
     * Obtener un equipo específico
     */
    public function show(Equipment $equipment): JsonResponse
    {
        return response()->json($equipment->load('alerts'));
    }

    /**
     * Actualizar un equipo
     */
    public function update(Request $request, Equipment $equipment): JsonResponse
    {
        $validated = $request->validate([
            'sku' => 'sometimes|string|unique:equipment,sku,' . $equipment->id . '|max:50',
            'name' => 'sometimes|string|max:255',
            'laboratory' => 'sometimes|string|max:255',
            'quantity_available' => 'sometimes|integer|min:0',
            'quantity_total' => 'sometimes|integer|min:1',
            'status' => 'sometimes|in:operational,maintenance,damaged,inactive',
            'category' => 'sometimes|in:electronics,microscopes,computing,chemicals,tools,other',
            'last_maintenance' => 'nullable|date',
            'notes' => 'nullable|string|max:1000',
        ]);

        // Validar que cantidad disponible no supere el total
        $quantityAvailable = $validated['quantity_available'] ?? $equipment->quantity_available;
        $quantityTotal = $validated['quantity_total'] ?? $equipment->quantity_total;

        if ($quantityAvailable > $quantityTotal) {
            return response()->json([
                'message' => 'La cantidad disponible no puede superar la cantidad total',
                'errors' => ['quantity_available' => 'No puede ser mayor al total']
            ], 422);
        }

        $equipment->update($validated);

        // Actualizar alertas de stock bajo
        if ($equipment->isLowStock()) {
            EquipmentAlert::where('equipment_id', $equipment->id)
                         ->where('alert_type', 'low_stock')
                         ->where('is_resolved', false)
                         ->firstOrCreate([
                             'equipment_id' => $equipment->id,
                             'alert_type' => 'low_stock',
                         ], [
                             'message' => "Stock bajo para {$equipment->name}",
                         ]);
        } else {
            EquipmentAlert::where('equipment_id', $equipment->id)
                         ->where('alert_type', 'low_stock')
                         ->update(['is_resolved' => true]);
        }

        return response()->json([
            'message' => 'Equipo actualizado exitosamente',
            'data' => $equipment
        ]);
    }

    /**
     * Eliminar/Dar de baja un equipo
     */
    public function destroy(Equipment $equipment): JsonResponse
    {
        $equipment->delete();

        return response()->json([
            'message' => 'Equipo eliminado exitosamente'
        ]);
    }

    /**
     * Obtener estadísticas del dashboard
     */
    public function stats(): JsonResponse
    {
        $totalEquipment = Equipment::count();
        $maintenanceEquipment = Equipment::where('status', 'maintenance')->count();
        $lowStockAlerts = EquipmentAlert::where('alert_type', 'low_stock')
                                        ->where('is_resolved', false)
                                        ->count();

        return response()->json([
            'total_equipment' => $totalEquipment,
            'equipment_in_maintenance' => $maintenanceEquipment,
            'low_stock_alerts' => $lowStockAlerts,
            'last_updated' => now(),
        ]);
    }

    /**
     * Obtener laboratorios disponibles
     */
    public function laboratories(): JsonResponse
    {
        $labs = Equipment::distinct()->pluck('laboratory')->sort();

        return response()->json([
            'laboratories' => $labs->values(),
        ]);
    }
}
