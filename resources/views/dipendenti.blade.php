<x-app-layout>

    <div class="p-6">
        <div class="mb-6">
    <input
        type="text"
        id="searchDipendente"
        placeholder="🔍 Cerca dipendente..."
        class="w-full border border-gray-300 rounded-lg p-3">
</div>

        <form method="POST" action="{{ route('dipendenti.store') }}" class="space-y-4 mb-8">
            @csrf

            <input type="text" name="nome" placeholder="Nome" class="border p-2 w-full" required>

            <input type="text" name="cognome" placeholder="Cognome" class="border p-2 w-full">

            <select name="user_id" class="border p-2 w-full">
                <option value="">Collega account utente</option>

                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} - {{ $user->email }}
                    </option>
                @endforeach
            </select>

            <button class="bg-teal-500 text-white px-4 py-2 rounded">
                Salva Dipendente
            </button>
            
        </form>

        @if($utentiInAttesa->count() > 0)

    <div class="bg-white border border-gray-200 rounded-xl p-5 mb-6 shadow-sm">

        <h2 class="text-lg font-bold text-teal-600 mb-4">
            Richieste di abilitazione
        </h2>

        @foreach($utentiInAttesa as $utente)

    <div class="flex items-center justify-between border border-gray-200 rounded-lg p-4 mb-3">

        <div>
            <div class="font-semibold text-gray-800">
                {{ $utente->name }}
            </div>

            <div class="text-sm text-gray-500">
                {{ $utente->email }}
            </div>
        </div>

        <form method="POST" action="{{ route('dipendenti.store') }}">
            @csrf

            <input type="hidden"
                   name="nome"
                   value="{{ $utente->name }}">

            <input type="hidden"
                   name="user_id"
                   value="{{ $utente->id }}">

            <button type="submit"
                    class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                Associa
            </button>

        </form>

    </div>

@endforeach

    </div>

@endif

<h2 class="text-xl font-bold text-teal-600 mb-4">
    Elenco dipendenti
</h2>
       @foreach($dipendenti as $dipendente)

    <div class="dipendente-card bg-white border border-gray-200 rounded-2xl shadow-sm p-5 mb-4">

        <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">

            <div class="flex items-center gap-4">

                @if($dipendente->foto)
                    <img src="{{ asset('storage/'.$dipendente->foto) }}"
                         class="w-16 h-16 rounded-full object-cover border flex-shrink-0">
                @else
                    <div class="w-16 h-16 rounded-full bg-teal-500 flex items-center justify-center text-white text-xl font-bold flex-shrink-0">
                        {{ strtoupper(substr($dipendente->nome, 0, 1)) }}
                    </div>
                @endif

                <div>
                    <div class="font-bold text-lg text-gray-900">
                        {{ $dipendente->nome }} {{ $dipendente->cognome }}
                    </div>

                    <div class="text-sm text-gray-500">
                        ID {{ $dipendente->id }}
                    </div>

                    <div class="text-sm text-gray-600">
                        {{ optional($dipendente->user)->email ?? 'Nessun account collegato' }}
                    </div>
                </div>

            </div>

            <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">

                <div>
                    📄 Documenti:
                    <span class="font-semibold">
                        {{ \App\Models\Documento::where('dipendente_id', $dipendente->id)->count() }}
                    </span>
                </div>

                <div>
                    📅 Ferie:
                    <span class="font-semibold">
                        {{ \App\Models\Ferie::where('dipendente_id', $dipendente->id)->count() }}
                    </span>
                </div>

            </div>

            <div class="flex items-center gap-2">

                <a href="{{ route('dipendenti.profilo', $dipendente->id) }}"
                   class="w-24 text-center bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-sm">
                    Profilo
                </a>

                <button
                    onclick="openEditModal(
                        {{ $dipendente->id }},
                        '{{ $dipendente->nome }}',
                        '{{ $dipendente->cognome }}',
                        '{{ $dipendente->user_id }}'
                    )"
                    class="w-24 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-2 rounded-lg text-sm">
                    Modifica
                </button>

                <form method="POST"
      action="{{ route('dipendenti.destroy', $dipendente->id) }}"
      class="delete-form-dipendente">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-lg">
        Elimina
    </button>

</form>

            </div>

        </div>

    </div>

@endforeach

    </div>
    <script>
document.addEventListener('DOMContentLoaded', function () {

    const search = document.getElementById('searchDipendente');

    search.addEventListener('keyup', function () {

        const value = this.value.toLowerCase();

        document.querySelectorAll('.dipendente-card').forEach(card => {

            const text = card.innerText.toLowerCase();

            card.style.display =
                text.includes(value) ? '' : 'none';

        });

    });

});
</script>
<div id="editModal"
     class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">

    <div class="bg-white p-6 rounded-2xl shadow-xl w-full max-w-md">

        <h2 class="text-xl font-bold mb-4 text-gray-900">
            Modifica Dipendente
        </h2>

        <form id="editForm" method="POST">
            @csrf
            @method('PUT')

            <input type="text"
                   id="editNome"
                   name="nome"
                   class="border border-gray-300 rounded-lg p-2 w-full mb-3"
                   required>

            <input type="text"
                   id="editCognome"
                   name="cognome"
                   class="border border-gray-300 rounded-lg p-2 w-full mb-3">

            <select id="editUser"
                    name="user_id"
                    class="border border-gray-300 rounded-lg p-2 w-full mb-4">

                <option value="">Nessun account</option>

                @foreach($users as $user)
                    <option value="{{ $user->id }}">
                        {{ $user->name }} - {{ $user->email }}
                    </option>
                @endforeach

            </select>

            <div class="flex justify-end gap-2">

                <button type="button"
                        onclick="closeEditModal()"
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
function openEditModal(id, nome, cognome, userId) {
    document.getElementById('editForm').action = '/dipendenti/' + id;
    document.getElementById('editNome').value = nome;
    document.getElementById('editCognome').value = cognome;
    document.getElementById('editUser').value = userId || '';

    document.getElementById('editModal').classList.remove('hidden');
    document.getElementById('editModal').classList.add('flex');
}

function closeEditModal() {
    document.getElementById('editModal').classList.add('hidden');
    document.getElementById('editModal').classList.remove('flex');
}
</script>
<script>
document.querySelectorAll('.delete-form-dipendente').forEach(form => {

    form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
            title: 'Sei sicuro?',
            text: 'Il dipendente verrà eliminato definitivamente.',
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