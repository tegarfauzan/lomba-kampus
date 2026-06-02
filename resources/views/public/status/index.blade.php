@extends('layouts.public')

@section('title', 'Cek Status Pendaftaran - ' . $setting->event_name)
@section('description', 'Cek status pendaftaran lomba menggunakan kode pendaftaran atau email ketua.')

@section('content')
    <section class="section-container grid gap-8 py-16 lg:grid-cols-[0.85fr_1.15fr]">
        <div>
            <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Cek status</p>
            <h1 class="mt-3 text-4xl font-black text-slate-950 dark:text-white">Pantau verifikasi tim tanpa login.</h1>
            <p class="mt-5 leading-8 text-slate-600 dark:text-slate-300">Masukkan kode pendaftaran atau email ketua. Jika ada beberapa pendaftaran dengan email yang sama, sistem menampilkan data terbaru.</p>
        </div>

        <div class="space-y-6">
            <form method="POST" action="{{ route('status.check') }}" class="ui-card space-y-5 p-6">
                @csrf
                <label class="form-label" for="keyword">Kode Pendaftaran atau Email</label>
                <input class="form-input" id="keyword" name="keyword" value="{{ old('keyword', $keyword ?? '') }}" placeholder="REG-UIU-2026-0001" required>
                @error('keyword') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                <button type="submit" class="btn-primary w-full">Cek Status</button>
            </form>

            @if (($keyword ?? null) && ! $registration)
                <div class="rounded-2xl border border-red-200 bg-red-50 p-5 text-sm font-bold text-red-700 dark:border-red-900/60 dark:bg-red-950/50 dark:text-red-200">Data tidak ditemukan. Periksa kembali kode atau email ketua.</div>
            @endif

            @if ($registration)
                <div class="ui-card p-6">
                    <span class="badge {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                    <h2 class="mt-4 text-2xl font-black text-slate-950 dark:text-white">{{ $registration->team_name }}</h2>
                    <dl class="mt-5 grid gap-4 text-sm sm:grid-cols-2">
                        <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                            <dt class="font-bold text-slate-500 dark:text-slate-400">Kode</dt>
                            <dd class="mt-1 font-black text-brand-maroon dark:text-brand-cream">{{ $registration->registration_code }}</dd>
                        </div>
                        <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                            <dt class="font-bold text-slate-500 dark:text-slate-400">Lomba</dt>
                            <dd class="mt-1 font-black text-brand-maroon dark:text-brand-cream">{{ $registration->competition->title }}</dd>
                        </div>
                    </dl>
                    @if ($registration->admin_note)
                        <div class="mt-5 rounded-2xl border border-brand-red/20 bg-brand-cream/60 p-4 text-sm leading-6 text-brand-maroon dark:border-brand-cream/20 dark:bg-brand-maroon/40 dark:text-brand-cream">
                            Catatan panitia: {{ $registration->admin_note }}
                        </div>
                    @endif
                </div>
            @endif
        </div>
    </section>
@endsection
