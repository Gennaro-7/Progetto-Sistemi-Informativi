<x-app-layout>

    <div class="p-6 space-y-8">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md py-8 px-8 text-center">

            <div class="mx-auto w-20 h-20 rounded-2xl bg-teal-500 flex items-center justify-center text-white text-3xl font-bold shadow mb-6">
                PW
            </div>

            <h1 class="text-4xl font-bold text-teal-600 mb-3">
                PoliWork HR
            </h1>

            <p class="text-gray-600 text-lg mb-6">
                Sistema di gestione del personale aziendale
            </p>

            <p class="text-gray-500 max-w-2xl mx-auto mb-6">
                Gestisci dipendenti, turni, ferie, documenti, buste paga e attività HR in un'unica piattaforma.
            </p>

            <a href="{{ route('dashboard') }}"
                class="inline-block bg-teal-500 hover:bg-teal-600 text-white px-8 py-4 rounded-xl font-bold text-lg transition duration-200">
                    Vai alla Dashboard
            </a>

        </div>

        <div>
            <h2 class="text-2xl font-bold text-teal-600 mb-4">
                Accesso rapido
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                <a href="{{ route('dipendenti') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-20 text-center">
                    <div class="text-3xl mb-4">👥</div>
                    <div class="font-bold text-gray-900">Dipendenti</div>
                    <div class="text-sm text-gray-500">Gestione personale</div>
                </a>

                <a href="{{ route('turni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="text-3xl mb-4">📅</div>
                    <div class="font-bold text-gray-900">Turni</div>
                    <div class="text-sm text-gray-500">Assegnazione turni</div>
                </a>

                <a href="{{ route('ferie') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="text-3xl mb-4">🏖️</div>
                    <div class="font-bold text-gray-900">Ferie</div>
                    <div class="text-sm text-gray-500">Richieste ferie</div>
                </a>

                <a href="{{ route('stipendi') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="text-3xl mb-4">💰</div>
                    <div class="font-bold text-gray-900">Stipendi</div>
                    <div class="text-sm text-gray-500">Buste paga</div>
                </a>

                <a href="{{ route('documenti') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="text-3xl mb-4">📄</div>
                    <div class="font-bold text-gray-900">Documenti</div>
                    <div class="text-sm text-gray-500">Archivio documentale</div>
                </a>

                <a href="{{ route('convenzioni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="text-3xl mb-4">🤝</div>
                    <div class="font-bold text-gray-900">Convenzioni</div>
                    <div class="text-sm text-gray-500">Vantaggi aziendali</div>
                </a>

                <a href="{{ route('segnalazioni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="text-3xl mb-4">📢</div>
                    <div class="font-bold text-gray-900">Segnalazioni</div>
                    <div class="text-sm text-gray-500">Reclami e richieste</div>
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('valutazioni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                        <div class="text-3xl mb-4">⭐</div>
                        <div class="font-bold text-gray-900">Valutazioni</div>
                        <div class="text-sm text-gray-500">Performance dipendenti</div>
                    </a>
                @endif

            </div>
        </div>

    </div>

</x-app-layout>