@extends('layouts.public')

@section('title', 'Pengumuman - ' . $setting->event_name)
@section('description', 'Pengumuman resmi dari panitia lomba.')

@section('content')
    <section class="section-container py-16">
        <div class="mb-8 flex flex-col justify-between gap-5 lg:flex-row lg:items-end">
            <div>
                <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Pengumuman</p>
                <h1 class="mt-3 text-4xl font-black text-slate-950 dark:text-white">Informasi resmi panitia.</h1>
            </div>
            <form method="GET" action="{{ route('announcements.index') }}" class="flex gap-3">
                <select name="competition_id" class="form-input min-w-56">
                    <option value="">Semua lomba</option>
                    @foreach ($competitions as $competition)
                        <option value="{{ $competition->id }}" @selected(request('competition_id') == $competition->id)>{{ $competition->title }}</option>
                    @endforeach
                </select>
                <button class="btn-secondary" type="submit">Filter</button>
            </form>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($announcements as $announcement)
                <a href="{{ route('announcements.show', $announcement) }}" class="ui-card ui-card-hover p-6">
                    <div class="flex flex-wrap gap-2">
                        @if ($announcement->is_important)
                            <span class="badge bg-brand-red text-white">Penting</span>
                        @endif
                        <span class="badge bg-brand-cream text-brand-maroon dark:bg-brand-maroon/70 dark:text-brand-cream">{{ $announcement->competition?->title ?? 'Umum' }}</span>
                    </div>
                    <h2 class="mt-5 text-xl font-black text-slate-950 dark:text-white">{{ $announcement->title }}</h2>
                    <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $announcement->content }}</p>
                    <p class="mt-5 text-xs font-bold text-slate-500 dark:text-slate-400">{{ $announcement->published_at->format('d M Y') }}</p>
                </a>
            @empty
                <div class="ui-card p-8 text-slate-600 dark:text-slate-300">Belum ada pengumuman.</div>
            @endforelse
        </div>

        <div class="mt-10">{{ $announcements->links() }}</div>
    </section>
@endsection
