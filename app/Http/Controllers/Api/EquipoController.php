<?php

namespace App\Http\Controllers\Api;

use App\Models\Equipo;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;

class EquipoController extends Controller
{
    /**
     * Obtener lista de equipos con paginación y búsqueda
     */
    public function index(Request $request): JsonResponse
    {
        try {
            $query = Equipo::query();

            // Búsqueda por nombre o número de inventario
            if ($request->has('buscar')) {
                $buscar = $request->input('buscar');
                $query->where('nombre', 'like', "%{$buscar}%")
                      ->orWhere('numero_inventario', 'like', "%{$buscar}%");
            }

            // Filtrar por laboratorio
            if ($request->has('laboratorio')) {
                $query->where('laboratorio', $request->input('laboratorio'));
            }

            // Filtrar por estado
            if ($request->has('estado')) {
                $query->where('estado', $request->input('estado'));
            }

            $equipos = $query->paginate(15);

            return response()->json([
                'success' => true,
                'message' => 'Equipos obtenidos exitosamente',
                'data' => $equipos->items(),
                'pagination' => [
                    'total' => $equipos->total(),
                    'per_page' => $equipos->perPage(),
                    'current_page' => $equipos->currentPage(),
                    'last_page' => $equipos->lastPage(),
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener equipos: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Crear un nuevo equipo
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validado = $request->validate([
                'numero_inventario' => 'required|string|unique:equipos|max:50',
                'nombre' => 'required|string|max:100',
                'laboratorio' => 'required|string|max:50',
                'cantidad' => 'required|integer|min:1',
                'estado' => 'required|in:' . implode(',', Equipo::estados()),
            ], [
                'numero_inventario.required' => 'El número de inventario es obligatorio',
                'numero_inventario.unique' => 'Este número de inventario ya existe',
                'nombre.required' => 'El nombre del equipo es obligatorio',
                'laboratorio.required' => 'El laboratorio es obligatorio',
                'cantidad.required' => 'La cantidad es obligatoria',
                'cantidad.integer' => 'La cantidad debe ser un número entero',
                'cantidad.min' => 'La cantidad debe ser mayor a cero',
                'estado.required' => 'El estado es obligatorio',
                'estado.in' => 'El estado no es válido',
            ]);

            $equipo = Equipo::create($validado);

            return response()->json([
                'success' => true,
                'message' => 'Equipo creado exitosamente',
                'data' => $equipo
            ], 201);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al crear equipo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener un equipo específico
     */
    public function show($id): JsonResponse
    {
        try {
            $equipo = Equipo::findOrFail($id);

            return response()->json([
                'success' => true,
                'message' => 'Equipo obtenido exitosamente',
                'data' => $equipo
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener equipo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Actualizar un equipo
     */
    public function update(Request $request, $id): JsonResponse
    {
        try {
            $equipo = Equipo::findOrFail($id);

            $validado = $request->validate([
                'numero_inventario' => 'sometimes|string|unique:equipos,numero_inventario,' . $id . '|max:50',
                'nombre' => 'sometimes|string|max:100',
                'laboratorio' => 'sometimes|string|max:50',
                'cantidad' => 'sometimes|integer|min:1',
                'estado' => 'sometimes|in:' . implode(',', Equipo::estados()),
            ], [
                'cantidad.integer' => 'La cantidad debe ser un número entero',
                'cantidad.min' => 'La cantidad debe ser mayor a cero',
            ]);

            $equipo->update($validado);

            return response()->json([
                'success' => true,
                'message' => 'Equipo actualizado exitosamente',
                'data' => $equipo
            ], 200);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error de validación',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al actualizar equipo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Eliminar un equipo
     */
    public function destroy($id): JsonResponse
    {
        try {
            $equipo = Equipo::findOrFail($id);
            $equipo->delete();

            return response()->json(null, 204);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Equipo no encontrado'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al eliminar equipo: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener estadísticas del inventario
     */
    public function estadisticas(): JsonResponse
    {
        try {
            $total = Equipo::count();
            $disponibles = Equipo::where('estado', Equipo::ESTADO_DISPONIBLE)->count();
            $enMantenimiento = Equipo::where('estado', Equipo::ESTADO_MANTENIMIENTO)->count();
            $danados = Equipo::where('estado', Equipo::ESTADO_DANIO)->count();
            $laboratorios = Equipo::distinct('laboratorio')->count('laboratorio');

            return response()->json([
                'success' => true,
                'message' => 'Estadísticas obtenidas exitosamente',
                'data' => [
                    'total_equipos' => $total,
                    'equipos_disponibles' => $disponibles,
                    'equipos_mantenimiento' => $enMantenimiento,
                    'equipos_danados' => $danados,
                    'total_laboratorios' => $laboratorios,
                ]
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener estadísticas: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Obtener lista de laboratorios únicos
     */
    public function laboratorios(): JsonResponse
    {
        try {
            $laboratorios = Equipo::distinct()
                ->pluck('laboratorio')
                ->filter()
                ->sort()
                ->values();

            return response()->json([
                'success' => true,
                'message' => 'Laboratorios obtenidos exitosamente',
                'data' => $laboratorios
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error al obtener laboratorios: ' . $e->getMessage()
            ], 500);
        }
    }
}
