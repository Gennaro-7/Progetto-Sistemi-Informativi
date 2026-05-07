<nav x-data="{ open: false, calOpen: false }" class="bg-white dark:bg-gray-800 border-b border-gray-100 dark:border-gray-700">

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">

            <div class="flex">

                <div class="shrink-0 flex items-center">
                    <a href="{{ route('dashboard') }}">
                        <x-application-logo class="block h-9 w-auto fill-current text-gray-800 dark:text-gray-200" />
                    </a>
                </div>

                <div class="hidden sm:flex sm:items-center sm:ms-10 space-x-6">

                    <x-nav-link :href="route('dashboard')" :active="request()->routeIs('dashboard')">
                        Dashboard
                    </x-nav-link>

                    @if(Auth::user()->role === 'admin')

                        <div class="relative">
                            <button @click="calOpen = !calOpen"
                                class="inline-flex items-center px-3 py-2 text-sm font-medium text-gray-500 dark:text-gray-300 hover:text-gray-700 dark:hover:text-white">
                                Calendario
                                <svg class="ml-1 h-4 w-4" fill="currentColor" viewBox="0 0 20 20">
                                    <path fill-rule="evenodd"
                                        d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"/>
                                </svg>
                            </button>

                            <div x-show="calOpen" @click.away="calOpen=false"
                                class="absolute mt-2 w-52 bg-white dark:bg-gray-800 shadow-lg rounded-md py-2 z-50">

                                <a href="{{ route('turni') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Gestione Turni
                                </a>

                                <a href="{{ route('ferie') }}" class="block px-4 py-2 text-sm hover:bg-gray-100 dark:hover:bg-gray-700">
                                    Ferie
                                </a>
                            </div>
                        </div>

                        <x-nav-link :href="route('stipendi')" :active="request()->routeIs('stipendi')">
                            Storico Stipendi
                        </x-nav-link>

                        <x-nav-link :href="route('convenzioni')" :active="request()->routeIs('convenzioni')">
                            Convenzioni
                        </x-nav-link>

                        <x-nav-link :href="route('segnalazioni')" :active="request()->routeIs('segnalazioni')">
                            Segnalazioni / Reclami
                        </x-nav-link>

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

            <div class="hidden sm:flex sm:items-center sm:ms-6">
                <x-dropdown align="right" width="48">
                    <x-slot name="trigger">
                        <button class="inline-flex items-center px-3 py-2 text-sm text-gray-500 dark:text-gray-300">
                            <div>{{ Auth::user()->name }}</div>
                        </button>
                    </x-slot>

                    <x-slot name="content">
                        <x-dropdown-link :href="route('profile.edit')">
                            Profilo
                        </x-dropdown-link>

                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <x-dropdown-link :href="route('logout')"
                                onclick="event.preventDefault(); this.closest('form').submit();">
                                Logout
                            </x-dropdown-link>
                        </form>
                    </x-slot>
                </x-dropdown>
            </div>

            <div class="-me-2 flex items-center sm:hidden">
                <button @click="open = !open" class="p-2 text-gray-500 dark:text-gray-300">
                    ☰
                </button>
            </div>

        </div>
    </div>

    <div x-show="open" class="sm:hidden px-4 pb-4 space-y-2">

        <a href="{{ route('dashboard') }}" class="block">Dashboard</a>

        @if(Auth::user()->role === 'admin')
            <a href="{{ route('turni') }}" class="block">Gestione Turni</a>
            <a href="{{ route('ferie') }}" class="block">Ferie</a>
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

    </div>

</nav>