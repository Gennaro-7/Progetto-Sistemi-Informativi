import { Calendar } from '@fullcalendar/core';
import dayGridPlugin from '@fullcalendar/daygrid';
import interactionPlugin from '@fullcalendar/interaction';

document.addEventListener('DOMContentLoaded', function () {

    const calendarEl = document.getElementById('calendar');

    if (!calendarEl) return;

    const calendar = new Calendar(calendarEl, {

        plugins: [
            dayGridPlugin,
            interactionPlugin
        ],

        initialView: 'dayGridMonth',

        locale: 'it',

        height: 700,

        events: '/calendar-events',

        dateClick: function(info) {

            const dipendente = prompt('Nome dipendente');

            if (!dipendente) return;

            const turno = prompt('Turno (mattina/pomeriggio/notte)');

            if (!turno) return;

            fetch('/calendar-turno', {

                method: 'POST',

                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                },

                body: JSON.stringify({
                    data: info.dateStr,
                    dipendente: dipendente,
                    turno: turno
                })

            })
            .then(response => response.json())
            .then(data => {

                if (data.success) {

                    alert('Turno creato');

                    calendar.refetchEvents();

                } else {

                    alert('Errore');

                }

            });

        }

    });

    calendar.render();

});