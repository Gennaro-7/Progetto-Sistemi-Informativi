<x-app-layout>
    <div class="p-6 space-y-6">

        <div>
    <p class="text-2xl text-teal-600 mt-1">
        Benvenuto in PoliWork HR
    </p>
</div>

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            @if(auth()->user()->role === 'admin')
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                    <div class="text-sm text-gray-500">Dipendenti</div>
                    <div class="text-4xl font-bold text-teal-600 mt-2">
                        {{ $totaleDipendenti }}
                    </div>
                </div>
            @endif

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <div class="text-sm text-gray-500">Turni</div>
                <div class="text-4xl font-bold text-blue-600 mt-2">
                    {{ $totaleTurni }}
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <div class="text-sm text-gray-500">Ferie in attesa</div>
                <div class="text-4xl font-bold text-yellow-500 mt-2">
                    {{ $ferieInAttesa }}
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <div class="text-sm text-gray-500">Buste paga</div>
                <div class="text-4xl font-bold text-purple-600 mt-2">
                    {{ $totaleStipendi }}
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <h3 class="font-bold text-gray-900 mb-4">
                    Ultimi turni
                </h3>

                <div class="space-y-3">
                    @forelse($ultimiTurni as $turno)
                        <div class="flex justify-between border-b border-gray-100 pb-3">
                            <div>
                                <div class="font-semibold text-gray-900">
                                    {{ ucfirst($turno->turno) }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ optional($turno->dipendente)->nome }}
                                    {{ optional($turno->dipendente)->cognome }}
                                </div>
                            </div>

                            <div class="text-sm text-gray-500">
                                {{ $turno->data }}
                            </div>
                        </div>
                    @empty
                        <p class="text-gray-500">
                            Nessun turno presente.
                        </p>
                    @endforelse
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <h3 class="font-bold text-gray-900 mb-4">
                    Ultime ferie
                </h3>

                <div class="space-y-3">
                    @forelse($ultimeFerie as $ferie)
                        <div class="flex justify-between border-b border-gray-100 pb-3">
                            <div>
                                <div class="font-semibold text-gray-900">
                                    {{ $ferie->data_inizio }} → {{ $ferie->data_fine }}
                                </div>

                                <div class="text-sm text-gray-500">
                                    {{ optional($ferie->dipendente)->nome }}
                                    {{ optional($ferie->dipendente)->cognome }}
                                </div>
                            </div>

                            <span class="h-fit px-3 py-1 rounded-full text-white text-xs
                                @if($ferie->stato === 'approvata') bg-green-500
                                @elseif($ferie->stato === 'rifiutata') bg-red-500
                                @else bg-yellow-500
                                @endif">
                                {{ $ferie->stato }}
                            </span>
                        </div>
                    @empty
                        <p class="text-gray-500">
                            Nessuna ferie presente.
                        </p>
                    @endforelse
                </div>
            </div>

        </div>

        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
            <h3 class="font-bold text-gray-900 mb-4">
                Statistiche ferie
            </h3>

            <canvas id="ferieChart" height="100"></canvas>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('ferieChart');

            if (!ctx) return;

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Approvate', 'Rifiutate', 'In attesa'],
                    datasets: [{
                        label: 'Richieste ferie',
                        data: [
                            {{ $ferieApprovate ?? 0 }},
                            {{ $ferieRifiutate ?? 0 }},
                            {{ $ferieInAttesa ?? 0 }}
                        ],
                        backgroundColor: [
                            '#22c55e',
                            '#ef4444',
                            '#eab308'
                        ],
                        borderRadius: 10
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            display: false
                        }
                    }
                }
            });
        });
    </script>
<script>
    Swal.fire({
        toast: true,
        position: 'top-end',
        icon: 'success',
        title: 'Sistema notifiche attivo',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true
    });
</script>
</x-app-layout>