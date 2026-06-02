@php
    $registered = $competition->registrations_count ?? 0;
    $quota = $competition->quota ?: null;
@endphp

<article class="ui-card ui-card-hover overflow-hidden">
    <a href="{{ route('competitions.show', $competition) }}" class="block">
        <img src="{{ $competition->posterUrl() }}" alt="Poster {{ $competition->title }}" class="h-52 w-full object-cover">
    </a>
    <div class="space-y-5 p-6">
        <div class="flex flex-wrap items-center gap-2">
            <span class="badge bg-brand-cream text-brand-maroon dark:bg-brand-maroon/70 dark:text-brand-cream">{{ $competition->category->name }}</span>
            <span class="badge {{ $competition->status->badgeClasses() }}">{{ $competition->status->label() }}</span>
        </div>
        <div>
            <h3 class="text-xl font-black text-slate-950 dark:text-white">{{ $competition->title }}</h3>
            <p class="mt-3 line-clamp-3 text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $competition->description }}</p>
        </div>
        <div class="grid gap-3 text-sm font-semibold text-slate-600 dark:text-slate-300 sm:grid-cols-2">
            <div class="rounded-2xl bg-brand-soft px-4 py-3 dark:bg-white/5">
                Tutup daftar<br>
                <span class="text-brand-maroon dark:text-brand-cream">{{ $competition->registration_end->format('d M Y') }}</span>
            </div>
            <div class="rounded-2xl bg-brand-soft px-4 py-3 dark:bg-white/5">
                Kuota<br>
                <span class="text-brand-maroon dark:text-brand-cream">{{ $quota ? "{$registered}/{$quota}" : "{$registered} tim" }}</span>
            </div>
        </div>
        <a href="{{ route('competitions.show', $competition) }}" class="btn-secondary w-full">Lihat Detail</a>
    </div>
</article>
