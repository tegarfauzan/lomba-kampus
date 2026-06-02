@extends('layouts.public')

@section('title', 'Daftar ' . $competition->title . ' - ' . $setting->event_name)
@section('description', 'Form pendaftaran lomba ' . $competition->title)

@section('content')
    <section class="section-container grid gap-10 py-16 lg:grid-cols-[0.8fr_1.2fr]">
        <aside class="space-y-6">
            <div class="ui-card overflow-hidden">
                <img src="{{ $competition->posterUrl() }}" alt="Poster {{ $competition->title }}" class="h-64 w-full object-cover">
                <div class="p-6">
                    <span class="badge {{ $competition->status->badgeClasses() }}">{{ $competition->status->label() }}</span>
                    <h1 class="mt-4 text-2xl font-black text-slate-950 dark:text-white">{{ $competition->title }}</h1>
                    <p class="mt-3 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $competition->category->name }} | Tutup {{ $competition->registration_end->format('d M Y') }}</p>
                </div>
            </div>
        </aside>

        <form method="POST" action="{{ route('registrations.store', $competition) }}" enctype="multipart/form-data" class="ui-card space-y-8 p-8">
            @csrf
            <div>
                <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Form Pendaftaran</p>
                <h2 class="mt-2 text-3xl font-black text-slate-950 dark:text-white">Data tim dan ketua.</h2>
            </div>

            <div class="grid gap-5 md:grid-cols-2">
                <div class="md:col-span-2">
                    <label class="form-label" for="team_name">Nama Tim</label>
                    <input class="form-input" id="team_name" name="team_name" value="{{ old('team_name') }}" required>
                    @error('team_name') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="leader_name">Nama Ketua</label>
                    <input class="form-input" id="leader_name" name="leader_name" value="{{ old('leader_name') }}" required>
                    @error('leader_name') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="leader_email">Email Ketua</label>
                    <input class="form-input" id="leader_email" type="email" name="leader_email" value="{{ old('leader_email') }}" required>
                    @error('leader_email') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="leader_phone">Nomor WhatsApp</label>
                    <input class="form-input" id="leader_phone" name="leader_phone" value="{{ old('leader_phone') }}" placeholder="62812..." required>
                    @error('leader_phone') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="form-label" for="institution">Kampus</label>
                    <input class="form-input" id="institution" name="institution" value="{{ old('institution') }}" required>
                    @error('institution') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
                <div class="md:col-span-2">
                    <label class="form-label" for="major">Jurusan</label>
                    <input class="form-input" id="major" name="major" value="{{ old('major') }}">
                    @error('major') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="rounded-3xl bg-brand-soft p-5 dark:bg-white/5">
                <h3 class="font-black text-slate-950 dark:text-white">Anggota Tim</h3>
                <div class="mt-5 grid gap-4">
                    @for ($i = 0; $i < 3; $i++)
                        <div class="grid gap-3 rounded-2xl bg-white p-4 dark:bg-slate-900 md:grid-cols-2">
                            <input class="form-input" name="members[{{ $i }}][name]" value="{{ old("members.$i.name") }}" placeholder="Nama anggota {{ $i + 1 }}">
                            <input class="form-input" type="email" name="members[{{ $i }}][email]" value="{{ old("members.$i.email") }}" placeholder="Email anggota">
                            <input class="form-input" name="members[{{ $i }}][phone]" value="{{ old("members.$i.phone") }}" placeholder="Nomor WhatsApp">
                            <input class="form-input" name="members[{{ $i }}][major]" value="{{ old("members.$i.major") }}" placeholder="Jurusan">
                        </div>
                    @endfor
                </div>
            </div>

            <div>
                <label class="form-label" for="document_file">Upload Dokumen</label>
                <input class="form-input" id="document_file" type="file" name="document_file" required>
                <p class="mt-2 text-xs font-semibold text-slate-500 dark:text-slate-400">Format: PDF, DOC, DOCX, JPG, PNG. Maksimal 4 MB.</p>
                @error('document_file') <p class="mt-2 text-sm font-semibold text-red-600">{{ $message }}</p> @enderror
            </div>

            <label class="flex gap-3 rounded-2xl border border-slate-200 bg-white p-4 text-sm font-semibold text-slate-600 dark:border-white/10 dark:bg-slate-900 dark:text-slate-300">
                <input type="checkbox" name="terms" value="1" class="mt-1 rounded border-slate-300 text-brand-red focus:ring-brand-red" required>
                <span>Saya memastikan data yang dikirim benar dan bersedia mengikuti ketentuan lomba.</span>
            </label>
            @error('terms') <p class="text-sm font-semibold text-red-600">{{ $message }}</p> @enderror

            <button type="submit" class="btn-primary w-full">Kirim Pendaftaran</button>
        </form>
    </section>
@endsection
