@extends('layouts.admin')

@section('title', 'Detail Lomba')

@section('content')
    <div class="grid gap-8 lg:grid-cols-[1fr_360px]">
        <article class="ui-card overflow-hidden">
            <img src="{{ $competition->posterUrl() }}" alt="Poster {{ $competition->title }}" class="h-80 w-full object-cover">
            <div class="space-y-6 p-6">
                <div class="flex flex-wrap gap-2">
                    <span class="badge bg-brand-cream text-brand-maroon dark:bg-brand-maroon/70 dark:text-brand-cream">{{ $competition->category->name }}</span>
                    <span class="badge {{ $competition->status->badgeClasses() }}">{{ $competition->status->label() }}</span>
                </div>
                <h2 class="text-3xl font-black text-slate-950 dark:text-white">{{ $competition->title }}</h2>
                <p class="whitespace-pre-line leading-8 text-slate-700 dark:text-slate-300">{{ $competition->description }}</p>
                <div class="grid gap-4 md:grid-cols-3">
                    <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                        <p class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Pendaftar</p>
                        <p class="mt-1 text-2xl font-black text-brand-maroon dark:text-brand-cream">{{ $competition->registrations_count }}</p>
                    </div>
                    <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                        <p class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Kuota</p>
                        <p class="mt-1 text-2xl font-black text-brand-maroon dark:text-brand-cream">{{ $competition->quota ?: 'Tidak dibatasi' }}</p>
                    </div>
                    <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                        <p class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Event</p>
                        <p class="mt-1 text-lg font-black text-brand-maroon dark:text-brand-cream">{{ $competition->event_date?->format('d M Y') ?? '-' }}</p>
                    </div>
                </div>
            </div>
        </article>

        <aside class="space-y-4">
            <a class="btn-primary w-full" href="{{ route('admin.competitions.edit', $competition) }}">Edit Lomba</a>
            <a class="btn-secondary w-full" href="{{ route('competitions.show', $competition) }}" target="_blank">Lihat Public</a>
            <a class="btn-secondary w-full" href="{{ route('admin.registrations.index', ['competition_id' => $competition->id]) }}">Lihat Pendaftar</a>
        </aside>
    </div>
@endsection
