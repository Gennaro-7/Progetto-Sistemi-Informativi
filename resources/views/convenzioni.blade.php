<x-app-layout>

    <div class="p-6 space-y-6">

        <div class="mb-6">
    <h1 class="text-2xl font-medium text-teal-600">
        Convenzioni Aziendali
    </h1>
</div>

        @if(auth()->user()->role === 'admin')

            <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">

                <form method="POST"
                      action="{{ route('convenzioni.store') }}"
                      class="space-y-4">

                    @csrf

                    <input type="text"
                           name="titolo"
                           placeholder="Titolo convenzione"
                           class="border border-gray-300 rounded-lg p-3 w-full"
                           required>

                    <input type="text"
                           name="azienda"
                           placeholder="Azienda"
                           class="border border-gray-300 rounded-lg p-3 w-full">

                    <input type="number"
                           name="sconto"
                           placeholder="Sconto %"
                           class="border border-gray-300 rounded-lg p-3 w-full">

                    <input type="url"
                           name="link"
                           placeholder="https://..."
                           class="border border-gray-300 rounded-lg p-3 w-full">

                    <textarea name="descrizione"
                              rows="4"
                              placeholder="Descrizione convenzione"
                              class="border border-gray-300 rounded-lg p-3 w-full"></textarea>

                    <button type="submit"
                            class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                        Aggiungi Convenzione
                    </button>

                </form>

            </div>

        @endif

        <div class="bg-white border border-gray-200 p-6 rounded-2xl shadow-md">

            <h3 class="font-bold text-gray-900 mb-4">
                Elenco Convenzioni
            </h3>

            <div class="space-y-4">

                @forelse($convenzioni as $c)

                    <div class="border border-gray-200 rounded-xl p-4">

                        <div class="font-semibold text-gray-900">
                            {{ $c->titolo }}
                        </div>

                        @if($c->azienda)
                            <div class="text-sm text-gray-500">
                                {{ $c->azienda }}
                            </div>
                        @endif

                        @if($c->sconto)
                            <div class="text-green-600 font-medium mt-1">
                                Sconto: {{ $c->sconto }}%
                            </div>
                        @endif

                        <p class="text-gray-700 mt-2">
                            {{ $c->descrizione }}
                        </p>

                        <div class="flex gap-2 mt-3">

    @if($c->link)
        <a href="{{ $c->link }}"
           target="_blank"
           class="bg-teal-500 hover:bg-teal-600 text-white px-3 py-2 rounded-lg text-sm">
            Apri convenzione
        </a>
    @endif

    @if(auth()->user()->role === 'admin')
        <form action="{{ route('convenzioni.destroy', $c->id) }}"
      method="POST"
      class="delete-form">
    @csrf
    @method('DELETE')

    <button type="submit"
            class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-sm">
        Elimina
    </button>
</form>
    @endif

</div>

                    </div>

                @empty

                    <p class="text-gray-500">
                        Nessuna convenzione disponibile.
                    </p>

                @endforelse

            </div>

        </div>

    </div>
<script>
document.querySelectorAll('.delete-form').forEach(form => {

    form.addEventListener('submit', function(e) {

        e.preventDefault();

        Swal.fire({
            title: 'Sei sicuro?',
            text: 'La convenzione verrà eliminata definitivamente.',
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