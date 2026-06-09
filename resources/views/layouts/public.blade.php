@php
    $pageTitle = trim($__env->yieldContent('title')) ?: ($setting->event_name ?? config('app.name'));
    $pageDescription = trim($__env->yieldContent('description')) ?: ($setting->description ?? 'Website pendaftaran lomba organisasi kampus.');
@endphp
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="description" content="{{ $pageDescription }}">

        <title>{{ $pageTitle }}</title>

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['public/build/assets/app-FnBGe-P1.css', 'public/build/assets/app-CpXTcIz4.js'])
    </head>
    <body class="font-sans">
        <div class="page-shell">
            <header class="sticky top-0 z-50 border-b border-white/70 bg-brand-soft/90 backdrop-blur dark:border-white/10 dark:bg-slate-950/85">
                <nav class="section-container flex h-20 items-center justify-between gap-6" aria-label="Navigasi utama">
                    <a href="{{ route('home') }}" class="flex items-center gap-3">
                        <span class="flex h-11 w-11 items-center justify-center rounded-2xl bg-brand-maroon text-lg font-black text-brand-cream shadow-soft dark:bg-brand-cream dark:text-brand-maroon">KJ</span>
                        <span class="leading-tight">
                            <span class="block text-sm font-black text-brand-maroon dark:text-brand-cream">{{ $setting->event_name ?? config('app.name') }}</span>
                            <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400">{{ $setting->organization_name ?? 'Organisasi Kampus' }}</span>
                        </span>
                    </a>

                    <ul class="hidden items-center gap-2 md:flex">
                        <li><a class="rounded-full px-4 py-2 text-sm font-bold text-slate-600 transition-all duration-300 hover:bg-white hover:text-brand-red dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-brand-cream" href="{{ route('home') }}">Beranda</a></li>
                        <li><a class="rounded-full px-4 py-2 text-sm font-bold text-slate-600 transition-all duration-300 hover:bg-white hover:text-brand-red dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-brand-cream" href="{{ route('competitions.index') }}">Lomba</a></li>
                        <li><a class="rounded-full px-4 py-2 text-sm font-bold text-slate-600 transition-all duration-300 hover:bg-white hover:text-brand-red dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-brand-cream" href="{{ route('announcements.index') }}">Pengumuman</a></li>
                        <li><a class="rounded-full px-4 py-2 text-sm font-bold text-slate-600 transition-all duration-300 hover:bg-white hover:text-brand-red dark:text-slate-300 dark:hover:bg-white/10 dark:hover:text-brand-cream" href="{{ route('status.index') }}">Cek Status</a></li>
                    </ul>

                    <div class="flex items-center gap-2">
                        <button type="button" onclick="window.toggleTheme()" class="group relative inline-flex h-11 w-11 items-center justify-center rounded-full border border-brand-maroon/20 bg-white transition-all duration-300 hover:border-brand-red active:scale-95 dark:border-white/15 dark:bg-slate-900" aria-label="Ubah tema">
                            <span class="relative h-5 w-5">
                                <svg class="absolute inset-0 h-5 w-5 text-brand-maroon opacity-100 transition-all duration-300 group-hover:opacity-0 dark:hidden" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 4V2m0 20v-2m8-8h2M2 12h2m14.95 6.95 1.41 1.41M3.64 3.64l1.41 1.41m0 13.9-1.41 1.41M20.36 3.64l-1.41 1.41" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/></svg>
                                <svg class="absolute inset-0 h-5 w-5 text-brand-red opacity-0 transition-all duration-300 group-hover:opacity-100 dark:hidden" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M12 4V2m0 20v-2m8-8h2M2 12h2m14.95 6.95 1.41 1.41M3.64 3.64l1.41 1.41m0 13.9-1.41 1.41M20.36 3.64l-1.41 1.41" stroke="currentColor" stroke-width="2" stroke-linecap="round"/><circle cx="12" cy="12" r="4" stroke="currentColor" stroke-width="2"/></svg>
                                <svg class="absolute inset-0 hidden h-5 w-5 text-brand-cream opacity-100 transition-all duration-300 group-hover:opacity-0 dark:block" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M21 13.6A8 8 0 1 1 10.4 3 6.5 6.5 0 0 0 21 13.6Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                                <svg class="absolute inset-0 hidden h-5 w-5 text-white opacity-0 transition-all duration-300 group-hover:opacity-100 dark:block" viewBox="0 0 24 24" fill="none" aria-hidden="true"><path d="M21 13.6A8 8 0 1 1 10.4 3 6.5 6.5 0 0 0 21 13.6Z" stroke="currentColor" stroke-width="2" stroke-linejoin="round"/></svg>
                            </span>
                        </button>
                        <a href="{{ route('login') }}" class="hidden rounded-full border border-brand-red bg-brand-red px-5 py-3 text-sm font-bold text-white transition-all duration-300 hover:border-brand-maroon hover:bg-brand-maroon active:translate-y-0 sm:inline-flex dark:border-brand-cream dark:bg-brand-cream dark:text-brand-maroon dark:hover:border-white dark:hover:bg-white">Admin</a>
                    </div>
                </nav>
            </header>

            <main>
                @yield('content')
            </main>

            <footer class="border-t border-white/70 bg-white/70 py-10 dark:border-white/10 dark:bg-slate-900/80">
                <div class="section-container grid gap-6 md:grid-cols-[1fr_auto] md:items-center">
                    <div>
                        <p class="text-lg font-black text-brand-maroon dark:text-brand-cream">{{ $setting->event_name ?? config('app.name') }}</p>
                        <p class="mt-2 max-w-2xl text-sm leading-6 text-slate-600 dark:text-slate-300">{{ $setting->footer_text ?? $setting->description ?? 'Website lomba organisasi kampus.' }}</p>
                    </div>
                    <div class="text-sm font-semibold text-slate-500 dark:text-slate-400">
                        {{ $setting->contact_email ?? 'panitia@kampus.test' }}
                    </div>
                </div>
            </footer>
        </div>
    </body>
</html>
