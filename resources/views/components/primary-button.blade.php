<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-brand-primary-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-brand-primary-700 focus:bg-brand-primary-700 active:bg-brand-primary-800 focus:outline-none focus:ring-2 focus:ring-brand-accent-500 focus:ring-offset-2 focus:ring-offset-white transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
