<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects\Interfaces;

interface HasMainInterface
{
    public function isMain(): bool;
}
