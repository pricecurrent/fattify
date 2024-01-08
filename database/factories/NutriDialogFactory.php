<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class NutriDialogFactory extends Factory
{
    use WithFaker;

    public function definition()
    {
        return [
            'user_id' => User::factory(),
            'uuid' => $this->faker->uuid,
        ];
    }
}
