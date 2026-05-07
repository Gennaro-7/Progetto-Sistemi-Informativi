<x-app-layout>
    <x-slot name="header">
        <h2>Gestione Turni</h2>
    </x-slot>

    <div class="p-6">
        <div id="calendar" class="mb-8 max-w-5xl mx-auto bg-white p-4 rounded shadow"></div>

        <script>
            window.turniEvents = @json($events);
        </script>

        @if(Auth::user()->role === 'admin')
            <!-- FORM ADMIN -->
            <form method="POST" action="{{ route('turni.store') }}" class="space-y-4 mb-8">
                @csrf

                <input type="date" name="data" class="border p-2 w-full" required>

                <select name="turno" class="border p-2 w-full" required>
                    <option value="mattina">Mattina</option>
                    <option value="pomeriggio">Pomeriggio</option>
                    <option value="notte">Notte</option>
                </select>

                <select name="dipendente_id" class="border p-2 w-full">
                    <option value="">Seleziona dipendente</option>

                    @foreach($dipendenti as $dipendente)
                        <option value="{{ $dipendente->id }}">
                            {{ $dipendente->nome }} {{ $dipendente->cognome }}
                        </option>
                    @endforeach
                </select>

                <textarea name="note" placeholder="Note" class="border p-2 w-full"></textarea>

                <button class="bg-blue-500 text-white px-4 py-2">
                    Salva Turno
                </button>
            </form>
        @endif

        <!-- LISTA TURNI -->
        <div>
            @foreach($turni as $turno)
                <div class="border p-2 mb-2 flex justify-between items-center">

                    <div>
                        <strong>{{ $turno->data }}</strong> -
                        {{ $turno->turno }} -
                        {{ optional($turno->dipendente)->nome }} {{ optional($turno->dipendente)->cognome }}
                    </div>

                    @if(Auth::user()->role === 'admin')
                        <div>
                            <a href="{{ route('turni.edit', $turno->id) }}"
                               class="text-blue-600 ml-2">
                                Modifica
                            </a>
                        </div>
                    @endif

                </div>
            @endforeach
        </div>

    </div>

    @if(Auth::user()->role === 'admin')
        <!-- MODAL MODIFICA -->
        <div id="editModal"
             onclick="this.classList.add('hidden')"
             class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

            <div class="bg-white p-6 rounded w-full max-w-md"
                 onclick="event.stopPropagation()">

                <h2 class="text-lg mb-4">Modifica Turno</h2>

                <form id="editForm" method="POST">
                    @csrf
                    @method('PUT')

                    <input type="date" name="data" id="editData" class="border p-2 w-full mb-2">

                    <select name="turno" id="editTurno" class="border p-2 w-full mb-2">
                        <option value="mattina">Mattina</option>
                        <option value="pomeriggio">Pomeriggio</option>
                        <option value="notte">Notte</option>
                    </select>

                    <select name="dipendente_id" id="editDipendente" class="border p-2 w-full mb-2">
                        <option value="">Seleziona dipendente</option>

                        @foreach($dipendenti as $dipendente)
                            <option value="{{ $dipendente->id }}">
                                {{ $dipendente->nome }} {{ $dipendente->cognome }}
                            </option>
                        @endforeach
                    </select>

                    <textarea name="note" id="editNote" class="border p-2 w-full mb-2"></textarea>

                    <div class="flex justify-between">

                        <button type="button"
                                onclick="document.getElementById('editModal').classList.add('hidden')"
                                class="px-3 py-1 bg-gray-400 text-white">
                            Annulla
                        </button>

                        <button class="px-3 py-1 bg-blue-500 text-white">
                            Salva
                        </button>

                    </div>
                </form>
            </div>
        </div>
    @endif

</x-app-layout>