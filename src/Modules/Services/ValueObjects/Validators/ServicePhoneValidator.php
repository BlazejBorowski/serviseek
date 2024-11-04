<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects\Validators;

use BlazejBorowski\LaravelValueObjects\Validators\ValueObjectValidator;

class ServicePhoneValidator extends ValueObjectValidator
{
    public function rules(): array
    {
        return [
            'service_id' => 'required|integer',
            'number' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'is_main' => 'required|boolean',
        ];
    }
}
