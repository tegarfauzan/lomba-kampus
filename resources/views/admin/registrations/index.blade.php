@extends('layouts.admin')

@section('title', 'Kelola Pendaftar')

@section('content')
    <form method="GET" action="{{ route('admin.registrations.index') }}" class="mb-6 grid gap-3 lg:grid-cols-[1fr_240px_220px_auto]">
        <input class="form-input" name="search" value="{{ request('search') }}" placeholder="Cari kode, tim, ketua, email">
        <select class="form-input" name="competition_id">
            <option value="">Semua lomba</option>
            @foreach ($competitions as $competition)
                <option value="{{ $competition->id }}" @selected(request('competition_id') == $competition->id)>{{ $competition->title }}</option>
            @endforeach
        </select>
        <select class="form-input" name="status">
            <option value="">Semua status</option>
            @foreach ($statuses as $status)
                <option value="{{ $status->value }}" @selected(request('status') === $status->value)>{{ $status->label() }}</option>
            @endforeach
        </select>
        <button class="btn-secondary" type="submit">Filter</button>
    </form>

    <div class="ui-card overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm">
                <thead class="bg-brand-soft text-xs uppercase text-slate-500 dark:bg-white/5 dark:text-slate-400">
                    <tr>
                        <th class="px-6 py-4">Kode</th>
                        <th class="px-6 py-4">Tim</th>
                        <th class="px-6 py-4">Lomba</th>
                        <th class="px-6 py-4">Status</th>
                        <th class="px-6 py-4 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-white/10">
                    @forelse ($registrations as $registration)
                        <tr>
                            <td class="px-6 py-4 font-black text-brand-maroon dark:text-brand-cream">{{ $registration->registration_code }}</td>
                            <td class="px-6 py-4">
                                <p class="font-black text-slate-900 dark:text-white">{{ $registration->team_name }}</p>
                                <p class="mt-1 text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $registration->leader_name }} | {{ $registration->leader_email }}</p>
                            </td>
                            <td class="px-6 py-4 text-slate-600 dark:text-slate-300">{{ $registration->competition->title }}</td>
                            <td class="px-6 py-4"><span class="badge {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span></td>
                            <td class="px-6 py-4">
                                <div class="flex justify-end gap-2">
                                    <a class="btn-secondary px-4 py-2" href="{{ route('admin.registrations.show', $registration) }}">Detail</a>
                                    <form method="POST" action="{{ route('admin.registrations.destroy', $registration) }}" onsubmit="return confirm('Hapus pendaftaran ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="btn-danger" type="submit">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" class="px-6 py-8 text-slate-500 dark:text-slate-400">Data pendaftar belum ada.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6">{{ $registrations->links() }}</div>
@endsection
