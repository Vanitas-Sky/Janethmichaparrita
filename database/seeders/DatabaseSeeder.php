<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create demo user
        User::firstOrCreate(
            ['email' => 'demo@instituto.edu.mx'],
            [
                'name' => 'Ing. Carlos Mendoza',
                'password' => Hash::make('password'),
                'email_verified_at' => now(),
            ]
        );

        // Create sample equipment
        Equipment::create([
            'sku' => 'EQ-001',
            'name' => 'Osciloscopio Digital Rigol',
            'laboratory' => 'Laboratorio de Electrónica',
            'quantity_available' => 3,
            'quantity_total' => 5,
            'status' => 'operational',
            'category' => 'electronics',
            'notes' => 'Equipo en buen estado, última calibración: enero 2026',
        ]);

        Equipment::create([
            'sku' => 'EQ-002',
            'name' => 'Microscopio Óptico Compuesto',
            'laboratory' => 'Laboratorio de Biología',
            'quantity_available' => 8,
            'quantity_total' => 10,
            'status' => 'operational',
            'category' => 'microscopes',
            'notes' => 'Equipos funcionales con lentes de 40X y 100X',
        ]);

        Equipment::create([
            'sku' => 'EQ-003',
            'name' => 'Computadora de Escritorio HP',
            'laboratory' => 'Laboratorio de Informática',
            'quantity_available' => 2,
            'quantity_total' => 15,
            'status' => 'maintenance',
            'category' => 'computing',
            'notes' => 'Equipo en mantenimiento preventivo hasta el 20 de julio',
        ]);

        Equipment::create([
            'sku' => 'EQ-004',
            'name' => 'Reactivo: Ácido Sulfúrico 98%',
            'laboratory' => 'Laboratorio de Química',
            'quantity_available' => 2,
            'quantity_total' => 10,
            'status' => 'operational',
            'category' => 'chemicals',
            'notes' => 'Stock bajo, solicitar reorden',
        ]);

        Equipment::create([
            'sku' => 'EQ-005',
            'name' => 'Juego de Pinzas de Precisión',
            'laboratory' => 'Laboratorio de Electrónica',
            'quantity_available' => 12,
            'quantity_total' => 12,
            'status' => 'operational',
            'category' => 'tools',
            'notes' => 'Herramientas básicas para laboratorio electrónico',
        ]);
    }
}
    }
}
