<?php

namespace Modules\Services\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\\Modules\Services\Models\ServicePhone>
 */
class ServicePhoneFactory extends Factory
{
    protected $model = \Modules\Services\Models\ServicePhone::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'number' => $this->faker->phoneNumber,
            'description' => $this->faker->sentence,
        ];
    }
}
