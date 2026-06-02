@extends('layouts.admin')

@section('title', 'Kelola Lomba')

@section('content')
    <div class="mb-6 grid gap-4 lg:grid-cols-[1fr_auto] lg:items-center">
        <form method="GET" action="{{ route('admin.competitions.index') }}" class="flex flex-col gap-3 sm:flex-row">
            <input class="form-input sm:w-80" name="search" value="{{ request('search') }}" placeholder="Cari judul lomba">
            <select class="form-input sm:w-56" name="status">
                <option value="">Semua status</option>
                @foreach ($statuses as $status)
                    <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
                @endforeach
            </select>
            <button class="btn-secondary" type="submit">Filter</button>
        </form>
        <a href="{{ route('admin.competitions.create') }}" class="btn-primary">Tambah Lomba</a>
    </div>

    <div class="grid gap-5">
        @foreach ($competitions as $competition)
            <article class="ui-card grid gap-5 overflow-hidden p-4 md:grid-cols-[220px_1fr_auto] md:items-center">
                <img src="{{ $competition->posterUrl() }}" alt="Poster {{ $competition->title }}" class="h-44 w-full rounded-2xl object-cover md:h-32">
                <div>
                    <div class="flex flex-wrap gap-2">
                        <span class="badge bg-brand-cream text-brand-maroon dark:bg-brand-maroon/70 dark:text-brand-cream">{{ $competition->category->name }}</span>
                        <span class="badge {{ $competition->status->badgeClasses() }}">{{ $competition->status->label() }}</span>
                    </div>
                    <h2 class="mt-3 text-xl font-black text-slate-950 dark:text-white">{{ $competition->title }}</h2>
                    <p class="mt-2 line-clamp-2 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $competition->description }}</p>
                    <p class="mt-3 text-xs font-bold text-slate-500 dark:text-slate-400">{{ $competition->registrations_count }} pendaftar | {{ $competition->registration_start->format('d M Y') }} - {{ $competition->registration_end->format('d M Y') }}</p>
                </div>
                <div class="flex flex-wrap gap-2 md:justify-end">
                    <a class="btn-secondary px-4 py-2" href="{{ route('admin.competitions.show', $competition) }}">Detail</a>
                    <a class="btn-secondary px-4 py-2" href="{{ route('admin.competitions.edit', $competition) }}">Edit</a>
                    <form method="POST" action="{{ route('admin.competitions.destroy', $competition) }}" onsubmit="return confirm('Hapus lomba ini?')">
                        @csrf
                        @method('DELETE')
                        <button class="btn-danger" type="submit">Hapus</button>
                    </form>
                </div>
            </article>
        @endforeach
    </div>

    <div class="mt-6">{{ $competitions->links() }}</div>
@endsection
