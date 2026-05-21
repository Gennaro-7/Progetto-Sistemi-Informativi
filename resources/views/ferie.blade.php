<x-app-layout>
@if(auth()->user()->role === 'admin')
    <div class="px-6 py-4 bg-white border-b">
        <h2 class="font-semibold text-xl">
            Gestione Ferie
        </h2>
    </div>
@endif
    <div class="p-6">

        @if(Auth::user()->role === 'dipendente')
            <form method="POST" action="{{ route('ferie.store') }}" class="space-y-4 mb-8">
                @csrf

                <input type="date" name="data_inizio" class="border p-2 w-full" required>

                <input type="date" name="data_fine" class="border p-2 w-full" required>

                <textarea name="motivo" placeholder="Motivo richiesta ferie" class="border p-2 w-full"></textarea>

                <button class="bg-blue-500 text-white px-4 py-2">
                    Invia richiesta
                </button>
            </form>
        @endif

        <div>
            @foreach($ferie as $f)
                <div class="border p-3 mb-2 rounded bg-white">

                    <strong>
                        {{ optional($f->dipendente)->nome }} {{ optional($f->dipendente)->cognome }}
                    </strong>

                    <div>
                        Dal {{ $f->data_inizio }} al {{ $f->data_fine }}
                    </div>

                    <div>
                        Stato: {{ $f->stato }}
                    </div>

                    <div>
                        Motivo: {{ $f->motivo }}
                    </div>

                    @if(Auth::user()->role === 'admin' && $f->stato === 'in_attesa')
                        <div class="mt-3 flex gap-2">
                            <form method="POST" action="{{ route('ferie.approva', $f->id) }}">
                                @csrf
                                @method('PUT')

                                <button class="bg-green-500 text-white px-3 py-1 rounded">
                                    Approva
                                </button>
                            </form>

                            <form method="POST" action="{{ route('ferie.rifiuta', $f->id) }}">
                                @csrf
                                @method('PUT')

                                <button class="bg-red-500 text-white px-3 py-1 rounded">
                                    Rifiuta
                                </button>
                            </form>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>