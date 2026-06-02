<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class SettingRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'organization_name' => ['required', 'string', 'max:150'],
            'event_name' => ['required', 'string', 'max:150'],
            'logo' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp,svg', 'max:2048'],
            'description' => ['nullable', 'string', 'max:2000'],
            'contact_email' => ['nullable', 'email:rfc,dns', 'max:150'],
            'contact_phone' => ['nullable', 'string', 'max:30'],
            'instagram_url' => ['nullable', 'url', 'max:255'],
            'address' => ['nullable', 'string', 'max:500'],
            'footer_text' => ['nullable', 'string', 'max:180'],
        ];
    }
}
