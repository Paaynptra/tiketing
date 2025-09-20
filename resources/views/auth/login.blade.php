<x-guest-layout>
    <!-- Status Session -->
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <!-- Judul -->
    <h2 class="text-center text-2xl font-bold text-green-700 mb-6">
        Login ke Akun
    </h2>

    <!-- Form Login -->
    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <!-- Email Address -->
        <div>
            <x-input-label for="email" :value="__('Email')" class="text-green-800" />
            <x-text-input id="email"
                          class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                          type="email" name="email" :value="old('email')" required autofocus autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div>
            <x-input-label for="password" :value="__('Password')" class="text-green-800" />
            <x-text-input id="password"
                          class="block mt-1 w-full rounded-md border-gray-300 shadow-sm focus:border-green-500 focus:ring-green-500"
                          type="password" name="password" required autocomplete="current-password" />
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Remember Me + Forgot Password -->
        <div class="flex items-center justify-between">
            <label for="remember_me" class="flex items-center">
                <input id="remember_me" type="checkbox"
                       class="rounded border-gray-300 text-green-600 shadow-sm focus:ring-green-500"
                       name="remember">
                <span class="ml-2 text-sm text-gray-700">
                    {{ __('Remember me') }}
                </span>
            </label>

            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}"
                   class="text-sm text-green-700 hover:text-green-900 underline">
                    {{ __('Forgot your password?') }}
                </a>
            @endif
        </div>

        <!-- Login Button -->
        <div class="mt-6">
            <x-primary-button
                class="w-full justify-center px-5 py-2 bg-green-600 hover:bg-green-700 focus:ring-green-500 text-white font-semibold rounded-md shadow">
                {{ __('Log in') }}
            </x-primary-button>
        </div>
    </form>

    <!-- Register + Back Button -->
    <div class="mt-8 flex flex-col sm:flex-row sm:justify-center sm:gap-4">

         <a href="{{ url('/') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2 text-sm font-medium rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm">
             {{ __('Kembali') }}
        </a>
        <!-- Register -->
        <a href="{{ route('register') }}"
           class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2 text-sm font-medium rounded-md border border-green-400 text-green-700 hover:bg-green-50 focus:outline-none focus:ring-2 focus:ring-green-500 shadow-sm">
             {{ __('Belum punya akun? Daftar') }}
        </a>


    </div>
</x-guest-layout>
