@extends('layouts.admin')

@section('title', $category->exists ? 'Edit Kategori' : 'Tambah Kategori')

@section('content')
    <form method="POST" action="{{ $category->exists ? route('admin.categories.update', $category) : route('admin.categories.store') }}" class="ui-card max-w-3xl space-y-5 p-6">
        @csrf
        @if ($category->exists)
            @method('PUT')
        @endif

        <div>
            <label class="form-label" for="name">Nama Kategori</label>
            <input class="form-input" id="name" name="name" value="{{ old('name', $category->name) }}" required>
            @error('name') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="form-label" for="slug">Slug</label>
            <input class="form-input" id="slug" name="slug" value="{{ old('slug', $category->slug) }}" placeholder="otomatis jika kosong">
            @error('slug') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="form-label" for="icon">Icon Label</label>
            <input class="form-input" id="icon" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="Design, Code, Essay">
            @error('icon') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>
        <div>
            <label class="form-label" for="description">Deskripsi</label>
            <textarea class="form-input min-h-32" id="description" name="description">{{ old('description', $category->description) }}</textarea>
            @error('description') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
        </div>

        <div class="flex gap-3">
            <button class="btn-primary" type="submit">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="btn-secondary">Batal</a>
        </div>
    </form>
@endsection
