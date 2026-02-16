<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\RoleSeeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\IslandSeeder;
use Database\Seeders\ZoneSeeder;
use Database\Seeders\MunicipalitySeeder;
use Database\Seeders\TrekSeeder;
use Database\Seeders\PlaceSeeder;
use App\Models\User;
use App\Models\Meeting;
use App\Models\Image;
use App\Models\Comment;
use App\Models\MeetingUseSeeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        try {
            $this->command->info('1. Cargando Roles y Usuarios del JSON...');
            $this->call(RoleSeeder::class);
            $this->call(UserSeeder::class); // Aquí se crean los guías reales

            $this->command->info('2. Cargando Geografía y Treks...');
            $this->call([
                IslandSeeder::class,
                ZoneSeeder::class,
                MunicipalitySeeder::class,
                TrekSeeder::class,
                PlaceSeeder::class,
            ]);

            // 3. Obtenemos los guías que acabamos de crear
            $guiesIds = User::whereHas('role', function($q) {
                $q->where('name', 'guia');
            })->pluck('id'); // Esto nos da un array de IDs reales [1, 2, 3...]

            if ($guiesIds->isNotEmpty()) {
                Meeting::all()->each(function($meeting) use ($guiesIds) {
                    $meeting->update(['user_id' => $guiesIds->random()]);
        });
        $comments = \App\Models\Comment::factory(20)->create();
        // Por cada comentario creado, generamos una imagen real de Picsum
        $comments->each(function ($comment) {
            \App\Models\Image::factory()->create([
                'comment_id' => $comment->id,
                'url' => "https://picsum.photos/seed/" . uniqid() . "/600/400"
            ]);
        });
    }

            $this->command->info('4. Creando Meetings vinculadas a guías reales...');
            // Por cada Trek, creamos un par de reuniones con guías que sí existen
            foreach (\App\Models\Trek::all() as $trek) {
                for ($i = 0; $i < 2; $i++) {
                    \App\Models\Meeting::create([
                        'trek_id' => $trek->id,
                        'user_id' => $guiesIds->random(), // Selecciona un ID que existe de verdad
                        'day' => now()->addDays(rand(1, 60))->format('Y-m-d'),
                        'time' => '09:00:00',
                        'appDateIni' => now()->subDays(10)->format('Y-m-d'),
                        'appDateEnd' => now()->addDays(5)->format('Y-m-d'),
                        'totalScore' => 0,
                        'countScore' => 0
                    ]);
                }
            }

            $this->command->info('5. Ejecutando inscripciones finales...');
            // Asegúrate de que este seeder no sobrescriba los user_id de las meetings
            $this->call(MeetingUserSeeder::class);

        } catch (\Exception $e) {
            $this->command->error("Error: " . $e->getMessage());
        }
    }
}
