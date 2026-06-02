<?php

namespace App\Http\Requests\Admin;

use App\Enums\CompetitionStatus;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompetitionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $competition = $this->route('competition');

        return [
            'category_id' => ['required', 'exists:categories,id'],
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('competitions', 'slug')->ignore($competition?->id)],
            'description' => ['required', 'string', 'max:5000'],
            'poster' => [$competition ? 'nullable' : 'required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:4096'],
            'rules' => ['nullable', 'string', 'max:8000'],
            'requirements' => ['nullable', 'string', 'max:8000'],
            'prize' => ['nullable', 'string', 'max:3000'],
            'quota' => ['nullable', 'integer', 'min:0', 'max:10000'],
            'registration_start' => ['required', 'date'],
            'registration_end' => ['required', 'date', 'after:registration_start'],
            'event_date' => ['nullable', 'date', 'after_or_equal:registration_start'],
            'status' => ['required', Rule::enum(CompetitionStatus::class)],
        ];
    }
}
