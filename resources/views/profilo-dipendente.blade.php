<x-app-layout>

    <div class="p-6">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-8">

            <div class="flex items-center gap-6 mb-8">

                @if($dipendente->foto)
                    <img src="{{ asset('storage/'.$dipendente->foto) }}"
                         class="w-24 h-24 rounded-full object-cover border">
                @else
                    <div class="w-24 h-24 rounded-full bg-teal-500 flex items-center justify-center text-white text-3xl font-bold">
                        {{ strtoupper(substr($dipendente->nome, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <h1 class="text-3xl font-bold text-gray-900">
                        {{ $dipendente->nome }} {{ $dipendente->cognome }}
                    </h1>

                    <div class="text-gray-500 mt-2">
                        {{ optional($dipendente->user)->email ?? 'Nessuna email collegata' }}
                    </div>
                </div>

            </div>

            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

                <div class="bg-blue-50 p-4 rounded-xl">
                    <div class="text-sm text-gray-500">📄 Documenti</div>
                    <div class="text-3xl font-bold text-blue-600">
                        {{ $totaleDocumenti }}
                    </div>
                </div>

                <div class="bg-yellow-50 p-4 rounded-xl">
                    <div class="text-sm text-gray-500">🏖️ Ferie</div>
                    <div class="text-3xl font-bold text-yellow-500">
                        {{ $totaleFerie }}
                    </div>
                </div>

                <div class="bg-green-50 p-4 rounded-xl">
                    <div class="text-sm text-gray-500">📅 Turni</div>
                    <div class="text-3xl font-bold text-green-600">
                        {{ $totaleTurni }}
                    </div>
                </div>

                <div class="bg-red-50 p-4 rounded-xl">
                    <div class="text-sm text-gray-500">⚠️ Segnalazioni</div>
                    <div class="text-3xl font-bold text-red-600">
                        {{ $totaleSegnalazioni }}
                    </div>
                </div>

                <div class="bg-purple-50 p-4 rounded-xl">
                    <div class="text-sm text-gray-500">⭐ Media valutazioni</div>
                    <div class="text-3xl font-bold text-purple-600">
                        {{ $mediaValutazioni ? number_format($mediaValutazioni, 1) : '0.0' }}/10
                    </div>
                </div>

            </div>

            <div class="mt-8 border-t border-gray-100 pt-6">

                <h2 class="text-xl font-bold text-gray-900 mb-4">
                    ⭐ Valutazioni ricevute
                </h2>

                <div class="space-y-4">

                    @forelse($valutazioni as $v)

                        <div class="border border-gray-200 rounded-xl p-4">

                            <div class="flex justify-between items-start gap-4">

                                <div>
                                    <div class="font-bold text-gray-900">
                                        {{ $v->categoria }}
                                    </div>

                                    <div class="text-sm text-gray-500">
                                        {{ $v->data }}
                                    </div>

                                    <div class="text-yellow-500 font-bold mt-1">
                                        ⭐ {{ $v->voto }}/10
                                    </div>

                                    <p class="text-gray-700 mt-2">
                                        {{ $v->commento }}
                                    </p>
                                </div>

                            </div>

                        </div>

                    @empty

                        <p class="text-gray-500">
                            Nessuna valutazione presente per questo dipendente.
                        </p>

                    @endforelse

                </div>

            </div>

        </div>

    </div>

</x-app-layout>