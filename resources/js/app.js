import { Calendar } from '@fullcalendar/core'
import dayGridPlugin from '@fullcalendar/daygrid'

document.addEventListener('DOMContentLoaded', function () {
    let el = document.getElementById('calendar');

    if (!el) return;

    let modal = document.getElementById('editModal');

    let calendar = new Calendar(el, {
        plugins: [dayGridPlugin],
        initialView: 'dayGridMonth',
        events: window.turniEvents ?? [],

        dateClick: function(info) {
            let turno = prompt("Inserisci turno (mattina/pomeriggio/notte):");
            let dipendente = prompt("Nome dipendente:");

            if (!turno) return;

            fetch('/turni', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    data: info.dateStr,
                    turno: turno,
                    dipendente: dipendente
                })
            }).then(() => {
                location.reload();
            });
        },

        eventClick: function(info) {

            let event = info.event;

            modal.classList.remove('hidden');

            document.getElementById('editData').value = event.startStr.substring(0,10);

            let parts = event.title.split(' - ');

            document.getElementById('editTurno').value = parts[0] || '';
            document.getElementById('editDipendente').value = parts[1] || '';
            document.getElementById('editNote').value = '';

            document.getElementById('editForm').action = '/turni/' + event.id;
        }

    });

    calendar.render();

    // ESC per chiudere modal (FUORI dal calendar, fatto UNA SOLA VOLTA)
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') {
            modal.classList.add('hidden');
        }
    });
});