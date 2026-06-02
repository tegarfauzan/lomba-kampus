@extends('layouts.admin')

@section('title', 'Detail Pendaftar')

@section('content')
    <div class="grid gap-8 xl:grid-cols-[1fr_380px]">
        <section class="space-y-6">
            <div class="ui-card p-6">
                <div class="flex flex-wrap items-center justify-between gap-3">
                    <div>
                        <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">{{ $registration->registration_code }}</p>
                        <h2 class="mt-2 text-3xl font-black text-slate-950 dark:text-white">{{ $registration->team_name }}</h2>
                    </div>
                    <span class="badge {{ $registration->status->badgeClasses() }}">{{ $registration->status->label() }}</span>
                </div>
            </div>

            <div class="ui-card p-6">
                <h3 class="text-xl font-black text-slate-950 dark:text-white">Data Ketua</h3>
                <dl class="mt-5 grid gap-4 md:grid-cols-2">
                    @foreach ([
                        'Nama' => $registration->leader_name,
                        'Email' => $registration->leader_email,
                        'WhatsApp' => $registration->leader_phone,
                        'Kampus' => $registration->institution,
                        'Jurusan' => $registration->major ?: '-',
                        'Lomba' => $registration->competition->title,
                    ] as $label => $value)
                        <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                            <dt class="text-xs font-bold uppercase text-slate-500 dark:text-slate-400">{{ $label }}</dt>
                            <dd class="mt-1 font-black text-slate-900 dark:text-white">{{ $value }}</dd>
                        </div>
                    @endforeach
                </dl>
            </div>

            <div class="ui-card p-6">
                <h3 class="text-xl font-black text-slate-950 dark:text-white">Anggota Tim</h3>
                <div class="mt-5 grid gap-3">
                    @forelse ($registration->members as $member)
                        <div class="rounded-2xl bg-brand-soft p-4 dark:bg-white/5">
                            <p class="font-black text-slate-900 dark:text-white">{{ $member->name }}</p>
                            <p class="mt-1 text-sm text-slate-600 dark:text-slate-300">{{ $member->email ?: '-' }} | {{ $member->phone ?: '-' }} | {{ $member->major ?: '-' }}</p>
                        </div>
                    @empty
                        <p class="text-slate-500 dark:text-slate-400">Tidak ada anggota tambahan.</p>
                    @endforelse
                </div>
            </div>
        </section>

        <aside class="space-y-5">
            <div class="ui-card p-6">
                <h3 class="text-xl font-black text-slate-950 dark:text-white">Verifikasi</h3>
                @if ($registration->admin_note)
                    <p class="mt-4 rounded-2xl bg-brand-soft p-4 text-sm leading-6 text-slate-700 dark:bg-white/5 dark:text-slate-300">{{ $registration->admin_note }}</p>
                @endif

                <form method="POST" action="{{ route('admin.registrations.approve', $registration) }}" class="mt-5 space-y-3">
                    @csrf
                    @method('PATCH')
                    <textarea class="form-input min-h-24" name="admin_note" placeholder="Catatan opsional">{{ old('admin_note') }}</textarea>
                    <button class="btn-primary w-full" type="submit">Approve</button>
                </form>

                <form method="POST" action="{{ route('admin.registrations.reject', $registration) }}" class="mt-4 space-y-3">
                    @csrf
                    @method('PATCH')
                    <textarea class="form-input min-h-24" name="admin_note" placeholder="Catatan wajib untuk reject" required>{{ old('admin_note') }}</textarea>
                    @error('admin_note') <p class="text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                    <button class="btn-danger w-full" type="submit">Reject</button>
                </form>
            </div>

            <div class="ui-card p-6">
                <h3 class="text-xl font-black text-slate-950 dark:text-white">Dokumen</h3>
                @if ($registration->document_file)
                    <a class="btn-secondary mt-4 w-full" href="{{ route('admin.registrations.download', $registration) }}">Download Dokumen</a>
                @else
                    <p class="mt-4 text-sm text-slate-500 dark:text-slate-400">Tidak ada dokumen.</p>
                @endif
            </div>
        </aside>
    </div>
@endsection
