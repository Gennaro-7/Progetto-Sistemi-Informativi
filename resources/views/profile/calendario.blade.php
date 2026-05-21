<x-app-layout>
    <x-slot name="header">
        <h2>Calendario Aziendale</h2>
    </x-slot>

    <div class="p-6">
        <div class="bg-white p-6 rounded shadow">
            <div id="calendar" style="min-height: 700px;"></div>
        </div>
    </div>

    @vite('resources/js/calendar.js')
</x-app-layout>