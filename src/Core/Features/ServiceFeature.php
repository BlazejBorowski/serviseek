<?php

declare(strict_types=1);

namespace Core\Features;

use App\Models\User;

class ServiceFeature
{
    public function resolve(User $user): mixed
    {
        return match (true) {
            $user->isSuperAdmin() => true,
            default => false,
        };
    }
}
