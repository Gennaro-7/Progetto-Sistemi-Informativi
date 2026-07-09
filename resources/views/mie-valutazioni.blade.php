<x-app-layout>

    <div class="p-6 space-y-6">

        <div>
            <h1 class="text-2xl font-medium text-teal-600">
                Le mie valutazioni
            </h1>

            <p class="text-gray-600">
                Consulta le valutazioni ricevute dal reparto HR.
            </p>
        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">

            <h2 class="text-xl font-bold text-teal-600 mb-4">
                Storico valutazioni
            </h2>

            <div class="space-y-4">

                @forelse($valutazioni as $v)

                    <div class="border border-gray-200 rounded-xl p-5">

                        <div class="flex justify-between items-start">

                            <div>

                                <div class="font-bold text-gray-900 text-lg">
                                    {{ $v->categoria }}
                                </div>

                                <div class="text-sm text-gray-500 mt-1">
                                    {{ \Carbon\Carbon::parse($v->data)->format('d/m/Y') }}
                                </div>

                            </div>

                            <span class="bg-yellow-100 text-yellow-700 px-4 py-2 rounded-full font-bold">
                                ⭐ {{ $v->voto }}/10
                            </span>

                        </div>

                        <p class="text-gray-700 mt-4">
                            {{ $v->commento }}
                        </p>

                    </div>

                @empty

                    <div class="text-center py-8 text-gray-500">
                        Non hai ancora ricevuto valutazioni.
                    </div>

                @endforelse

            </div>

        </div>

    </div>

</x-app-layout>