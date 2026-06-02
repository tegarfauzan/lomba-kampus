@extends('layouts.admin')

@section('title', 'Settings Website')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ route('admin.settings.update') }}" class="ui-card max-w-5xl space-y-6 p-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="form-label" for="organization_name">Nama Organisasi</label>
                <input class="form-input" id="organization_name" name="organization_name" value="{{ old('organization_name', $setting->organization_name) }}" required>
                @error('organization_name') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="event_name">Nama Event</label>
                <input class="form-input" id="event_name" name="event_name" value="{{ old('event_name', $setting->event_name) }}" required>
                @error('event_name') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label" for="description">Deskripsi Singkat</label>
            <textarea class="form-input min-h-32" id="description" name="description">{{ old('description', $setting->description) }}</textarea>
            @error('description') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="form-label" for="contact_email">Email Panitia</label>
                <input class="form-input" id="contact_email" type="email" name="contact_email" value="{{ old('contact_email', $setting->contact_email) }}">
                @error('contact_email') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="contact_phone">WhatsApp</label>
                <input class="form-input" id="contact_phone" name="contact_phone" value="{{ old('contact_phone', $setting->contact_phone) }}">
                @error('contact_phone') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="form-label" for="instagram_url">Instagram</label>
                <input class="form-input" id="instagram_url" type="url" name="instagram_url" value="{{ old('instagram_url', $setting->instagram_url) }}">
                @error('instagram_url') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="logo">Logo</label>
                <input class="form-input" id="logo" type="file" name="logo">
                @error('logo') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label" for="address">Alamat Sekretariat</label>
            <textarea class="form-input min-h-24" id="address" name="address">{{ old('address', $setting->address) }}</textarea>
            @error('address') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>

        <div>
            <label class="form-label" for="footer_text">Footer Text</label>
            <input class="form-input" id="footer_text" name="footer_text" value="{{ old('footer_text', $setting->footer_text) }}">
            @error('footer_text') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>

        <button class="btn-primary" type="submit">Simpan Settings</button>
    </form>
@endsection
