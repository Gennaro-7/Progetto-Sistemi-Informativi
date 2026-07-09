<x-app-layout>

<div class="p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-medium text-teal-600">
            Documenti
        </h1>

        <p class="text-gray-600">
            Archivio documentale dipendenti
        </p>
    </div>

        @if(auth()->user()->role === 'admin')

            <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">
                <h2 class="text-xl font-bold text-teal-600 mb-4">
    Carica nuovo documento
</h2>

                <form method="POST"
                      action="{{ route('documenti.store') }}"
                      enctype="multipart/form-data"
                      class="space-y-4">

                    @csrf

                    <select name="dipendente_id"
                            class="border-gray-300 rounded-md w-full">

                        @foreach($dipendenti as $dipendente)
                            <option value="{{ $dipendente->id }}">
                                {{ $dipendente->nome }}
                                {{ $dipendente->cognome }}
                            </option>
                        @endforeach

                    </select>

                    <input type="text"
                           name="titolo"
                           placeholder="Titolo documento"
                           class="border-gray-300 rounded-md w-full"
                           required>

                    <input type="file"
                           name="file"
                           accept=".pdf"
                           class="border-gray-300 rounded-md w-full"
                           required>

                    <button type="submit"
                            class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                        Carica Documento
                    </button>

                </form>

            </div>

        @endif

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">

            <h3 class="font-bold mb-4">
                Elenco documenti
            </h3>

            <input type="text"
       id="searchDocumenti"
       placeholder="🔍 Cerca documento..."
       class="w-full border border-gray-300 rounded-lg p-3 mb-4">

            <div class="space-y-4">

                @forelse($documenti as $documento)

                    <div class="documento-item border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                            <div>
                                <div class="font-semibold text-gray-900 documento-titolo">
    {{ $documento->titolo }}
</div>

                                @if(auth()->user()->role === 'admin')
                                    <div class="text-sm text-gray-500">
                                        {{ optional($documento->dipendente)->nome }}
                                        {{ optional($documento->dipendente)->cognome }}
                                    </div>
                                @endif
                            </div>

                            <div class="flex gap-2">

    <a href="{{ asset('storage/'.$documento->file) }}"
       target="_blank"
       class="w-28 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
        Apri PDF
    </a>

    @if(auth()->user()->role === 'admin')

        <button
            onclick="openDocumentoModal(
                {{ $documento->id }},
                '{{ addslashes($documento->titolo) }}'
            )"
            class="w-28 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm">
            Modifica
        </button>

        <form method="POST"
              action="{{ route('documenti.delete', $documento->id) }}"
              class="delete-form-documento">

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

                    </div>

                @empty

                    <p class="text-gray-500">
                        Nessun documento presente.
                    </p>

                @endforelse

            </div>

        </div>

    </div>
<script>
document.querySelectorAll('.delete-form-documento').forEach(form => {

    form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
            title: 'Sei sicuro?',
            text: 'Il documento verrà eliminato definitivamente.',
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
<script>
document.getElementById('searchDocumenti')
    .addEventListener('keyup', function () {

    let filtro = this.value.toLowerCase();

    document.querySelectorAll('.documento-item').forEach(item => {

        let titolo = item.querySelector('.documento-titolo')
                         .textContent
                         .toLowerCase();

        item.style.display =
            titolo.includes(filtro) ? '' : 'none';

    });

});
</script>
<div id="documentoModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Modifica documento
        </h2>

        <form id="documentoForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text"
                   id="documentoTitolo"
                   name="titolo"
                   class="border border-gray-300 rounded-lg p-3 w-full mb-4"
                   required>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeDocumentoModal()"
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
function openDocumentoModal(id, titolo) {
    document.getElementById('documentoForm').action = '/documenti/' + id;
    document.getElementById('documentoTitolo').value = titolo;

    document.getElementById('documentoModal').classList.remove('hidden');
    document.getElementById('documentoModal').classList.add('flex');
}

function closeDocumentoModal() {
    document.getElementById('documentoModal').classList.add('hidden');
    document.getElementById('documentoModal').classList.remove('flex');
}
</script>
</x-app-layout>