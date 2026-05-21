<x-app-layout>
@if(auth()->user()->role === 'admin')
    <div class="px-6 py-4 bg-white border-b">
        <h2 class="font-semibold text-xl">
            Calendario completo
        </h2>
    </div>
@endif
    <div class="p-6">
        <div class="bg-white p-6 rounded shadow">
            <div class="mb-4 flex gap-3">

    <select id="tipoFiltro" class="border rounded p-2">
        <option value="tutti">Tutti</option>
        <option value="turni">Solo turni</option>
        <option value="ferie">Solo ferie</option>
    </select>

    <select id="dipendenteFiltro" class="border rounded p-2">

        <option value="tutti">
            Tutti i dipendenti
        </option>

        @foreach(\App\Models\Dipendente::all() as $dipendente)

            <option value="{{ $dipendente->id }}">
                ID{{ $dipendente->id }}
                -
                {{ $dipendente->nome }}
                {{ $dipendente->cognome }}
            </option>

        @endforeach

    </select>

</div>
            <div id="calendar"></div>
        </div>
    </div>

    <!-- MODAL CREA TURNO -->
    <div id="turnoModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl w-96">
            <h2 class="text-xl font-bold mb-4">Crea Turno</h2>

            <input type="hidden" id="selectedDate">

            <div class="mb-4">
                <label class="block mb-1">Dipendente</label>
                <select id="dipendenteSelect" class="border rounded w-full p-2">
                    @foreach(\App\Models\Dipendente::all() as $dipendente)
                        <option value="{{ $dipendente->id }}">
                            ID{{ $dipendente->id }} - {{ $dipendente->nome }} {{ $dipendente->cognome }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block mb-1">Turno</label>
                <select id="turnoSelect" class="border rounded w-full p-2">
                    <option value="mattina">Mattina</option>
                    <option value="pomeriggio">Pomeriggio</option>
                    <option value="notte">Notte</option>
                </select>
            </div>

            <div class="flex justify-end gap-2">
                <button onclick="closeModal()" class="bg-gray-300 px-4 py-2 rounded">Annulla</button>
                <button onclick="saveTurno()" class="bg-blue-500 text-white px-4 py-2 rounded">Salva</button>
            </div>
        </div>
    </div>

    <!-- MODAL MODIFICA TURNO -->
    <div id="editModal" class="fixed inset-0 bg-black bg-opacity-50 hidden items-center justify-center z-50">
        <div class="bg-white p-6 rounded-xl shadow-xl w-96">
            <h2 class="text-xl font-bold mb-4">Modifica Turno</h2>

            <input type="hidden" id="editTurnoId">

            <div class="mb-4">
                <label class="block mb-1">Turno</label>
                <select id="editTurnoSelect" class="border rounded w-full p-2">
                    <option value="mattina">Mattina</option>
                    <option value="pomeriggio">Pomeriggio</option>
                    <option value="notte">Notte</option>
                </select>
            </div>

            <div class="flex justify-between">
                <button onclick="deleteTurno()" class="bg-red-500 text-white px-4 py-2 rounded">
                    Elimina
                </button>

                <div class="flex gap-2">
                    <button onclick="closeEditModal()" class="bg-gray-300 px-4 py-2 rounded">
                        Annulla
                    </button>

                    <button onclick="updateTurno()" class="bg-blue-500 text-white px-4 py-2 rounded">
                        Salva
                    </button>
                </div>
            </div>
        </div>
    </div>

    <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.15/index.global.min.js"></script>

    <script>
        let calendar;

        document.addEventListener('DOMContentLoaded', function () {
            const calendarEl = document.getElementById('calendar');

            calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                locale: 'it',
                height: 700,
                events: function(fetchInfo, successCallback, failureCallback) {

    const tipo = document.getElementById('tipoFiltro').value;

    const dipendente = document.getElementById('dipendenteFiltro').value;

    fetch(`/calendar-events?tipo=${tipo}&dipendente=${dipendente}`)
        .then(response => response.json())
        .then(data => successCallback(data))
        .catch(error => failureCallback(error));

},

                dateClick: function(info) {
                    document.getElementById('selectedDate').value = info.dateStr;
                    document.getElementById('turnoModal').classList.remove('hidden');
                    document.getElementById('turnoModal').classList.add('flex');
                },

                eventClick: function(info) {
                    const evento = info.event;

                    if (!evento.id.startsWith('turno-')) {
                        return;
                    }

                    const id = evento.id.replace('turno-', '');

                    document.getElementById('editTurnoId').value = id;

                    if (evento.title.includes('mattina')) {
                        document.getElementById('editTurnoSelect').value = 'mattina';
                    } else if (evento.title.includes('pomeriggio')) {
                        document.getElementById('editTurnoSelect').value = 'pomeriggio';
                    } else if (evento.title.includes('notte')) {
                        document.getElementById('editTurnoSelect').value = 'notte';
                    }

                    document.getElementById('editModal').classList.remove('hidden');
                    document.getElementById('editModal').classList.add('flex');
                }
            });

            calendar.render();
            document.getElementById('tipoFiltro')
    .addEventListener('change', function () {

        calendar.refetchEvents();

});

document.getElementById('dipendenteFiltro')
    .addEventListener('change', function () {

        calendar.refetchEvents();

});
        });

        function closeModal() {
            document.getElementById('turnoModal').classList.add('hidden');
            document.getElementById('turnoModal').classList.remove('flex');
        }

        function closeEditModal() {
            document.getElementById('editModal').classList.add('hidden');
            document.getElementById('editModal').classList.remove('flex');
        }

        function saveTurno() {
            fetch('/calendar-turno', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    data: document.getElementById('selectedDate').value,
                    dipendente_id: document.getElementById('dipendenteSelect').value,
                    turno: document.getElementById('turnoSelect').value
                })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    closeModal();
                    calendar.refetchEvents();
                } else {
                    alert('Errore');
                }
            });
        }

        function updateTurno() {
            const id = document.getElementById('editTurnoId').value;

            fetch('/calendar-update-turno/' + id, {
                method: 'PUT',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    turno: document.getElementById('editTurnoSelect').value
                })
            })
            .then(res => res.json())
            .then(data => {
                closeEditModal();
                calendar.refetchEvents();
            });
        }

        function deleteTurno() {
            const id = document.getElementById('editTurnoId').value;

            if (!confirm('Eliminare turno?')) return;

            fetch('/calendar-delete-turno/' + id, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                }
            })
            .then(res => res.json())
            .then(data => {
                closeEditModal();
                calendar.refetchEvents();
            });
        }
    </script>
</x-app-layout>