<header class="bg-white/80 backdrop-blur supports-[backdrop-filter]:bg-white/60 border-b border-warm-200">
    <div class="max-w-7xl mx-auto px-4 py-4 flex items-center justify-between">
        <a href="{{ url('/') }}" class="text-lg font-display font-semibold text-brand-primary-700">{{ config('app.name', 'E-Tiketing') }}</a>
        <nav class="hidden md:flex gap-6 text-sm">
            <a class="text-warm-700 hover:text-warm-900 focus:outline-none focus:ring-2 focus:ring-brand-accent-500 rounded" href="{{ route('packages') }}">{{ __('home.packages') }}</a>
            <a class="text-warm-700 hover:text-warm-900 focus:outline-none focus:ring-2 focus:ring-brand-accent-500 rounded" href="/#rules">{{ __('home.rules') }}</a>
            <a class="text-warm-700 hover:text-warm-900 focus:outline-none focus:ring-2 focus:ring-brand-accent-500 rounded" href="/#contact">{{ __('home.contact') }}</a>
        </nav>
        <div class="flex items-center gap-3">
            <a href="{{ route('booking.index') }}" class="inline-flex items-center px-4 py-2 bg-brand-primary-600 text-white rounded-md shadow hover:bg-brand-primary-700 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('home.cta') }}</a>
            @if (Route::has('login'))
                @auth
                    <x-dropdown align="right" width="48">
                        <x-slot name="trigger">
                            <button class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-warm-700 bg-white hover:text-warm-900 focus:outline-none focus:ring-2 focus:ring-brand-accent-500 transition ease-in-out duration-150">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                            </button>
                        </x-slot>

                        <x-slot name="content">
                            @if (Auth::user()->role === 'admin')
                                <x-dropdown-link :href="route('admin.dashboard')">
                                    {{ __('Admin') }}
                                </x-dropdown-link>
                            @endif
                            <x-dropdown-link :href="route('booking.history')">
                                {{ __('History') }}
                            </x-dropdown-link>
                            <x-dropdown-link :href="route('profile.edit')">
                                {{ __('Profile') }}
                            </x-dropdown-link>

                            <!-- Authentication -->
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf

                                <x-dropdown-link :href="route('logout')"
                                        onclick="event.preventDefault();
                                                    this.closest('form').submit();">
                                    {{ __('Log Out') }}
                                </x-dropdown-link>
                            </form>
                        </x-slot>
                    </x-dropdown>
                @else
                    <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 border border-warm-300 text-warm-800 rounded-md hover:bg-warm-50 focus:outline-none focus:ring-2 focus:ring-brand-accent-500">{{ __('home.login') }}</a>
                @endauth
            @endif
        </div>
    </div>
</header>
