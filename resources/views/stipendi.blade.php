<x-app-layout>

    <div class="p-6">

        @if(Auth::user()->role === 'admin')
            <form method="POST" action="{{ route('stipendi.store') }}" enctype="multipart/form-data" class="space-y-4 mb-8">
                @csrf

                <select name="dipendente_id" class="border p-2 w-full" required>
                    <option value="">Seleziona dipendente</option>
                    @foreach($dipendenti as $dipendente)
                        <option value="{{ $dipendente->id }}">
                            {{ $dipendente->nome }} {{ $dipendente->cognome }}
                        </option>
                    @endforeach
                </select>

                <input type="text" name="mese" placeholder="Mese es. Gennaio" class="border p-2 w-full" required>

                <input type="text" name="anno" placeholder="Anno es. 2026" class="border p-2 w-full" required>

                <input type="file" name="file" accept="application/pdf" class="border p-2 w-full" required>

                <button class="bg-blue-500 text-white px-4 py-2">
                    Carica busta paga
                </button>
            </form>
        @endif

        <div>
            @foreach($stipendi as $s)
                <div class="border p-3 mb-2 rounded flex justify-between items-center">
                    <div>
                        <strong>{{ $s->mese }} {{ $s->anno }}</strong>

                        <div>
                            {{ optional($s->dipendente)->nome }} {{ optional($s->dipendente)->cognome }}
                        </div>
                    </div>

                    <a href="{{ route('stipendi.download', $s->id) }}" class="text-blue-600">
                        Scarica PDF
                    </a>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>