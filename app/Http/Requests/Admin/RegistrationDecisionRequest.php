<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class RegistrationDecisionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'admin_note' => [$this->routeIs('admin.registrations.reject') ? 'required' : 'nullable', 'string', 'max:1000'],
        ];
    }
}
