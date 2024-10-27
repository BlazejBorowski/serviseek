<?php

namespace Database\Seeders;
use Database\Seeders\DevSeeders\UserSeeder;
use Illuminate\Database\Seeder;
use Modules\Services\Database\Seeders\ServiceSeeder;

class DevSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ServiceSeeder::class,
        ]);
    }
}
