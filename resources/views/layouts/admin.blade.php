<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>@yield('title', 'Admin') - {{ config('app.name') }}</title>

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />
        @vite(['build/assets/app-FnBGe-P1.css', 'build/assets/app-CpXTcIz4.js'])
    </head>
    <body class="font-sans">
        <div class="min-h-screen bg-brand-soft dark:bg-slate-950">
            <div class="grid min-h-screen lg:grid-cols-[280px_1fr]">
                <aside class="border-r border-white/70 bg-white/85 p-5 backdrop-blur dark:border-white/10 dark:bg-slate-900/85">
                    <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3">
                        <span class="flex h-12 w-12 items-center justify-center rounded-2xl bg-brand-maroon text-lg font-black text-brand-cream dark:bg-brand-cream dark:text-brand-maroon">KJ</span>
                        <span>
                            <span class="block text-sm font-black text-brand-maroon dark:text-brand-cream">Kampus Juara</span>
                            <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">Admin Panel</span>
                        </span>
                    </a>

                    <ul class="mt-8 space-y-2">
                        <li><a class="admin-link {{ request()->routeIs('admin.dashboard') ? 'admin-link-active' : '' }}" href="{{ route('admin.dashboard') }}">Dashboard</a></li>
                        <li><a class="admin-link {{ request()->routeIs('admin.competitions.*') ? 'admin-link-active' : '' }}" href="{{ route('admin.competitions.index') }}">Lomba</a></li>
                        <li><a class="admin-link {{ request()->routeIs('admin.categories.*') ? 'admin-link-active' : '' }}" href="{{ route('admin.categories.index') }}">Kategori</a></li>
                        <li><a class="admin-link {{ request()->routeIs('admin.registrations.*') ? 'admin-link-active' : '' }}" href="{{ route('admin.registrations.index') }}">Pendaftar</a></li>
                        <li><a class="admin-link {{ request()->routeIs('admin.announcements.*') ? 'admin-link-active' : '' }}" href="{{ route('admin.announcements.index') }}">Pengumuman</a></li>
                        <li><a class="admin-link {{ request()->routeIs('admin.settings.*') ? 'admin-link-active' : '' }}" href="{{ route('admin.settings.index') }}">Settings</a></li>
                    </ul>
                </aside>

                <div class="min-w-0">
                    <header class="sticky top-0 z-40 border-b border-white/70 bg-brand-soft/90 backdrop-blur dark:border-white/10 dark:bg-slate-950/85">
                        <div class="flex h-20 items-center justify-between gap-4 px-4 sm:px-6 lg:px-8">
                            <div>
                                <p class="text-xs font-bold uppercase tracking-wider text-brand-red dark:text-brand-cream">Admin</p>
                                <h1 class="text-xl font-black text-slate-900 dark:text-white">@yield('title', 'Dashboard')</h1>
                            </div>
                            <div class="flex items-center gap-3">
                                <button type="button" onclick="window.toggleTheme()" class="rounded-full border border-brand-maroon/20 bg-white px-4 py-2 text-sm font-bold text-brand-maroon transition-all duration-300 hover:border-brand-red hover:text-brand-red dark:border-white/15 dark:bg-slate-900 dark:text-brand-cream dark:hover:border-brand-cream dark:hover:text-white">Tema</button>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="rounded-full border border-brand-red bg-brand-red px-4 py-2 text-sm font-bold text-white transition-all duration-300 hover:border-brand-maroon hover:bg-brand-maroon">Logout</button>
                                </form>
                            </div>
                        </div>
                    </header>

                    <main class="px-4 py-8 sm:px-6 lg:px-8">
                        @if (session('success'))
                            <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-sm font-bold text-emerald-700 dark:border-emerald-900/60 dark:bg-emerald-950/50 dark:text-emerald-200">
                                {{ session('success') }}
                            </div>
                        @endif

                        @yield('content')
                    </main>
                </div>
            </div>
        </div>
    </body>
</html>
