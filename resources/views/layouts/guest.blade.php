<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>
        <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased">

    <div class="min-h-screen bg-[#b8c2cc] flex items-center justify-center px-4">

        <div class="w-[900px] min-h-[440px] bg-gray-800 rounded-2xl shadow-xl overflow-hidden grid grid-cols-2">

            <!-- COLONNA SINISTRA -->
<div class="bg-white flex flex-col items-center justify-center p-10 text-center">

    <img
        src="{{ asset('images/Poliba_stemma.png') }}"
        alt="Politecnico di Bari"
        class="h-48 w-auto mb-6"
    >

    <h2 class="text-2xl font-bold text-teal-600 mb-3">
        Politecnico di Bari
    </h2>

    <p class="text-gray-600 text-sm leading-relaxed max-w-xs">
        Portale dedicato alla gestione delle principali attività
        relative al personale.
    </p>

</div>

            <!-- COLONNA DESTRA -->
            <div class="flex flex-col justify-center p-10">

                <div class="text-center mb-8">

                    <h1 class="text-4xl font-bold text-teal-500 mb-2">
                        PoliWork HR
                    </h1>

                    <p class="text-gray-400">
                        Sistema Gestione Personale
                    </p>

                </div>

                {{ $slot }}

            </div>

        </div>

    </div>

</body>
</html>
