<x-guest-layout>
    <div class="mb-6">
        <p class="text-sm font-black uppercase tracking-wider text-brand-red dark:text-brand-cream">Login Admin</p>
        <h1 class="mt-2 text-2xl font-black text-slate-950 dark:text-white">Masuk ke panel panitia.</h1>
        <p class="mt-2 text-sm leading-6 text-slate-600 dark:text-slate-300">Gunakan akun admin dari seeder untuk mengelola lomba, pendaftar, pengumuman, dan settings website.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <x-input-label for="email" value="Email" />
            <x-text-input id="email" class="mt-2 block w-full" type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <x-input-label for="password" value="Password" />
            <x-text-input id="password" class="mt-2 block w-full" type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <label for="remember_me" class="flex items-center gap-2 text-sm font-semibold text-slate-600 dark:text-slate-300">
            <input id="remember_me" type="checkbox" class="rounded border-slate-300 text-brand-red shadow-sm focus:ring-brand-red dark:border-white/10 dark:bg-slate-900" name="remember">
            Remember me
        </label>

        <div class="flex items-center justify-between gap-4">
            @if (Route::has('password.request'))
                <a class="text-sm font-bold text-brand-maroon transition-all duration-300 hover:text-brand-red dark:text-brand-cream dark:hover:text-white" href="{{ route('password.request') }}">
                    Lupa password?
                </a>
            @endif

            <x-primary-button>
                Login
            </x-primary-button>
        </div>
    </form>
</x-guest-layout>
