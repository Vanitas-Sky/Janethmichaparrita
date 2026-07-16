<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
<<<<<<< Updated upstream
=======
use App\Models\User;
use App\Models\Equipo;
use Illuminate\Support\Facades\Hash;
>>>>>>> Stashed changes

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
<<<<<<< Updated upstream
        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
=======
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
>>>>>>> Stashed changes
    }
}
