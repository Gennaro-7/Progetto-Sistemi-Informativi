<x-app-layout>

    <div class="mb-10 relative overflow-hidden">

    <div id="slider" class="relative h-[520px]">

        <img src="{{ asset('images/poliba-home.png') }}"
             class="slide absolute inset-0 w-full h-full object-cover opacity-100 transition-opacity duration-700">

        <img src="{{ asset('images/poliba-home2.png') }}"
             class="slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700">

        <img src="{{ asset('images/poliba-home3.png') }}"
             class="slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700">

        <img src="{{ asset('images/poliba-home4.png') }}"
             class="slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700">

        <img src="{{ asset('images/poliba-home5.png') }}"
             class="slide absolute inset-0 w-full h-full object-cover opacity-0 transition-opacity duration-700">

        <!-- Freccia sinistra -->
        <button id="prev"
                class="absolute left-5 top-1/2 -translate-y-1/2
                       bg-black/40 hover:bg-black/60
                       text-white text-4xl
                       w-12 h-12 rounded-full
                       flex items-center justify-center
                       transition">
            ‹
        </button>

        <!-- Freccia destra -->
        <button id="next"
                class="absolute right-5 top-1/2 -translate-y-1/2
                       bg-black/40 hover:bg-black/60
                       text-white text-4xl
                       w-12 h-12 rounded-full
                       flex items-center justify-center
                       transition">
            ›
        </button>

    </div>

</div>

        <div class="px-6 pt-8 pb-12">
            <h2 class="text-2xl font-bold text-teal-600 mb-4">
                Accesso rapido
            </h2>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

            @if(auth()->user()->role === 'admin')
                <a href="{{ route('dipendenti') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-20 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 text-teal-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M15.75 6.75a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.5 20.25a7.5 7.5 0 0 1 15 0M18 8.25a3 3 0 0 1 0 6M21 20.25a6 6 0 0 0-3.75-5.56" />
                        </svg>
                    </div>
                    <div class="font-bold text-gray-900">Dipendenti</div>
                    <div class="text-sm text-gray-500">Gestione personale</div>
                </a>
            @endif    

                <a href="{{ route('turni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 text-teal-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M6.75 3v2.25M17.25 3v2.25M3.75 9.75h16.5M5.25 5.25h13.5A1.5 1.5 0 0 1 20.25 6.75v12A1.5 1.5 0 0 1 18.75 20.25H5.25A1.5 1.5 0 0 1 3.75 18.75v-12A1.5 1.5 0 0 1 5.25 5.25Z" />
                        </svg>
                    </div>
                    <div class="font-bold text-gray-900">Turni</div>
                    <div class="text-sm text-gray-500">Assegnazione turni</div>
                </a>

                <a href="{{ route('ferie') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 text-teal-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M12 3v1.5M12 19.5V21M3 12h1.5M19.5 12H21M5.636 5.636l1.06 1.06M17.304 17.304l1.06 1.06M18.364 5.636l-1.06 1.06M6.696 17.304l-1.06 1.06M16.5 12a4.5 4.5 0 1 1-9 0 4.5 4.5 0 0 1 9 0Z" />
                        </svg>
                    </div>
                    <div class="font-bold text-gray-900">Ferie</div>
                    <div class="text-sm text-gray-500">Richieste ferie</div>
                </a>

                <a href="{{ route('stipendi') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 text-teal-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M2.25 6.75A2.25 2.25 0 0 1 4.5 4.5h15a2.25 2.25 0 0 1 2.25 2.25v10.5A2.25 2.25 0 0 1 19.5 19.5h-15a2.25 2.25 0 0 1-2.25-2.25V6.75Zm0 2.25h19.5M6.75 15h3" />
                        </svg>
                    </div>
                    <div class="font-bold text-gray-900">Stipendi</div>
                    <div class="text-sm text-gray-500">Buste paga</div>
                </a>

                <a href="{{ route('documenti') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                   <div class="flex justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor"
                        class="w-10 h-10 text-teal-600">
                        <path stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M14.25 2.25H6.75A2.25 2.25 0 0 0 4.5 4.5v15A2.25 2.25 0 0 0 6.75 21.75h10.5A2.25 2.25 0 0 0 19.5 19.5V7.5L14.25 2.25Zm0 0V7.5h5.25M8.25 12h7.5M8.25 15.75h7.5" />
                    </svg>
                   </div>
                    <div class="font-bold text-gray-900">Documenti</div>
                    <div class="text-sm text-gray-500">Archivio documentale</div>
                </a>

                <a href="{{ route('convenzioni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 text-teal-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M3 7.5h18M6.75 7.5V5.25A2.25 2.25 0 0 1 9 3h6a2.25 2.25 0 0 1 2.25 2.25V7.5M4.5 7.5v11.25A2.25 2.25 0 0 0 6.75 21h10.5a2.25 2.25 0 0 0 2.25-2.25V7.5M9 12h6" />
                        </svg>
                    </div>
                    <div class="font-bold text-gray-900">Convenzioni</div>
                    <div class="text-sm text-gray-500">Vantaggi aziendali</div>
                </a>

                <a href="{{ route('segnalazioni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                    <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 text-teal-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M10.34 3.94 2.82 16.5a2.25 2.25 0 0 0 1.93 3.38h14.5a2.25 2.25 0 0 0 1.93-3.38L13.66 3.94a2.25 2.25 0 0 0-3.32 0ZM12 9v4.5M12 17.25h.008v.008H12v-.008Z" />
                        </svg>
                    </div>
                    <div class="font-bold text-gray-900">Segnalazioni</div>
                    <div class="text-sm text-gray-500">Reclami e richieste</div>
                </a>

                @if(auth()->user()->role === 'admin')
                    <a href="{{ route('valutazioni') }}" class="bg-white border border-gray-200 rounded-2xl shadow-md p-7 hover:shadow-xl hover:-translate-y-1 transition duration-200 text-center">
                       <div class="flex justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke-width="1.5"
                            stroke="currentColor"
                            class="w-10 h-10 text-teal-600">
                            <path stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M11.48 3.5a.56.56 0 0 1 1.04 0l2.1 5.1 5.5.45a.56.56 0 0 1 .32.98l-4.2 3.6 1.28 5.36a.56.56 0 0 1-.84.61L12 16.74 7.32 19.6a.56.56 0 0 1-.84-.61l1.28-5.36-4.2-3.6a.56.56 0 0 1 .32-.98l5.5-.45 2.1-5.1Z" />
                        </svg>
                       </div>
                        <div class="font-bold text-gray-900">Valutazioni</div>
                        <div class="text-sm text-gray-500">Performance dipendenti</div>
                    </a>
                @endif

            </div>
        </div>

    </div>

<script>
    const slides = document.querySelectorAll('.slide');
    const prev = document.getElementById('prev');
    const next = document.getElementById('next');

    let current = 0;

    function showSlide(index) {
        slides[current].classList.remove('opacity-100');
        slides[current].classList.add('opacity-0');

        current = index;

        slides[current].classList.remove('opacity-0');
        slides[current].classList.add('opacity-100');
    }

    next.addEventListener('click', () => {
        showSlide((current + 1) % slides.length);
    });

    prev.addEventListener('click', () => {
        showSlide((current - 1 + slides.length) % slides.length);
    });

    setInterval(() => {
        showSlide((current + 1) % slides.length);
    }, 5000);
</script>
</x-app-layout>