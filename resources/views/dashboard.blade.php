<x-app-layout>
    <div class="p-6">

        <div class="mt-4 mb-6">
            <h1 class="text-2xl font-medium text-teal-600">
                Benvenuto in PoliWork HR
            </h1>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-5 gap-4">

            @if(auth()->user()->role === 'admin')
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                    <div class="text-sm text-gray-500">👥 Dipendenti</div>
                    <div class="text-4xl font-bold text-teal-600 mt-2">
                        {{ $totaleDipendenti }}
                    </div>
                </div>
            @endif

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <div class="text-sm text-gray-500">📅 Turni</div>
                <div class="text-4xl font-bold text-blue-600 mt-2">
                    {{ $totaleTurni }}
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <div class="text-sm text-gray-500">🏖️ Ferie in attesa</div>
                <div class="text-4xl font-bold text-yellow-500 mt-2">
                    {{ $ferieInAttesa }}
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <div class="text-sm text-gray-500">💰 Buste paga</div>
                <div class="text-4xl font-bold text-purple-600 mt-2">
                    {{ $totaleStipendi }}
                </div>
            </div>

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <div class="text-sm text-gray-500">📄 Documenti</div>
                <div class="text-4xl font-bold text-cyan-600 mt-2">
                    {{ $totaleDocumenti }}
                </div>
            </div>

        </div>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mt-4">

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">
                <h3 class="font-bold text-gray-900 mb-4">
                    Ultimi turni
                </h3>

                <div class="space-y-6">
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
                                {{ \Carbon\Carbon::parse($turno->data)->format('d/m/Y') }}
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

                <div class="space-y-6">
                    @forelse($ultimeFerie as $ferie)
                        <div class="flex justify-between border-b border-gray-100 pb-3">
                            <div>
                                <div class="font-semibold text-gray-900">
                                     {{ \Carbon\Carbon::parse($ferie->data_inizio)->format('d/m/Y') }} → {{ \Carbon\Carbon::parse($ferie->data_fine)->format('d/m/Y') }}
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
                                {{ $ferie->stato === 'in_attesa' ? 'In attesa' : ucfirst($ferie->stato) }}
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

        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md mt-4">
            <h3 class="font-bold text-gray-900 mb-4">
                Statistiche ferie
            </h3>

            <div class="flex justify-center">
                <canvas id="ferieChart" style="max-height: 260px;"></canvas>
            </div>

            <div class="flex justify-center gap-6 mt-4 text-sm">
                <div class="text-green-600 font-semibold">
                    Approvate: {{ $ferieApprovate }}
                </div>

                <div class="text-red-600 font-semibold">
                    Rifiutate: {{ $ferieRifiutate }}
                </div>

                <div class="text-yellow-500 font-semibold">
                    In attesa: {{ $ferieInAttesa }}
                </div>
            </div>
        </div>

    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const ctx = document.getElementById('ferieChart');

            if (!ctx) return;

            new Chart(ctx, {
                type: 'doughnut',
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
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            position: 'bottom'
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>