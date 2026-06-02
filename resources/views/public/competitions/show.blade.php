@extends('layouts.public')

@section('title', $competition->title . ' - ' . $setting->event_name)
@section('description', str($competition->description)->limit(150))

@section('content')
    <section class="section-container grid gap-10 py-16 lg:grid-cols-[1fr_380px]">
        <article class="space-y-8">
            <img src="{{ $competition->posterUrl() }}" alt="Poster {{ $competition->title }}" class="h-[420px] w-full rounded-3xl object-cover shadow-soft">

            <div class="ui-card p-8">
                <div class="mb-5 flex flex-wrap gap-2">
                    <span class="badge bg-brand-cream text-brand-maroon dark:bg-brand-maroon/70 dark:text-brand-cream">{{ $competition->category->name }}</span>
                    <span class="badge {{ $competition->status->badgeClasses() }}">{{ $competition->status->label() }}</span>
                </div>
                <h1 class="text-4xl font-black text-slate-950 dark:text-white">{{ $competition->title }}</h1>
                <p class="mt-6 whitespace-pre-line leading-8 text-slate-700 dark:text-slate-300">{{ $competition->description }}</p>
            </div>

            @foreach ([['Syarat Peserta', $competition->requirements], ['Ketentuan Lomba', $competition->rules], ['Hadiah', $competition->prize]] as [$title, $body])
                @if ($body)
                    <section class="ui-card p-8">
                        <h2 class="text-2xl font-black text-brand-maroon dark:text-brand-cream">{{ $title }}</h2>
                        <p class="mt-5 whitespace-pre-line leading-8 text-slate-700 dark:text-slate-300">{{ $body }}</p>
                    </section>
                @endif
            @endforeach
        </article>

        <aside class="space-y-6 lg:sticky lg:top-28 lg:self-start">
            <div class="ui-card p-6">
                <h2 class="text-xl font-black text-slate-950 dark:text-white">Ringkasan</h2>
                <dl class="mt-5 grid gap-4 text-sm">
                    <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                        <dt class="font-bold text-slate-500 dark:text-slate-400">Pendaftaran</dt>
                        <dd class="mt-1 font-black text-brand-maroon dark:text-brand-cream">{{ $competition->registration_start->format('d M Y') }} - {{ $competition->registration_end->format('d M Y') }}</dd>
                    </div>
                    <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                        <dt class="font-bold text-slate-500 dark:text-slate-400">Tanggal Lomba</dt>
                        <dd class="mt-1 font-black text-brand-maroon dark:text-brand-cream">{{ $competition->event_date?->format('d M Y') ?? 'Segera diumumkan' }}</dd>
                    </div>
                    <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                        <dt class="font-bold text-slate-500 dark:text-slate-400">Kuota</dt>
                        <dd class="mt-1 font-black text-brand-maroon dark:text-brand-cream">{{ $competition->quota ? $competition->registrations_count . '/' . $competition->quota . ' tim' : $competition->registrations_count . ' tim terdaftar' }}</dd>
                    </div>
                </dl>

                @if ($competition->acceptsRegistrations())
                    <a href="{{ route('registrations.create', $competition) }}" class="btn-primary mt-6 w-full">Daftar Sekarang</a>
                @else
                    <div class="mt-6 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-sm font-bold text-amber-700 dark:border-amber-900/60 dark:bg-amber-950/50 dark:text-amber-200">Pendaftaran lomba ini sedang tidak dibuka.</div>
                @endif
            </div>
        </aside>
    </section>
@endsection
