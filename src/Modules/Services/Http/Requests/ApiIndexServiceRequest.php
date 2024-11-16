<?php

declare(strict_types=1);

namespace Modules\Services\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiIndexServiceRequest extends FormRequest
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
        return [
            'limit' => 'nullable|integer|min:1|max:100',
            'offset' => 'nullable|integer|min:0',
            'category' => 'integer|nullable',
            'tag' => 'string|nullable',
            'search' => 'string|nullable|max:100',
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function getData(): array
    {
        return [
            'filterValue' => $this->validated('search'),
            'limit' => $this->validated('limit') ?? 20,
            'offset' => $this->validated('offset') ?? 0,
            'category' => $this->validated('category'),
            'tag' => $this->validated('tag'),
        ];
    }
}
