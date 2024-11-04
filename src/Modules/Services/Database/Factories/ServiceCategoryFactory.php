<?php

declare(strict_types=1);

namespace Modules\Services\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Services\Models\ServiceCategory>
 */
class ServiceCategoryFactory extends Factory
{
    protected $model = \Modules\Services\Models\ServiceCategory::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->unique()->words(2, true),
        ];
    }
}
