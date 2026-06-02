@extends('layouts.admin')

@section('title', $announcement->exists ? 'Edit Pengumuman' : 'Tambah Pengumuman')

@section('content')
    <form method="POST" action="{{ $announcement->exists ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}" class="ui-card max-w-5xl space-y-6 p-6">
        @csrf
        @if ($announcement->exists)
            @method('PUT')
        @endif

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="form-label" for="title">Judul</label>
                <input class="form-input" id="title" name="title" value="{{ old('title', $announcement->title) }}" required>
                @error('title') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="slug">Slug</label>
                <input class="form-input" id="slug" name="slug" value="{{ old('slug', $announcement->slug) }}" placeholder="otomatis jika kosong">
                @error('slug') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div class="grid gap-5 lg:grid-cols-2">
            <div>
                <label class="form-label" for="competition_id">Lomba Terkait</label>
                <select class="form-input" id="competition_id" name="competition_id">
                    <option value="">Umum</option>
                    @foreach ($competitions as $competition)
                        <option value="{{ $competition->id }}" @selected(old('competition_id', $announcement->competition_id) == $competition->id)>{{ $competition->title }}</option>
                    @endforeach
                </select>
                @error('competition_id') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
            <div>
                <label class="form-label" for="published_at">Tanggal Publish</label>
                <input class="form-input" id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', optional($announcement->published_at)->format('Y-m-d\TH:i')) }}">
                @error('published_at') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>
        </div>

        <div>
            <label class="form-label" for="content">Konten</label>
            <textarea class="form-input min-h-64" id="content" name="content" required>{{ old('content', $announcement->content) }}</textarea>
            @error('content') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="grid gap-3 sm:grid-cols-2">
            <label class="flex gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-bold text-slate-700 dark:border-white/10 dark:bg-slate-900 dark:text-slate-200">
                <input type="checkbox" name="is_published" value="1" class="rounded border-slate-300 text-brand-red focus:ring-brand-red" @checked(old('is_published', $announcement->is_published))>
                Publish pengumuman
            </label>
            <label class="flex gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-bold text-slate-700 dark:border-white/10 dark:bg-slate-900 dark:text-slate-200">
                <input type="checkbox" name="is_important" value="1" class="rounded border-slate-300 text-brand-red focus:ring-brand-red" @checked(old('is_important', $announcement->is_important))>
                Tandai penting
            </label>
        </div>

        <div class="flex flex-wrap gap-3">
            <button class="btn-primary" type="submit">Simpan Pengumuman</button>
            <a href="{{ route('admin.announcements.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
@endsection
