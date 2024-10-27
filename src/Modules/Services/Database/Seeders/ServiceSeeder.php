<?php

declare(strict_types=1);

namespace Modules\Services\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Modules\Services\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = User::whereNotIn('id', [1, 2])->get();

        Service::factory()
            ->count(100)
            ->create()
            ->each(function ($service) use ($users) {
                $service->emails()->saveMany(\Modules\Services\Models\ServiceEmail::factory(2)->make());
                $service->phones()->saveMany(\Modules\Services\Models\ServicePhone::factory(2)->make());

                /** @var int[] $selectedUsers */
                $selectedUsers = $users->random(3)->pluck('id')->toArray();

                /** @var array<int, array<string, string>> $roles */
                $roles = array_fill(0, count($selectedUsers), ['role' => 'Manager']);

                /** @var array<int, array<string, string>> $rolesToAttach */
                $rolesToAttach = array_combine($selectedUsers, $roles);

                if ($rolesToAttach) {
                    $service->users()->sync($rolesToAttach);
                }
            });
    }
}
