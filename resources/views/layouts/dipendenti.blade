<x-app-layout>
    <x-slot name="header">
        <h2>Gestione Dipendenti</h2>
    </x-slot>

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

            <button class="bg-blue-500 text-white px-4 py-2">
                Salva Dipendente
            </button>
        </form>

        <div>
            @foreach($dipendenti as $dipendente)
                <div class="border p-3 mb-2 rounded">
                    <strong>{{ $dipendente->nome }} {{ $dipendente->cognome }}</strong>

                    <div>
                        Account collegato:
                        {{ optional($dipendente->user)->email ?? 'Nessun account' }}
                    </div>
                </div>
            @endforeach
        </div>

    </div>
</x-app-layout>