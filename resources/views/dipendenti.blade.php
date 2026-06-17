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

            <button class="bg-blue-500 text-white px-4 py-2 rounded">
                Salva Dipendente
            </button>
        </form>

        @foreach($dipendenti as $dipendente)
    <div class="dipendente-card border border-gray-200 p-5 mb-4 rounded-2xl shadow-sm flex justify-between items-center bg-white">

                <div>

    <div class="font-bold text-lg text-gray-900">
        👤 {{ $dipendente->nome }} {{ $dipendente->cognome }}
    </div>

    <div class="text-sm text-gray-600 mt-1">
        🆔 ID {{ $dipendente->id }}
    </div>

    <div class="text-sm text-gray-600">
        📧 {{ optional($dipendente->user)->email ?? 'Nessun account collegato' }}
    </div>

    <div class="text-sm text-gray-600">
        📄 Documenti:
        {{ \App\Models\Documento::where('dipendente_id', $dipendente->id)->count() }}
    </div>

    <div class="text-sm text-gray-600">
        📅 Ferie:
        {{ \App\Models\Ferie::where('dipendente_id', $dipendente->id)->count() }}
    </div>

</div>

                <div class="flex items-center gap-3">

    <button
        onclick="openEditModal(
            {{ $dipendente->id }},
            '{{ $dipendente->nome }}',
            '{{ $dipendente->cognome }}',
            '{{ $dipendente->user_id }}'
        )"
        class="text-blue-500 hover:text-blue-700 text-xl">

        ✏️

    </button>

    <form method="POST"
          action="{{ route('dipendenti.destroy', $dipendente->id) }}">

        @csrf
        @method('DELETE')

        <button onclick="return confirm('Eliminare dipendente?')"
                class="text-red-500 hover:text-red-700 text-xl">
            🗑️
        </button>

    </form>

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
</x-app-layout>