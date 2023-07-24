<?php

namespace App\Http\Admin\Requests;

use App\Models\SocialMedia;
use Illuminate\Foundation\Http\FormRequest;

class SocialMediaAccountStoreRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|max:40',
            'social_media_id' => ['required', 'exists:' . SocialMedia::class .  ',id'],
        ];
    }
}
