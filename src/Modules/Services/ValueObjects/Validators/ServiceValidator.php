<?php

declare(strict_types=1);

namespace Modules\Services\ValueObjects\Validators;

use BlazejBorowski\LaravelValueObjects\Validators\ValueObjectValidator;

class ServiceValidator extends ValueObjectValidator
{
    public function rules(): array
    {
        return [
            'id' => 'required|integer',
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required',
            'emails' => 'required|array',
            'phones' => 'required|array',
            'tags' => 'required|array',
            'images' => 'required|array',
            'created_at' => 'date',
            'updated_at' => 'date',
            'deleted_at' => 'date',
        ];
    }
}
