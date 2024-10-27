<?php

namespace Modules\Services\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Services\Models\ServiceEmail>
 */
class ServiceEmailFactory extends Factory
{
    protected $model = \Modules\Services\Models\ServiceEmail::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'email' => $this->faker->unique()->safeEmail,
            'description' => $this->faker->sentence,
        ];
    }
}
