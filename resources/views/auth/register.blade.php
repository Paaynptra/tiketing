<x-guest-layout>
    <div class="flex items-center justify-center min-h-screen bg-gray-50 px-4">
        <div class="w-full max-w-md bg-white shadow-lg rounded-lg p-6 border border-green-500">

            <!-- Judul -->
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-green-700">Form Registrasi</h1>
                <p class="text-sm text-gray-600">Silakan isi data Anda dengan benar</p>
            </div>

            <!-- Form -->
            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf

                <!-- Name -->
                <div>
                    <x-input-label for="name" :value="__('Name')" />
                    <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                    <x-input-error :messages="$errors->get('name')" class="mt-2" />
                </div>

                <!-- Email -->
                <div>
                    <x-input-label for="email" :value="__('Email')" />
                    <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
                    <x-input-error :messages="$errors->get('email')" class="mt-2" />
                </div>

                <!-- Password -->
                <div>
                    <x-input-label for="password" :value="__('Password')" />
                    <x-text-input id="password" class="block mt-1 w-full" type="password" name="password" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password')" class="mt-2" />
                </div>

                <!-- Confirm Password -->
                <div>
                    <x-input-label for="password_confirmation" :value="__('Confirm Password')" />
                    <x-text-input id="password_confirmation" class="block mt-1 w-full" type="password" name="password_confirmation" required autocomplete="new-password" />
                    <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
                </div>

                <!-- Tombol -->
                <div class="flex items-center justify-between pt-4 border-t border-green-200">
                    <a href="{{ route('login') }}"
                       class="inline-flex items-center px-4 py-2 rounded-md bg-gray-100 text-gray-700 hover:bg-gray-200 focus:ring-2 focus:ring-green-500">
                        Kembali
                    </a>
                    <x-primary-button class="ml-3 bg-green-600 hover:bg-green-700 focus:ring-green-500">
                        {{ __('Register') }}
                    </x-primary-button>
                </div>
            </form>
        </div>
    </div>
</x-guest-layout>
