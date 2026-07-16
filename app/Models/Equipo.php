<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    /**
     * La tabla asociada al modelo
     */
    protected $table = 'equipos';

    /**
     * Los atributos que pueden ser asignados masivamente
     */
    protected $fillable = [
        'numero_inventario',
        'nombre',
        'laboratorio',
        'cantidad',
        'estado',
    ];

    /**
     * Los atributos que no se pueden asignar masivamente
     */
    protected $guarded = [];

    /**
     * Los atributos que deben ser moldeados
     */
    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Estados permitidos del equipo
     */
    public const ESTADO_DISPONIBLE = 'Disponible';
    public const ESTADO_MANTENIMIENTO = 'Mantenimiento';
    public const ESTADO_DANIO = 'Dañado';
    public const ESTADO_INACTIVO = 'Inactivo';

    /**
     * Obtener todos los estados permitidos
     */
    public static function estados()
    {
        return [
            self::ESTADO_DISPONIBLE,
            self::ESTADO_MANTENIMIENTO,
            self::ESTADO_DANIO,
            self::ESTADO_INACTIVO,
        ];
    }

    /**
     * Verificar si el equipo está disponible
     */
    public function estaDisponible(): bool
    {
        return $this->estado === self::ESTADO_DISPONIBLE;
    }

    /**
     * Verificar si el equipo está en mantenimiento
     */
    public function estaEnMantenimiento(): bool
    {
        return $this->estado === self::ESTADO_MANTENIMIENTO;
    }

    /**
     * Verificar si el equipo está dañado
     */
    public function estaDaniado(): bool
    {
        return $this->estado === self::ESTADO_DANIO;
    }

    /**
     * Verificar si el equipo está inactivo
     */
    public function estaInactivo(): bool
    {
        return $this->estado === self::ESTADO_INACTIVO;
    }

    /**
     * Obtener el valor del estado en forma legible
     */
    public function getEstadoLegible(): string
    {
        return match($this->estado) {
            self::ESTADO_DISPONIBLE => 'Disponible',
            self::ESTADO_MANTENIMIENTO => 'En Mantenimiento',
            self::ESTADO_DANIO => 'Dañado',
            self::ESTADO_INACTIVO => 'Inactivo',
            default => 'Desconocido',
        };
    }

    /**
     * Obtener el color del estado para la interfaz
     */
    public function getColorEstado(): string
    {
        return match($this->estado) {
            self::ESTADO_DISPONIBLE => 'green',
            self::ESTADO_MANTENIMIENTO => 'yellow',
            self::ESTADO_DANIO => 'red',
            self::ESTADO_INACTIVO => 'gray',
            default => 'gray',
        };
    }
}
