<?php


namespace App\Http\Admin\Requests;


use Illuminate\Foundation\Http\FormRequest;

class SocialMediaUpdateHashtagRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'hashtags' => ['nullable', 'regex:/^#\w+( #\w+)*/', 'max:255'],
        ];
    }
}
