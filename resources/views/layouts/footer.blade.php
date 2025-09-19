<footer class="mt-10 bg-gradient-to-r from-brand-accent-600 to-brand-primary-700 text-white">
    <div class="max-w-7xl mx-auto px-4 py-8 grid sm:grid-cols-3 gap-6">
        <div>
            <div class="font-display text-lg">{{ config('app.name', 'E-Tiketing') }}</div>
            <p class="mt-2 text-sm text-white/90">{{ __('home.hero_subtitle') }}</p>
        </div>
        <div>
            <div class="font-semibold">{{ __('home.packages') }}</div>
            <ul class="mt-2 text-sm space-y-1">
                <li><a class="hover:underline" href="{{ route('packages') }}">{{ __('home.popular_packages') }}</a></li>
                <li><a class="hover:underline" href="{{ route('home') }}#rules">{{ __('home.before_visit') }}</a></li>
            </ul>
        </div>
        <div>
            <div class="font-semibold">{{ __('home.contact') }}</div>
            <ul class="mt-2 text-sm space-y-1">
                <li><a class="hover:underline" href="https://wa.me/6281234567890" target="_blank" rel="noopener">WhatsApp</a></li>
                <li><a class="hover:underline" href="mailto:support@lempuyang.test">Email</a></li>
            </ul>
        </div>
    </div>
</footer>

