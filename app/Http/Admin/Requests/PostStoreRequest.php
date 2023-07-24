<?php

namespace App\Http\Admin\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PostStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'caption' => 'nullable|string',
            'posted_at' => 'nullable|date',
            'images' => ['required', 'array', 'min:1'],
            'images.*' => ['image', 'max:10000'],
        ];
    }
}
