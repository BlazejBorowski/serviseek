<?php

declare(strict_types=1);

namespace Modules\Services\Features;

use App\Models\User;

class ServiceWebShowFeature
{
    public function resolve(?User $user): mixed
    {
        return match (true) {
            $user?->isSuperAdmin() => true,
            default => true,
        };
    }
}
