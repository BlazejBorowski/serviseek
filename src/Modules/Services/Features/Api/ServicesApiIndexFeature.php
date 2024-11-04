<?php

declare(strict_types=1);

namespace Modules\Services\Features\Api;

use App\Models\User;

class ServicesApiIndexFeature
{
    public function resolve(User $user): mixed
    {
        return match (true) {
            $user->isSuperAdmin() => true,
            default => false,
        };
    }
}
