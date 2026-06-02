<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePublicRegistrationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $competition = $this->route('competition');

        return [
            'team_name' => [
                'required',
                'string',
                'max:150',
                Rule::unique('registrations', 'team_name')->where('competition_id', $competition?->id),
            ],
            'leader_name' => ['required', 'string', 'max:150'],
            'leader_email' => ['required', 'email:rfc,dns', 'max:150'],
            'leader_phone' => ['required', 'string', 'max:30'],
            'institution' => ['required', 'string', 'max:150'],
            'major' => ['nullable', 'string', 'max:150'],
            'document_file' => ['required', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:4096'],
            'members' => ['nullable', 'array', 'max:8'],
            'members.*.name' => ['nullable', 'string', 'max:150'],
            'members.*.email' => ['nullable', 'email:rfc,dns', 'max:150'],
            'members.*.phone' => ['nullable', 'string', 'max:30'],
            'members.*.institution' => ['nullable', 'string', 'max:150'],
            'members.*.major' => ['nullable', 'string', 'max:150'],
            'terms' => ['accepted'],
        ];
    }
}
