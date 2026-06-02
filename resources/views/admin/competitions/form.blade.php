@extends('layouts.admin')

@section('title', $competition->exists ? 'Edit Lomba' : 'Tambah Lomba')

@section('content')
    <form method="POST" enctype="multipart/form-data" action="{{ $competition->exists ? route('admin.competitions.update', $competition) : route('admin.competitions.store') }}" class="ui-card space-y-8 p-6">
        @csrf
        @if ($competition->exists)
            @method('PUT')
        @endif

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="form-label" for="title">Judul Lomba</label>
                <input class="form-input" id="title" name="title" value="{{ old('title', $competition->title) }}" required>
                @error('title') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="slug">Slug</label>
                <input class="form-input" id="slug" name="slug" value="{{ old('slug', $competition->slug) }}" placeholder="otomatis jika kosong">
                @error('slug') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="category_id">Kategori</label>
                <select class="form-input" id="category_id" name="category_id" required>
                    <option value="">Pilih kategori</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" @selected(old('category_id', $competition->category_id) == $category->id)>{{ $category->name }}</option>
                    @endforeach
                </select>
                @error('category_id') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="status">Status</label>
                <select class="form-input" id="status" name="status" required>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->value }}" @selected(old('status', $competition->status?->value ?? 'draft') === $status->value)>{{ $status->label() }}</option>
                    @endforeach
                </select>
                @error('status') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label" for="description">Deskripsi</label>
            <textarea class="form-input min-h-40" id="description" name="description" required>{{ old('description', $competition->description) }}</textarea>
            @error('description') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            <div>
                <label class="form-label" for="registration_start">Mulai Pendaftaran</label>
                <input class="form-input" id="registration_start" type="datetime-local" name="registration_start" value="{{ old('registration_start', optional($competition->registration_start)->format('Y-m-d\TH:i')) }}" required>
                @error('registration_start') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="registration_end">Tutup Pendaftaran</label>
                <input class="form-input" id="registration_end" type="datetime-local" name="registration_end" value="{{ old('registration_end', optional($competition->registration_end)->format('Y-m-d\TH:i')) }}" required>
                @error('registration_end') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="event_date">Tanggal Lomba</label>
                <input class="form-input" id="event_date" type="date" name="event_date" value="{{ old('event_date', optional($competition->event_date)->format('Y-m-d')) }}">
                @error('event_date') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="form-label" for="quota">Kuota</label>
                <input class="form-input" id="quota" type="number" min="0" name="quota" value="{{ old('quota', $competition->quota ?? 0) }}">
                @error('quota') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="poster">Poster</label>
                <input class="form-input" id="poster" type="file" name="poster" @required(! $competition->exists)>
                @error('poster') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                @if ($competition->exists && $competition->poster)
                    <p class="mt-2 text-xs font-bold text-slate-500 dark:text-slate-400">Kosongkan jika tidak ingin mengganti poster.</p>
                @endif
            </div>
        </div>

        <div class="grid gap-5 lg:grid-cols-3">
            <div>
                <label class="form-label" for="requirements">Syarat Peserta</label>
                <textarea class="form-input min-h-44" id="requirements" name="requirements">{{ old('requirements', $competition->requirements) }}</textarea>
                @error('requirements') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="rules">Ketentuan</label>
                <textarea class="form-input min-h-44" id="rules" name="rules">{{ old('rules', $competition->rules) }}</textarea>
                @error('rules') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="prize">Hadiah</label>
                <textarea class="form-input min-h-44" id="prize" name="prize">{{ old('prize', $competition->prize) }}</textarea>
                @error('prize') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Simpan Lomba</button>
            <a href="{{ route('admin.competitions.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
@endsection
