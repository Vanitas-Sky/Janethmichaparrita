<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    use HasFactory;

    protected $fillable = [
        'sku',
        'name',
        'laboratory',
        'quantity_available',
        'quantity_total',
        'status',
        'category',
        'last_maintenance',
        'notes',
    ];

    protected $casts = [
        'last_maintenance' => 'datetime',
        'quantity_available' => 'integer',
        'quantity_total' => 'integer',
    ];

    // Estados del equipo: 'operational', 'maintenance', 'damaged', 'inactive'
    const STATUSES = [
        'operational' => 'Operacional',
        'maintenance' => 'En Mantenimiento',
        'damaged' => 'Dañado',
        'inactive' => 'Inactivo',
    ];

    // Categorías de equipos
    const CATEGORIES = [
        'electronics' => 'Electrónica',
        'microscopes' => 'Microscopios',
        'computing' => 'Computadoras',
        'chemicals' => 'Reactivos Químicos',
        'tools' => 'Herramientas',
        'other' => 'Otros',
    ];

    public function alerts()
    {
        return $this->hasMany(EquipmentAlert::class);
    }

    public function isLowStock()
    {
        return $this->quantity_available <= ($this->quantity_total * 0.25);
    }

    public function getStockPercentage()
    {
        return $this->quantity_total > 0 
            ? round(($this->quantity_available / $this->quantity_total) * 100) 
            : 0;
    }
}
