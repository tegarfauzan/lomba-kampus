<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Admin Login - {{ config('app.name', 'Laravel') }}</title>

        <script>
            if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
                document.documentElement.classList.add('dark');
            }
        </script>
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=plus-jakarta-sans:400,500,600,700,800&display=swap" rel="stylesheet" />

        @vite(['build/assets/app-FnBGe-P1.css', 'build/assets/app-CpXTcIz4.js'])
    </head>
    <body class="font-sans text-slate-900 antialiased dark:text-slate-100">
        <div class="flex min-h-screen flex-col items-center justify-center bg-brand-soft px-4 py-10 dark:bg-slate-950">
            <div class="mb-6 text-center">
                <a href="/" class="inline-flex items-center gap-3">
                    <span class="flex h-14 w-14 items-center justify-center rounded-2xl bg-brand-maroon text-xl font-black text-brand-cream shadow-soft dark:bg-brand-cream dark:text-brand-maroon">KJ</span>
                    <span class="text-left">
                        <span class="block text-base font-black text-brand-maroon dark:text-brand-cream">Kampus Juara</span>
                        <span class="block text-xs font-semibold text-slate-500 dark:text-slate-400">Admin Panitia</span>
                    </span>
                </a>
            </div>

            <div class="w-full max-w-md overflow-hidden rounded-3xl border border-white/70 bg-white/90 px-6 py-6 shadow-soft backdrop-blur dark:border-white/10 dark:bg-slate-900/80">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
