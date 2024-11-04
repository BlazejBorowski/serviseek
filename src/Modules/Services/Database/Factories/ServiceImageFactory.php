<?php

declare(strict_types=1);

namespace Modules\Services\Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Modules\Services\Models\ServiceImage>
 */
class ServiceImageFactory extends Factory
{
    protected $model = \Modules\Services\Models\ServiceImage::class;

    public function definition(): array
    {
        return [
            'url' => $this->faker->imageUrl(640, 480, 'business'),
        ];
    }
}
