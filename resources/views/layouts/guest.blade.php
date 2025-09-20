<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:ital,wght@0,600;0,700;1,600&display=swap" rel="stylesheet">

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
  <body class="font-sans text-warm-900 antialiased">
    <a href="#main"
       class="sr-only focus:not-sr-only focus:absolute focus:top-2 focus:left-2 focus:z-50 bg-white text-warm-900 px-3 py-2 rounded-md shadow focus:outline-none focus:ring-2 focus:ring-brand-accent-500">
       Skip to main content
    </a>

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-br from-green-50 via-green-100 to-green-200">
        <div>
            <a href="/">
                <x-application-logo class="w-20 h-20 fill-current text-green-600" />
            </a>
        </div>

        <main id="main"
              class="w-full sm:max-w-md mt-6 px-6 py-6 bg-white shadow-lg overflow-hidden sm:rounded-lg ring-1 ring-green-200">
            {{ $slot }}
        </main>
    </div>
</body>

</html>
