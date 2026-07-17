<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Equipo;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use App\Models\Equipment;
use Illuminate\Support\Facades\Hash;
main

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        // Crear usuario demo coordinador
        User::firstOrCreate(
            ['email' => 'coordinador@instituto.edu.mx'],
            [
                'name' => 'Ing. Carlos Mendoza',
                'password' => Hash::make('password'),
                'role' => 'coordinador',
                'email_verified_at' => now(),
            ]
        );

        // Crear usuario demo docente
        User::firstOrCreate(
            ['email' => 'docente@instituto.edu.mx'],
            [
                'name' => 'Dr. Juan López',
                'password' => Hash::make('password'),
                'role' => 'docente',
                'email_verified_at' => now(),
            ]
        );

        // Crear equipos de ejemplo en diferentes laboratorios
        $equipos = [
            [
                'numero_inventario' => 'EQ-001',
                'nombre' => 'Osciloscopio Digital Rigol',
                'laboratorio' => 'Electrónica',
                'cantidad' => 3,
                'estado' => 'Disponible',
            ],
            [
                'numero_inventario' => 'EQ-002',
                'nombre' => 'Microscopio Óptico Compuesto',
                'laboratorio' => 'Biología',
                'cantidad' => 8,
                'estado' => 'Disponible',
            ],
            [
                'numero_inventario' => 'EQ-003',
                'nombre' => 'Computadora de Escritorio HP',
                'laboratorio' => 'Informática',
                'cantidad' => 2,
                'estado' => 'Mantenimiento',
            ],
            [
                'numero_inventario' => 'EQ-004',
                'nombre' => 'Reactivo: Ácido Sulfúrico 98%',
                'laboratorio' => 'Química',
                'cantidad' => 2,
                'estado' => 'Disponible',
            ],
            [
                'numero_inventario' => 'EQ-005',
                'nombre' => 'Juego de Pinzas de Precisión',
                'laboratorio' => 'Electrónica',
                'cantidad' => 12,
                'estado' => 'Disponible',
            ],
            [
                'numero_inventario' => 'EQ-006',
                'nombre' => 'Horno Mufla Digital',
                'laboratorio' => 'Química',
                'cantidad' => 1,
                'estado' => 'Dañado',
            ],
            [
                'numero_inventario' => 'EQ-007',
                'nombre' => 'Proyector Multimedia Epson',
                'laboratorio' => 'Aula Magna',
                'cantidad' => 1,
                'estado' => 'Disponible',
            ],
            [
                'numero_inventario' => 'EQ-008',
                'nombre' => 'Generador de Funciones',
                'laboratorio' => 'Electrónica',
                'cantidad' => 2,
                'estado' => 'Disponible',
            ],
        ];

        foreach ($equipos as $equipo) {
            Equipo::firstOrCreate(
                ['numero_inventario' => $equipo['numero_inventario']],
                $equipo
            );
        }
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
main
    }
}
