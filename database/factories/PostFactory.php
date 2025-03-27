<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Post;
use App\Models\User;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    public function randomUserId()
    {
        $user = User::inRandomOrder()->first();
        return $user?->id;
    }
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->sentence(2, true);
        return [
            'user_id' => $this->randomUserId(),
            'name' => $name,
            'slug' => Post::generateSlug($name),
            'description' => $this->faker->sentence(10, true),
            'content' => $this->faker->paragraphs(5, true),
        ];
    }
}
