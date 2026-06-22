<section>
    <header>
        <h2 class="text-lg font-medium text-gray-900">
            Foto profilo
        </h2>

        <p class="mt-1 text-sm text-gray-600">
            Carica o aggiorna la tua foto profilo.
        </p>
    </header>

    <form method="POST"
          action="{{ route('profile.photo') }}"
          enctype="multipart/form-data"
          class="mt-6 space-y-6">

        @csrf

        @php
            $dipendente = \App\Models\Dipendente::where('user_id', auth()->id())->first();
        @endphp

        @if($dipendente && $dipendente->foto)
            <img src="{{ asset('storage/'.$dipendente->foto) }}"
                 class="w-24 h-24 rounded-full object-cover border mb-4">
        @else
            <div class="w-24 h-24 rounded-full bg-teal-500 flex items-center justify-center text-white text-3xl font-bold mb-4">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        @endif

        <input type="file"
               name="foto"
               accept="image/*"
               class="border border-gray-300 rounded-lg p-3 w-full"
               required>

        <button type="submit"
                class="bg-teal-500 hover:bg-teal-600 text-white px-4 py-2 rounded-lg">
            Aggiorna foto
        </button>
    </form>
</section>