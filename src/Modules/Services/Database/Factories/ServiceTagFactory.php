<?php

declare(strict_types=1);

namespace Modules\Services\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Services\Models\ServiceTag>
 */
class ServiceTagFactory extends Factory
{
    protected $model = \Modules\Services\Models\ServiceTag::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->word,
        ];
    }
}
