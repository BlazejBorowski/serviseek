<?php

declare(strict_types=1);

namespace Modules\Services\Actions;

use Modules\Services\Models\Service;

interface AddRandomServices
{
    public function handle(): Service;
}
