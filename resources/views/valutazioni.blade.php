<x-app-layout>
<div class="p-6 space-y-6">

    <div>
        <h1 class="text-2xl font-medium text-teal-600">
            Valutazioni Dipendenti
        </h1>

        <p class="text-gray-600">
            Gestione delle valutazioni del personale
        </p>
    </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">

            <form method="POST"
                  action="{{ route('valutazioni.store') }}"
                  class="space-y-4">

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

                <select name="categoria"
                        class="border border-gray-300 rounded-lg p-3 w-full"
                        required>
                    <option value="">Seleziona categoria</option>
                    <option value="Produttività">Produttività</option>
                    <option value="Puntualità">Puntualità</option>
                    <option value="Collaborazione">Collaborazione</option>
                    <option value="Leadership">Leadership</option>
                    <option value="Problem Solving">Problem Solving</option>
                </select>

                <input type="number"
                       name="voto"
                       min="1"
                       max="10"
                       placeholder="Voto da 1 a 10"
                       class="border border-gray-300 rounded-lg p-3 w-full"
                       required>

                <input type="date"
                       name="data"
                       class="border border-gray-300 rounded-lg p-3 w-full"
                       required>

                <textarea name="commento"
                          rows="4"
                          placeholder="Commento valutazione"
                          class="border border-gray-300 rounded-lg p-3 w-full"
                          required></textarea>

                <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                    Aggiungi valutazione
                </button>

            </form>

        </div>

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">

            <h3 class="font-bold text-gray-900 mb-4">
                Elenco valutazioni
            </h3>

            <input type="text"
       id="searchValutazioni"
       placeholder="🔍 Cerca valutazione..."
       class="w-full border border-gray-300 rounded-lg p-3 mb-4">

            <div class="space-y-4">

                @forelse($valutazioni as $v)

                    <div class="valutazione-item border-b border-gray-100 pb-4 last:border-b-0 last:pb-0">

                        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-3">

                            <div>
                                <div class="font-bold text-gray-900">
                                    {{ optional($v->dipendente)->nome }}
                                    {{ optional($v->dipendente)->cognome }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ $v->categoria }} • {{ \Carbon\Carbon::parse($v->data)->format('d/m/Y') }}
                                </div>

                                <div class="text-yellow-500 font-bold mt-1">
                                    ⭐ {{ $v->voto }}/10
                                </div>

                                <p class="text-gray-700 mt-2">
                                    {{ $v->commento }}
                                </p>
                            </div>
<div class="flex gap-2">

    <button
        onclick="openValutazioneModal(
            {{ $v->id }},
            '{{ addslashes($v->categoria) }}',
            '{{ $v->voto }}',
            '{{ addslashes($v->commento) }}',
            '{{ $v->data }}'
        )"
        class="w-28 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm">
        Modifica
    </button>

    <form method="POST"
          action="{{ route('valutazioni.destroy', $v->id) }}"
          class="delete-form-valutazione">

        @csrf
        @method('DELETE')

        <button type="submit"
                class="w-28 bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm">
            Elimina
        </button>

    </form>

</div>
                        </div>

                    </div>

                @empty

                    <p class="text-gray-500">
                        Nessuna valutazione presente.
                    </p>

                @endforelse

            </div>

        </div>

    </div>
<div id="valutazioneModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Modifica valutazione
        </h2>

        <form id="valutazioneForm" method="POST">
            @csrf
            @method('PUT')

            <select id="valutazioneCategoria"
                    name="categoria"
                    class="border border-gray-300 rounded-lg p-3 w-full mb-4"
                    required>
                <option value="Produttività">Produttività</option>
                <option value="Puntualità">Puntualità</option>
                <option value="Collaborazione">Collaborazione</option>
                <option value="Leadership">Leadership</option>
                <option value="Problem Solving">Problem Solving</option>
            </select>

            <input type="number"
                   id="valutazioneVoto"
                   name="voto"
                   min="1"
                   max="10"
                   class="border border-gray-300 rounded-lg p-3 w-full mb-4"
                   required>

            <input type="date"
                   id="valutazioneData"
                   name="data"
                   class="border border-gray-300 rounded-lg p-3 w-full mb-4"
                   required>

            <textarea id="valutazioneCommento"
                      name="commento"
                      rows="4"
                      class="border border-gray-300 rounded-lg p-3 w-full mb-4"
                      required></textarea>

            <div class="flex justify-end gap-2">

                <button type="button"
                        onclick="closeValutazioneModal()"
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
function openValutazioneModal(id, categoria, voto, commento, data) {
    document.getElementById('valutazioneForm').action = '/valutazioni/' + id;
    document.getElementById('valutazioneCategoria').value = categoria;
    document.getElementById('valutazioneVoto').value = voto;
    document.getElementById('valutazioneCommento').value = commento;
    document.getElementById('valutazioneData').value = data;

    document.getElementById('valutazioneModal').classList.remove('hidden');
    document.getElementById('valutazioneModal').classList.add('flex');
}

function closeValutazioneModal() {
    document.getElementById('valutazioneModal').classList.add('hidden');
    document.getElementById('valutazioneModal').classList.remove('flex');
}
</script>

<script>
document.querySelectorAll('.delete-form-valutazione').forEach(form => {

    form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
            title: 'Sei sicuro?',
            text: 'La valutazione verrà eliminata definitivamente.',
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
document.getElementById('searchValutazioni')
    .addEventListener('keyup', function () {

        let filtro = this.value.toLowerCase();

        document.querySelectorAll('.valutazione-item').forEach(item => {
            let testo = item.innerText.toLowerCase();

            item.style.display = testo.includes(filtro) ? '' : 'none';
        });

    });
</script>
</x-app-layout>