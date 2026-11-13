<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['required', 'exists:categories,id'],

            'agent_id' => [
                Rule::excludeIf(
                    $this->user()?->role?->name === 'Agent'
                ),
                'required',
                'exists:agents,id',
            ],

            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'price' => ['required', 'numeric', 'min:0'],
            'location' => ['required', 'string', 'max:255'],
            'status' => ['required', 'string', 'max:50'],

            'images' => ['nullable', 'array', 'max:10'],
            'images.*' => [
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:5120',
            ],
        ];
    }
}