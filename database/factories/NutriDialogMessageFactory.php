<?php

namespace Database\Factories;

use App\Models\NutriDialog;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Testing\WithFaker;

class NutriDialogMessageFactory extends Factory
{
    use WithFaker;

    public function definition()
    {
        return [
            'nutri_dialog_id' => NutriDialog::factory(),
            'uuid' => $this->faker->uuid,
            'prompt' => $this->faker->text,
            'suggestions' => [],
        ];
    }
}
