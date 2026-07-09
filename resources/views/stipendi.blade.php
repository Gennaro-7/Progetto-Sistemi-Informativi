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
                    <h2 class="text-xl font-bold text-teal-600 mb-4">
                        Carica nuova busta paga
                    </h2>
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
       class="w-28 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
        Scarica
    </a>

    @if(auth()->user()->role === 'admin')

        <button
            onclick="openStipendioModal(
                {{ $s->id }},
                '{{ addslashes($s->mese) }}',
                '{{ $s->anno }}'
            )"
            class="w-28 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm">
            Modifica
        </button>

        <form method="POST"
      action="{{ route('stipendi.destroy', $s->id) }}"
      class="delete-stipendio-form">

            @csrf
            @method('DELETE')

            <button type="submit"
                    class="w-28 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm">
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
<div id="stipendioModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Modifica busta paga
        </h2>

        <form id="stipendioForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text"
                   id="stipendioMese"
                   name="mese"
                   class="border border-gray-300 rounded-lg p-3 w-full mb-4"
                   required>

            <input type="text"
                   id="stipendioAnno"
                   name="anno"
                   class="border border-gray-300 rounded-lg p-3 w-full mb-4"
                   required>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeStipendioModal()"
                        class="bg-gray-300 px-4 py-2 rounded-lg">
                    Annulla
                </button>

                <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                    Salva
                </button>
            </div>
        </form>

    </div>
</div>

<script>
function openStipendioModal(id, mese, anno) {
    document.getElementById('stipendioForm').action = '/stipendi/' + id;
    document.getElementById('stipendioMese').value = mese;
    document.getElementById('stipendioAnno').value = anno;

    document.getElementById('stipendioModal').classList.remove('hidden');
    document.getElementById('stipendioModal').classList.add('flex');
}

function closeStipendioModal() {
    document.getElementById('stipendioModal').classList.add('hidden');
    document.getElementById('stipendioModal').classList.remove('flex');
}
</script>
<script>
document.querySelectorAll('.delete-stipendio-form').forEach(form => {

    form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
            title: 'Eliminare la busta paga?',
            text: 'Questa operazione non può essere annullata.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sì, elimina',
            cancelButtonText: 'Annulla'
        }).then((result) => {

            if (result.isConfirmed) {
                form.submit();
            }

        });

    });

});
</script>
</x-app-layout>