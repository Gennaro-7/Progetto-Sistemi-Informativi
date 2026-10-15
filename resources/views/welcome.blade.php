<!DOCTYPE html>
<html lang="it">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>PoliWork HR</title>

    <link rel="icon" type="image/png" href="{{ asset('favicon.png') }}">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="min-h-screen bg-[#b8c2cc] flex items-center justify-center">

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

            <p class="text-gray-600 text-sm leading-relaxed">
                Portale dedicato alla gestione delle principali attività
                relative al personale.
            </p>

        </div>

        <!-- COLONNA DESTRA -->
        <div class="flex flex-col justify-center p-10 text-center">

            <h1 class="text-4xl font-bold text-teal-500 mb-3">
                PoliWork HR
            </h1>

            <p class="text-gray-400 mb-8">
                Sistema Gestione Personale
            </p>

            <div class="flex justify-center gap-4">

                <a href="{{ route('login') }}"
                   class="px-7 py-3 bg-teal-500 text-gray-900 font-semibold rounded-lg hover:bg-teal-400 transition">
                    ACCEDI
                </a>

                <a href="{{ route('register') }}"
                   class="px-7 py-3 border border-teal-500 text-teal-400 font-semibold rounded-lg hover:bg-gray-700 transition">
                    REGISTRATI
                </a>

            </div>

        </div>

    </div>

</body>
</html>