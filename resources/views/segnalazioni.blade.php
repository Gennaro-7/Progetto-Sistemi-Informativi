<x-app-layout>

<div class="p-6 space-y-6">
    <div>
        <h1 class="text-2xl font-medium text-teal-600">
            Segnalazioni / Reclami
        </h1>

        <p class="text-gray-600">
            Gestisci le segnalazioni inviate dai dipendenti
        </p>
    </div>
    
    <div class="p-6">

        @if(auth()->user()->role === 'dipendente')
            <form method="POST"
                  action="{{ route('segnalazioni.store') }}"
                  class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md mb-6 space-y-4">

                @csrf

                <input type="text"
                       name="titolo"
                       placeholder="Titolo segnalazione"
                       class="border border-gray-300 rounded-lg w-full p-3"
                       required>

                <textarea name="descrizione"
                          placeholder="Descrizione"
                          class="border border-gray-300 rounded-lg w-full p-3"
                          rows="5"
                          required></textarea>

                <button type="submit"
                        class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                    Invia Segnalazione
                </button>
            </form>
        @endif

        <div class="space-y-4">
<h2 class="text-xl font-bold text-teal-600 mb-4">
    Elenco segnalazioni
</h2>
            @foreach($segnalazioni as $s)
                <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">

                    <div class="flex justify-between items-start gap-4 mb-3">

                        <div>
                            <h3 class="font-bold text-lg text-gray-900">
                                {{ $s->titolo }}
                            </h3>

                            <div class="text-sm text-gray-500 mt-1">
                                {{ optional($s->dipendente)->nome }}
                                {{ optional($s->dipendente)->cognome }}

                                @if($s->created_at)
                                    • {{ $s->created_at->format('d/m/Y H:i') }}
                                @endif
                            </div>
                        </div>

                        <div class="flex flex-col items-end gap-2 space-y-3">

                            @if($s->stato === 'aperta')
                                <span class="bg-red-500 text-white px-3 py-1 rounded-full text-xs">
                                    Aperta
                                </span>
                            @elseif($s->stato === 'in_lavorazione')
                                <span class="bg-yellow-500 text-white px-3 py-1 rounded-full text-xs">
                                    In lavorazione
                                </span>
                            @else
                                <span class="bg-green-500 text-white px-3 py-1 rounded-full text-xs">
                                    Chiusa
                                </span>
                            @endif

                            @if(auth()->user()->role === 'admin')
                                <form method="POST"
                                      action="{{ route('segnalazioni.stato', $s->id) }}">

                                    @csrf
                                    @method('PUT')

                                    <select name="stato"
                                            onchange="this.form.submit()"
                                            class="border border-gray-300 rounded-lg px-2 py-1 text-sm">

                                        <option value="aperta" @selected($s->stato === 'aperta')>
                                            Aperta
                                        </option>

                                        <option value="in_lavorazione" @selected($s->stato === 'in_lavorazione')>
                                            In lavorazione
                                        </option>

                                        <option value="chiusa" @selected($s->stato === 'chiusa')>
                                            Chiusa
                                        </option>

                                    </select>
                                    </form>
<form method="POST"
      action="{{ route('segnalazioni.destroy', $s->id) }}"
      class="delete-form-segnalazione">

    @csrf
    @method('DELETE')

    <button type="submit"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm">
        Elimina
    </button>
</form>
                            
                            @endif

                        </div>

                    </div>

                    <p class="text-gray-700">
                        {{ $s->descrizione }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>
<script>
document.querySelectorAll('form.delete-form-segnalazione').forEach(form => {
    form.addEventListener('submit', function(e) {
        e.preventDefault();

        Swal.fire({
            title: 'Sei sicuro?',
            text: 'La segnalazione verrà eliminata definitivamente.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#ef4444',
            cancelButtonColor: '#6b7280',
            confirmButtonText: 'Sì, elimina',
            cancelButtonText: 'Annulla'
        }).then((result) => {
            if (result.isConfirmed) {
                form.submit();
            }
        });
    });
});
</script>
</x-app-layout>