@extends('layouts.public')

@section('title', $setting->event_name . ' - Website Lomba Kampus')
@section('description', $setting->description)

@section('content')
    <section class="relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://images.unsplash.com/photo-1523580494863-6f3031224c94?auto=format&fit=crop&w=1800&q=80')] bg-cover bg-center"></div>
        <div class="absolute inset-0 bg-gradient-to-r from-brand-maroon/95 via-brand-maroon/82 to-brand-red/50 dark:from-slate-950 dark:via-slate-950/88 dark:to-brand-maroon/65"></div>
        <div class="section-container relative grid min-h-[calc(100vh-5rem)] items-center gap-10 py-20 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="max-w-3xl animate-fade-up text-white">
                <p class="mb-4 inline-flex rounded-full border border-brand-cream/40 bg-white/10 px-4 py-2 text-sm font-bold text-brand-cream backdrop-blur">Pendaftaran lomba kampus terpadu</p>
                <h1 class="text-4xl font-black leading-tight sm:text-5xl lg:text-6xl">{{ $setting->event_name }}</h1>
                <p class="mt-6 max-w-2xl text-base leading-8 text-brand-soft/95 sm:text-lg">{{ $setting->description }}</p>
                <div class="mt-8 flex flex-col gap-3 sm:flex-row">
                    <a href="{{ route('competitions.index') }}" class="btn-primary bg-brand-cream text-brand-maroon hover:bg-white">Lihat Lomba</a>
                    <a href="{{ route('status.index') }}" class="btn-secondary border-white/40 bg-white/10 text-white hover:bg-white hover:text-brand-maroon dark:border-white/40 dark:bg-white/10">Cek Status</a>
                </div>
            </div>

            <div class="hidden animate-float rounded-3xl border border-white/20 bg-white/12 p-6 text-white shadow-soft backdrop-blur lg:block">
                <p class="text-sm font-bold uppercase tracking-wider text-brand-cream">Flow Peserta</p>
                <div class="mt-5 grid gap-3">
                    @foreach (['Landing Page', 'Detail Lomba', 'Form Pendaftaran', 'Generate Kode', 'Cek Status'] as $step)
                        <div class="rounded-2xl border border-white/15 bg-white/10 px-5 py-4 font-bold">{{ $loop->iteration }}. {{ $step }}</div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="section-container py-20">
        <div class="mb-10 flex flex-col justify-between gap-5 md:flex-row md:items-end">
            <div>
                <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Lomba tersedia</p>
                <h2 class="mt-3 text-3xl font-black text-slate-950 dark:text-white">Pilih panggung terbaik untuk timmu.</h2>
            </div>
            <a href="{{ route('competitions.index') }}" class="btn-secondary">Semua Lomba</a>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($competitions as $competition)
                @include('public.partials.competition-card', ['competition' => $competition])
            @empty
                <div class="ui-card p-8 text-slate-600 dark:text-slate-300">Belum ada lomba yang dipublikasikan.</div>
            @endforelse
        </div>
    </section>

    <section class="bg-white/70 py-20 dark:bg-slate-900/60">
        <div class="section-container grid gap-8 lg:grid-cols-3">
            @foreach ([
                ['title' => 'Informasi Jelas', 'body' => 'Peserta bisa membaca deskripsi, syarat, hadiah, timeline, dan status lomba dalam satu tempat.'],
                ['title' => 'Daftar Tanpa Akun', 'body' => 'MVP dibuat ringan: peserta cukup menyimpan kode pendaftaran untuk cek status.'],
                ['title' => 'Verifikasi Panitia', 'body' => 'Admin bisa memantau pending, menerima, menolak, dan memberi catatan agar komunikasi tetap rapi.'],
            ] as $benefit)
                <div class="ui-card p-7">
                    <h3 class="text-xl font-black text-brand-maroon dark:text-brand-cream">{{ $benefit['title'] }}</h3>
                    <p class="mt-4 leading-7 text-slate-600 dark:text-slate-300">{{ $benefit['body'] }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="section-container grid gap-10 py-20 lg:grid-cols-[0.9fr_1.1fr]">
        <div>
            <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Timeline umum</p>
            <h2 class="mt-3 text-3xl font-black text-slate-950 dark:text-white">Alur dari daftar sampai pengumuman.</h2>
        </div>
        <div class="grid gap-4">
            @foreach (['Pilih lomba dan baca ketentuan', 'Isi data tim dan upload dokumen', 'Panitia memverifikasi pendaftaran', 'Peserta cek status memakai kode', 'Pengumuman final dipublikasikan'] as $step)
                <div class="ui-card flex gap-4 p-5">
                    <span class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-brand-maroon text-sm font-black text-brand-cream dark:bg-brand-cream dark:text-brand-maroon">{{ $loop->iteration }}</span>
                    <p class="font-bold text-slate-700 dark:text-slate-200">{{ $step }}</p>
                </div>
            @endforeach
        </div>
    </section>

    <section class="bg-brand-maroon py-20 text-white dark:bg-slate-900">
        <div class="section-container grid gap-10 lg:grid-cols-[0.8fr_1.2fr]">
            <div>
                <p class="text-sm font-black uppercase tracking-wider text-brand-cream">Pengumuman</p>
                <h2 class="mt-3 text-3xl font-black">Info terbaru dari panitia.</h2>
            </div>
            <div class="grid gap-4">
                @forelse ($announcements as $announcement)
                    <a href="{{ route('announcements.show', $announcement) }}" class="rounded-2xl border border-white/15 bg-white/10 p-5 transition-all duration-300 hover:border-brand-cream hover:bg-white/15">
                        <span class="text-xs font-bold text-brand-cream">{{ $announcement->published_at->format('d M Y') }}</span>
                        <h3 class="mt-2 font-black">{{ $announcement->title }}</h3>
                    </a>
                @empty
                    <p class="rounded-2xl border border-white/15 bg-white/10 p-5">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </div>
    </section>

    <section class="section-container py-20">
        <div class="ui-card grid gap-8 p-8 lg:grid-cols-[1fr_auto] lg:items-center">
            <div>
                <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Siap daftar?</p>
                <h2 class="mt-3 text-3xl font-black text-slate-950 dark:text-white">Bawa ide terbaikmu ke panggung kampus.</h2>
                <p class="mt-4 max-w-2xl leading-7 text-slate-600 dark:text-slate-300">Pilih lomba, siapkan data tim, upload dokumen, lalu simpan kode pendaftaran setelah submit.</p>
            </div>
            <a href="{{ route('competitions.index') }}" class="btn-primary">Daftar Sekarang</a>
        </div>
    </section>
@endsection
