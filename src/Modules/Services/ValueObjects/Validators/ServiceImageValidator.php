<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects\Validators;

use BlazejBorowski\LaravelValueObjects\Validators\ValueObjectValidator;

class ServiceImageValidator extends ValueObjectValidator
{
    public function rules(): array
    {
        return [
            'url' => 'required|string',
            'isMain' => 'required|boolean',
        ];
    }
}
