<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $mediaType = fake()->randomElement(['image', 'video', null]);

        return [
            'title' => fake()->sentence(),
            'body' => fake()->paragraph(),
            'media_type' => $mediaType,
            'media_url' => $mediaType === 'image'
                ? fake()->imageUrl(640, 480, 'nature', true)
                : ($mediaType === 'video' ? 'https://www.w3schools.com/html/mov_bbb.mp4' : null),
        ];

    }
}
