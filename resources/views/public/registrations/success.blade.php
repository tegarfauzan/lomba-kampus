@extends('layouts.public')

@section('title', 'Pendaftaran Berhasil - ' . $setting->event_name)
@section('description', 'Pendaftaran berhasil dikirim.')

@section('content')
    <section class="section-container py-16">
        <div class="mx-auto max-w-3xl ui-card p-8 text-center">
            <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Pendaftaran berhasil</p>
            <h1 class="mt-3 text-4xl font-black text-slate-950 dark:text-white">Kode pendaftaranmu sudah dibuat.</h1>
            <div class="mx-auto mt-8 max-w-lg rounded-3xl border border-brand-red/20 bg-brand-cream/70 p-6 dark:border-brand-cream/30 dark:bg-brand-maroon/50">
                <p class="text-sm font-bold text-slate-600 dark:text-slate-200">Simpan kode ini untuk cek status</p>
                <p class="mt-3 break-all text-3xl font-black text-brand-maroon dark:text-brand-cream">{{ $registration->registration_code }}</p>
            </div>

            <div class="mt-8 grid gap-4 text-left sm:grid-cols-2">
                <div class="rounded-2xl bg-brand-soft p-5 dark:bg-white/5">
                    <p class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Lomba</p>
                    <p class="mt-1 font-black text-slate-900 dark:text-white">{{ $registration->competition->title }}</p>
                </div>
                <div class="rounded-2xl bg-brand-soft p-5 dark:bg-white/5">
                    <p class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">Tim</p>
                    <p class="mt-1 font-black text-slate-900 dark:text-white">{{ $registration->team_name }}</p>
                </div>
            </div>

            <div class="mt-8 flex flex-col justify-center gap-3 sm:flex-row">
                <a href="{{ route('status.index') }}" class="btn-primary">Cek Status</a>
                <a href="{{ route('home') }}" class="btn-secondary">Kembali ke Beranda</a>
            </div>
        </div>
    </section>
@endsection
