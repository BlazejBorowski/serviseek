<?php

declare(strict_types=1);

namespace Modules\Services\Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Collection;
use Modules\Services\Models\Service;
use Modules\Services\Models\ServiceCategory;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::whereNotIn('id', [1, 2])->get();
        $categories = ServiceCategory::factory()->count(10)->create();

        Service::factory()
            ->count(100)
            ->create()
            ->each(function ($service) use ($users, $categories) {

                $this->addEmails($service, 2);

                $this->addPhones($service, 2);

                $this->addImages($service, 3);

                $this->addTags($service, 3);

                $this->addCategory($service, $categories);

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

    private function addEmails(Service $service, int $count): void
    {
        $emails = \Modules\Services\Models\ServiceEmail::factory($count)->make();
        $emails[0]['is_main'] = true;
        $service->emails()->saveMany($emails);
    }

    private function addPhones(Service $service, int $count): void
    {
        $phones = \Modules\Services\Models\ServicePhone::factory($count)->make();
        $phones[0]['is_main'] = true;
        $service->phones()->saveMany($phones);
    }

    private function addImages(Service $service, int $count): void
    {
        $images = \Modules\Services\Models\ServiceImage::factory($count)->make();
        $images[0]['is_main'] = true;
        $service->images()->saveMany($images);
    }

    private function addTags(Service $service, int $count): void
    {
        $tags = \Modules\Services\Models\ServiceTag::factory($count)->make();
        $service->tags()->saveMany($tags);
    }

    /**
     * @param  Collection<int, ServiceCategory>  $categories
     */
    private function addCategory(Service $service, Collection $categories): void
    {
        $category = $categories->random();
        $service->category()->associate($category)->save();
    }
}
