<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AnnouncementRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $announcement = $this->route('announcement');

        return [
            'competition_id' => ['nullable', 'exists:competitions,id'],
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:200', Rule::unique('announcements', 'slug')->ignore($announcement?->id)],
            'content' => ['required', 'string', 'max:10000'],
            'is_published' => ['nullable', 'boolean'],
            'is_important' => ['nullable', 'boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
