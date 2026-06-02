@extends('layouts.public')

@section('title', 'Daftar Lomba - ' . $setting->event_name)
@section('description', 'Lihat semua lomba yang tersedia dan daftar bersama timmu.')

@section('content')
    <section class="section-container py-16">
        <div class="mb-10 max-w-3xl">
            <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Daftar lomba</p>
            <h1 class="mt-3 text-4xl font-black text-slate-950 dark:text-white">Temukan lomba yang paling cocok.</h1>
            <p class="mt-4 leading-7 text-slate-600 dark:text-slate-300">Setiap lomba punya timeline, syarat, dan kuota sendiri. Baca detail sebelum mendaftarkan tim.</p>
        </div>

        <div class="grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach ($competitions as $competition)
                @include('public.partials.competition-card', ['competition' => $competition])
            @endforeach
        </div>

        <div class="mt-10">
            {{ $competitions->links() }}
        </div>
    </section>
@endsection
