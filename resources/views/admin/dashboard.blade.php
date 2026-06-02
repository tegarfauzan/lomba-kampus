@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-5">
        @foreach ([
            ['label' => 'Lomba Dibuka', 'value' => $open_competitions],
            ['label' => 'Total Pendaftar', 'value' => $total_registrations],
            ['label' => 'Pending', 'value' => $pending_registrations],
            ['label' => 'Diterima', 'value' => $approved_registrations],
            ['label' => 'Ditolak', 'value' => $rejected_registrations],
        ] as $stat)
            <div class="ui-card p-5">
                <p class="text-sm font-bold text-slate-500 dark:text-slate-400">{{ $stat['label'] }}</p>
                <p class="mt-3 text-3xl font-black text-brand-maroon dark:text-brand-cream">{{ $stat['value'] }}</p>
            </div>
        @endforeach
    </div>

    <div class="mt-8 grid gap-6 xl:grid-cols-2">
        <section class="ui-card p-6">
            <div class="mb-5 flex items-center justify-between gap-4">
                <h2 class="text-xl font-black text-slate-950 dark:text-white">Pendaftar Terbaru</h2>
                <a href="{{ route('admin.registrations.index') }}" class="btn-secondary px-4 py-2">Lihat Semua</a>
            </div>
            <div class="overflow-x-auto">
                <table class="w-full text-left text-sm">
                    <thead class="text-xs uppercase text-slate-500 dark:text-slate-400">
                        <tr>
                            <th class="py-3">Tim</th>
                            <th class="py-3">Lomba</th>
                            <th class="py-3">Status</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-white/10">
                        @forelse ($latest_registrations as $registration)
                            <tr>
                                <td class="py-4 font-bold text-slate-800 dark:text-slate-100">{{ $registration->team_name }}</td>
                                <td class="py-4 text-slate-600 dark:text-slate-300">{{ $registration->competition->title }}</td>
                                <td class="py-4"><span class="badge {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span></td>
                            </tr>
                        @empty
                            <tr><td colspan="3" class="py-6 text-slate-500 dark:text-slate-400">Belum ada pendaftar.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </section>

        <section class="ui-card p-6">
            <div class="mb-5 flex items-center justify-between gap-4">
                <h2 class="text-xl font-black text-slate-950 dark:text-white">Pengumuman Terbaru</h2>
                <a href="{{ route('admin.announcements.index') }}" class="btn-secondary px-4 py-2">Kelola</a>
            </div>
            <div class="grid gap-3">
                @forelse ($latest_announcements as $announcement)
                    <a href="{{ route('announcements.show', $announcement) }}" class="rounded-2xl border border-slate-100 bg-brand-soft p-4 transition-all duration-300 hover:border-brand-red dark:border-white/10 dark:bg-white/5">
                        <p class="text-xs font-bold text-slate-500 dark:text-slate-400">{{ $announcement->published_at->format('d M Y') }}</p>
                        <p class="mt-1 font-black text-slate-900 dark:text-white">{{ $announcement->title }}</p>
                    </a>
                @empty
                    <p class="text-slate-500 dark:text-slate-400">Belum ada pengumuman.</p>
                @endforelse
            </div>
        </section>
    </div>
@endsection
