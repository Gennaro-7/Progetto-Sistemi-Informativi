<x-app-layout>
@if(auth()->user()->role === 'admin')
    <div class="p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-medium text-teal-600">
            Gestione ferie
        </h1>
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
                        Dal {{ \Carbon\Carbon::parse($f->data_inizio)->format('d/m/Y') }} al {{ \Carbon\Carbon::parse($f->data_fine)->format('d/m/Y') }}
                    </div>

                    <div>
                    <div class="mt-2">
    Stato:

    @if($f->stato == 'approvata')
        <span class="bg-green-500 text-white px-3 py-1.5 rounded-full text-sm font-medium">
            Approvata
        </span>

    @elseif($f->stato == 'rifiutata')
        <span class="bg-red-500 text-white px-3 py-1.5 rounded-full text-sm font-medium">
            Rifiutata
        </span>

    @else
        <span class="bg-yellow-500 text-white px-3 py-1.5 rounded-full text-sm font-medium">
            In attesa
        </span>
    @endif
</div>
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
                    @if(Auth::user()->role === 'dipendente' && $f->stato === 'in_attesa')
    <div class="mt-3">
        <form method="POST"
              action="{{ route('ferie.destroy', $f->id) }}"
              class="delete-form-ferie">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded">
                Annulla richiesta
            </button>
        </form>
    </div>
@endif

                </div>
            @endforeach
        </div>

    </div>
    <script>
document.querySelectorAll('.delete-form-ferie').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Sei sicuro?',
            text: 'La richiesta ferie verrà annullata.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sì, annulla',
            cancelButtonText: 'Indietro'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
</x-app-layout>