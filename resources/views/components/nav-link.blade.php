@props(['active'])

@php
$classes = ($active ?? false)
            ? 'inline-flex items-center px-1 pt-1 border-b-2 border-brand-gold-500 text-sm font-medium leading-5 text-warm-900 focus:outline-none focus:border-brand-accent-600 transition duration-150 ease-in-out'
            : 'inline-flex items-center px-1 pt-1 border-b-2 border-transparent text-sm font-medium leading-5 text-warm-600 hover:text-warm-800 hover:border-warm-300 focus:outline-none focus:text-warm-800 focus:border-warm-300 transition duration-150 ease-in-out';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
