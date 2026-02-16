<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Comment;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Image>
 */
class ImageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // database/factories/ImageFactory.php
    public function definition(): array
    {
        return [
            // Usamos un número aleatorio para que cada imagen sea diferente
            'url' => "https://picsum.photos/seed/" . rand(1, 10000) . "/600/400",
            'comment_id' => \App\Models\Comment::inRandomOrder()->first()->id ?? 1,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
