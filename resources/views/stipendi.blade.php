<x-app-layout>

    <div class="p-6 space-y-6">

        <div>
            <h1 class="text-2xl font-medium text-teal-600">
                Storico stipendi
            </h1>
        </div>

        @if(Auth::user()->role === 'admin')
            <form method="POST"
                  action="{{ route('stipendi.store') }}"
                  enctype="multipart/form-data"
                  class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md space-y-4">

                @csrf

                <select name="dipendente_id"
                        class="border border-gray-300 rounded-lg p-3 w-full"
                        required>
                    <option value="">Seleziona dipendente</option>

                    @foreach($dipendenti as $dipendente)
                        <option value="{{ $dipendente->id }}">
                            {{ $dipendente->nome }} {{ $dipendente->cognome }}
                        </option>
                    @endforeach
                </select>

                <input type="text"
                       name="mese"
                       placeholder="Mese es. Gennaio"
                       class="border border-gray-300 rounded-lg p-3 w-full"
                       required>

                <input type="text"
                       name="anno"
                       placeholder="Anno es. 2026"
                       class="border border-gray-300 rounded-lg p-3 w-full"
                       required>

                <input type="file"
                       name="file"
                       accept="application/pdf"
                       class="border border-gray-300 rounded-lg p-3 w-full"
                       required>

                <button class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                    Carica busta paga
                </button>
            </form>
        @endif

        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
            <h3 class="font-bold text-gray-900 mb-4">
                Elenco buste paga
            </h3>

            <div class="space-y-4">
                @forelse($stipendi as $s)
                    <div class="flex justify-between items-center border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">
                        <div>
                            <div class="font-semibold text-gray-900">
                                💰 {{ ucfirst($s->mese) }} {{ $s->anno }}
                            </div>

                            <div class="text-sm text-gray-500">
                                {{ optional($s->dipendente)->nome }}
                                {{ optional($s->dipendente)->cognome }}
                            </div>
                        </div>

                        <div class="flex gap-2">

    <a href="{{ route('stipendi.download', $s->id) }}"
       class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
        Scarica PDF
    </a>

    @if(auth()->user()->role === 'admin')
        <form method="POST"
              action="{{ route('stipendi.destroy', $s->id) }}"
              onsubmit="return confirm('Eliminare la busta paga?')">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm">
                Elimina
            </button>

        </form>
    @endif

</div>
                    </div>
                @empty
                    <p class="text-gray-500">
                        Nessuna busta paga presente.
                    </p>
                @endforelse
            </div>
        </div>

    </div>

</x-app-layout>