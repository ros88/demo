<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\User;

class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $usersAdminIds = User::where('role_id', 2)->pluck('id');

        return [
            'title' => $this->faker->text($maxNbChars = 70),
            'content' => $this->faker->text($maxNbChars = 500),
            'author_id' => $usersAdminIds[rand(0, (count($usersAdminIds) - 1))],
            'publish_at' => $this->faker->dateTimeBetween('+30 days', '+2 years'),
        ];
    }
}
