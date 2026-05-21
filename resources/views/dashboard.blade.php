<x-app-layout>


    <div class="p-6 space-y-6">

        <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            @if(auth()->user()->role === 'admin')
                <div class="bg-blue-500 text-white p-6 rounded shadow">
                    <div class="text-sm">Dipendenti</div>
                    <div class="text-3xl font-bold">
                        {{ $totaleDipendenti }}
                    </div>
                </div>
            @endif

            <div class="bg-green-500 text-white p-6 rounded shadow">
                <div class="text-sm">Turni</div>
                <div class="text-3xl font-bold">
                    {{ $totaleTurni }}
                </div>
            </div>

            <div class="bg-yellow-500 text-white p-6 rounded shadow">
                <div class="text-sm">Ferie in attesa</div>
                <div class="text-3xl font-bold">
                    {{ $ferieInAttesa }}
                </div>
            </div>

            <div class="bg-purple-500 text-white p-6 rounded shadow">
                <div class="text-sm">Buste paga</div>
                <div class="text-3xl font-bold">
                    {{ $totaleStipendi }}
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-bold mb-4">
                    Ultimi turni
                </h3>

                <div class="space-y-3">
                    @foreach($ultimiTurni as $turno)
                        <div class="border-b pb-2">
                            <div class="font-semibold">
                                {{ $turno->turno }}
                            </div>

                            <div class="text-sm text-gray-500">
                                {{ $turno->data }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="bg-white p-6 rounded shadow">
                <h3 class="font-bold mb-4">
                    Ultime ferie
                </h3>

                <div class="space-y-3">
                    @foreach($ultimeFerie as $ferie)
                        <div class="border-b pb-2">
                            <div class="font-semibold">
                                {{ $ferie->data_inizio }} → {{ $ferie->data_fine }}
                            </div>

                            <div class="text-sm">
                                Stato:

                                <span class="
                                    @if($ferie->stato === 'approvata') text-green-500
                                    @elseif($ferie->stato === 'rifiutata') text-red-500
                                    @else text-yellow-500
                                    @endif
                                ">
                                    {{ $ferie->stato }}
                                </span>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="bg-white p-6 rounded shadow">
            <h3 class="font-bold mb-4">
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
                        borderRadius: 8
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

</x-app-layout>