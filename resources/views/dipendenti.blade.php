<x-app-layout>

    <div class="p-6">

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
            <div class="border p-4 mb-3 rounded flex justify-between items-center bg-white">

                <div>
                    <strong>
                        ID{{ $dipendente->id }} - {{ $dipendente->nome }} {{ $dipendente->cognome }}
                    </strong>

                    <div>
                        Account collegato:
                        {{ optional($dipendente->user)->email ?? 'Nessun account' }}
                    </div>
                </div>

                <form method="POST" action="{{ route('dipendenti.destroy', $dipendente->id) }}">
                    @csrf
                    @method('DELETE')

                    <button onclick="return confirm('Eliminare dipendente?')"
                            class="text-red-500 hover:text-red-700 text-xl">
                        🗑️
                    </button>
                </form>

            </div>
        @endforeach

    </div>
</x-app-layout>