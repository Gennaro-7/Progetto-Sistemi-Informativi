<nav x-data="{ open: false, calOpen: false }"
     class="bg-teal-500 border-b border-teal-600">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">

                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-white" />
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-6">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')

                        <x-nav-link :href="route('dipendenti')" :active="request()->routeIs('dipendenti')">
                            Dipendenti
                        </x-nav-link>

                        <div class="relative">
                            <button @click="calOpen = !calOpen"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-white hover:text-gray-100">
                                Calendario

                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </button>

                            <div x-show="calOpen" @click.away="calOpen=false"
                                class="absolute mt-2 w-52 bg-white shadow-lg rounded-md py-2 z-50">

                                <a href="{{ route('turni') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Gestione Turni
                                </a>

                                <a href="{{ route('ferie') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Ferie
                                </a>

                                <a href="{{ route('calendario') }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
                                    Calendario Completo
                                </a>
                            </div>
                        </div>

                        <x-nav-link :href="route('stipendi')" :active="request()->routeIs('stipendi')">
                            Storico Stipendi
                        </x-nav-link>

                        <x-nav-link :href="route('convenzioni')" :active="request()->routeIs('convenzioni')">
                            Convenzioni
                        </x-nav-link>

                        @php
                            $segnalazioniAperte = \App\Models\Segnalazione::where('stato', 'aperta')->count();
                        @endphp

                        <a href="{{ route('segnalazioni') }}"
                           class="inline-flex items-center px-1 pt-1 border-b-2 text-sm font-medium leading-5 transition duration-150 ease-in-out
                           {{ request()->routeIs('segnalazioni')
                                ? 'border-white text-white'
                                : 'border-transparent text-white hover:text-gray-100 hover:border-white' }}">

                            Segnalazioni / Reclami

                            @if(auth()->user()->role === 'admin' && $segnalazioniAperte > 0)
                                <span class="ml-2 bg-red-500 text-white text-xs px-2 py-1 rounded-full">
                                    {{ $segnalazioniAperte }}
                                </span>
                            @endif
                        </a>

                    @endif

                    @if(Auth::user()->role === 'dipendente')

                        <x-nav-link :href="route('turni')" :active="request()->routeIs('turni')">
                            I miei turni
                        </x-nav-link>

                        <x-nav-link :href="route('ferie')" :active="request()->routeIs('ferie')">
                            Le mie ferie
                        </x-nav-link>

                        <x-nav-link :href="route('stipendi')" :active="request()->routeIs('stipendi')">
                            Le mie buste paga
                        </x-nav-link>

                        <x-nav-link :href="route('segnalazioni')" :active="request()->routeIs('segnalazioni')">
                            Segnalazioni
                        </x-nav-link>

                    @endif

                </div>
            </div>

            <div class="hidden sm:flex sm:items-center sm:ms-6 space-x-4">

               <div class="relative" x-data="{ profileOpen: false }">

    <button @click="profileOpen = !profileOpen"
            class="text-sm text-white hover:text-gray-100 flex items-center gap-2">

        {{ Auth::user()->name }}

        <svg class="h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd"
                d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
        </svg>
    </button>

    <div x-show="profileOpen"
         @click.away="profileOpen = false"
         class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-50">

        <a href="{{ route('profile.edit') }}"
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">
            Profilo
        </a>

        <form method="POST" action="{{ route('logout') }}">
            @csrf

            <button type="submit"
                    class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-gray-100">
                Logout
            </button>
        </form>

    </div>

</div>

            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-white">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2 bg-teal-500 text-white">

        <a href="{{ route('dashboard') }}" class="block">Dashboard</a>

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('dipendenti') }}" class="block">Dipendenti</a>
            <a href="{{ route('turni') }}" class="block">Gestione Turni</a>
            <a href="{{ route('ferie') }}" class="block">Ferie</a>
            <a href="{{ route('calendario') }}" class="block">Calendario Completo</a>
            <a href="{{ route('stipendi') }}" class="block">Storico Stipendi</a>
            <a href="{{ route('convenzioni') }}" class="block">Convenzioni</a>
            <a href="{{ route('segnalazioni') }}" class="block">Segnalazioni / Reclami</a>
        @endif

        @if(Auth::user()->role === 'dipendente')
            <a href="{{ route('turni') }}" class="block">I miei turni</a>
            <a href="{{ route('ferie') }}" class="block">Le mie ferie</a>
            <a href="{{ route('stipendi') }}" class="block">Le mie buste paga</a>
            <a href="{{ route('segnalazioni') }}" class="block">Segnalazioni</a>
        @endif

        <div class="border-t border-teal-300 pt-3 mt-3">

            <div class="text-sm mb-2">
                {{ Auth::user()->name }}
            </div>

            <a href="{{ route('profile.edit') }}" class="block">
                Profilo
            </a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="block text-left text-white mt-2">
                    Logout
                </button>
            </form>

        </div>

    </div>
</nav>