<?php

declare(strict_types=1);

namespace Modules\Services\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ShowServiceRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [];
    }

    /**
     * @return array<string, object|string|null>
     */
    public function getData(): array
    {
        return [
            'service' => $this->route('service'),
        ];
    }
}
