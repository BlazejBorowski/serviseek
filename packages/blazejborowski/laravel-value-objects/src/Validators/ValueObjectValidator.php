<?php

declare(strict_types=1);

namespace BlazejBorowski\LaravelValueObjects\Validators;

use Illuminate\Support\Facades\Validator;

abstract class ValueObjectValidator
{
    /**
     * @return array<string, mixed>
     */
    abstract public function rules(): array;

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    public function validate(array $data): array
    {
        return Validator::make($data, $this->rules())->validate();
    }
}
