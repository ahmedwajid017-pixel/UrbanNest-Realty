<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PropertyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => 'required|exists:categories,id',

            'agent_id' => 'required|exists:agents,id',

            'title' => 'required|string|max:255',

            'description' => 'nullable|string',

            'price' => 'required|numeric|min:0',

            'location' => 'required|string|max:255',

            'status' => 'required|in:available,sold,rented',

            'images' => 'nullable|array|max:10',

            'images.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ];
    }

    public function messages(): array
    {
        return [
            'category_id.required' => 'Please select a category.',
            'agent_id.required' => 'Please select an agent.',
            'images.*.image' => 'Only image files are allowed.',
            'images.*.mimes' => 'Images must be JPG, JPEG, PNG, or WEBP.',
            'images.*.max' => 'Each image must not exceed 5 MB.',
            'images.max' => 'You can upload a maximum of 10 images.',
        ];
    }
}