<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EquipmentAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'equipment_id',
        'alert_type',
        'message',
        'is_resolved',
    ];

    protected $casts = [
        'is_resolved' => 'boolean',
    ];

    const ALERT_TYPES = [
        'low_stock' => 'Stock Bajo',
        'maintenance_due' => 'Mantenimiento Vencido',
        'missing_item' => 'Equipo Faltante',
        'damage_report' => 'Reporte de Daño',
    ];

    public function equipment()
    {
        return $this->belongsTo(Equipment::class);
    }
}
