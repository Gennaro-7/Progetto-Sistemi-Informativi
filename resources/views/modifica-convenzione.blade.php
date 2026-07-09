<x-app-layout>

    <div class="p-6">

        <div class="bg-white border border-gray-200 rounded-2xl shadow-md p-6">

            <h1 class="text-2xl font-medium text-teal-600 mb-6">
                Modifica Convenzione
            </h1>

            <form method="POST"
                  action="{{ route('convenzioni.update', $convenzione->id) }}"
                  class="space-y-4">

                @csrf
                @method('PUT')

                <input type="text"
                       name="titolo"
                       value="{{ $convenzione->titolo }}"
                       class="border border-gray-300 rounded-lg p-3 w-full"
                       required>

                <input type="text"
                       name="azienda"
                       value="{{ $convenzione->azienda }}"
                       class="border border-gray-300 rounded-lg p-3 w-full">

                <input type="number"
                       name="sconto"
                       value="{{ $convenzione->sconto }}"
                       class="border border-gray-300 rounded-lg p-3 w-full">

                <input type="url"
                       name="link"
                       value="{{ $convenzione->link }}"
                       class="border border-gray-300 rounded-lg p-3 w-full">

                <textarea name="descrizione"
                          rows="4"
                          class="border border-gray-300 rounded-lg p-3 w-full">{{ $convenzione->descrizione }}</textarea>

                <div class="flex gap-3">

                    <button type="submit"
                            class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
                        Salva modifiche
                    </button>

                    <a href="{{ route('convenzioni') }}"
                       class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-lg">
                        Annulla
                    </a>

                </div>

            </form>

        </div>

    </div>

</x-app-layout>