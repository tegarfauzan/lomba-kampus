@extends('layouts.public')

@section('title', $announcement->title . ' - ' . $setting->event_name)
@section('description', str($announcement->content)->limit(150))

@section('content')
    <section class="section-container py-16">
        <article class="mx-auto max-w-4xl ui-card p-8">
            <div class="flex flex-wrap gap-2">
                @if ($announcement->is_important)
                    <span class="badge bg-brand-red text-white">Penting</span>
                @endif
                <span class="badge bg-brand-cream text-brand-maroon dark:bg-brand-maroon/70 dark:text-brand-cream">{{ $announcement->competition?->title ?? 'Umum' }}</span>
            </div>
            <h1 class="mt-6 text-4xl font-black text-slate-950 dark:text-white">{{ $announcement->title }}</h1>
            <p class="mt-3 text-sm font-bold text-slate-500 dark:text-slate-400">{{ $announcement->published_at->format('d M Y H:i') }}</p>
            <div class="mt-8 whitespace-pre-line text-base leading-8 text-slate-700 dark:text-slate-300">{{ $announcement->content }}</div>
            <a href="{{ route('announcements.index') }}" class="btn-secondary mt-8">Kembali</a>
        </article>
    </section>
@endsection
