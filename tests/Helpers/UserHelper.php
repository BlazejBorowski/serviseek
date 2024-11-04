<?php

namespace Tests\Helpers;

use App\Models\User;

class UserHelper
{
    public static function createAdminUser(): User
    {
        return User::factory()->create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => 'password',
        ]);
    }
}
