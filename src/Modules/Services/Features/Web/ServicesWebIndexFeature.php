<?php

declare(strict_types=1);

namespace Modules\Services\Features\Web;

use App\Models\User;

class ServicesWebIndexFeature
{
    public function resolve(User $user): mixed
    {
        return match (true) {
            $user->isSuperAdmin() => true,
            default => false,
        };
    }
}
