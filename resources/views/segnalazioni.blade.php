<x-app-layout>

    <div class="p-6">

        @if(auth()->user()->role === 'dipendente')
            <form method="POST"
                  action="{{ route('segnalazioni.store') }}"
                  class="bg-white p-6 rounded shadow mb-6 space-y-4">

                @csrf

                <input type="text"
                       name="titolo"
                       placeholder="Titolo segnalazione"
                       class="border rounded w-full p-2"
                       required>

                <textarea name="descrizione"
                          placeholder="Descrizione"
                          class="border rounded w-full p-2"
                          rows="5"
                          required></textarea>

                <button type="submit"
                        class="bg-blue-500 text-white px-4 py-2 rounded">
                    Invia Segnalazione
                </button>
            </form>
        @endif

        <div class="space-y-4">

            @foreach($segnalazioni as $s)
                <div class="bg-white p-6 rounded shadow">

                    <div class="flex justify-between items-center mb-2">

                        <h3 class="font-bold text-lg">
                            {{ $s->titolo }}
                        </h3>

                        @if(auth()->user()->role === 'admin')

                            <form method="POST"
                                  action="{{ route('segnalazioni.stato', $s->id) }}">

                                @csrf
                                @method('PUT')

                                <select name="stato"
                                        onchange="this.form.submit()"
                                        class="border rounded px-2 py-1 text-sm">

                                    <option value="aperta" @selected($s->stato === 'aperta')>
                                        Aperta
                                    </option>

                                    <option value="in lavorazione" @selected($s->stato === 'in lavorazione')>
                                        In lavorazione
                                    </option>

                                    <option value="chiusa" @selected($s->stato === 'chiusa')>
                                        Chiusa
                                    </option>

                                </select>
                            </form>

                        @else

                            <span class="px-3 py-1 rounded text-white text-sm
                                @if($s->stato === 'aperta') bg-red-500
                                @elseif($s->stato === 'in lavorazione') bg-yellow-500
                                @else bg-green-500
                                @endif">
                                {{ $s->stato }}
                            </span>

                        @endif

                    </div>

                    <div class="text-sm text-gray-500 mb-3">
                        {{ optional($s->dipendente)->nome }}
                        {{ optional($s->dipendente)->cognome }}
                    </div>

                    <p>
                        {{ $s->descrizione }}
                    </p>

                </div>
            @endforeach

        </div>

    </div>
</x-app-layout>