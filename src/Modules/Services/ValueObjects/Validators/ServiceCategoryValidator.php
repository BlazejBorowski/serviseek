<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects\Validators;

use BlazejBorowski\LaravelValueObjects\Validators\ValueObjectValidator;

class ServiceCategoryValidator extends ValueObjectValidator
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer|min:1',
            'name' => 'required|string|max:255',
        ];
    }
}
