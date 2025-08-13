@extends('customer.layouts.main')
@section('container')

<div>
    {{-- Section 1 --}}
    <div class="flex flex-col-reverse md:grid md:grid-cols-2 md:justify-center items-center px-5 md:px-10 h-full py-20 md:py-0 md:h-screen">
        <div class="flex flex-col justify-start text-white mt-10 md:mt-0">
            <h1 class="font-calistoga text-2xl md:text-6xl mb-4 leading-snug">
                Discover The<br> Art Of Perfect Coffe 
            </h1>
            <p class="mb-4 text-base md:text-3xl leading-snug tracking-wider">
                experience the rich and bold flavor of our<br>
                exquisite coffee blends, crafted to awaken your<br>
                senses and start your day right.
            </p>
            <div class="flex justify-start gap-x-2 text-base md:text-xl">
                <a href="{{ route('customer.about-us') }}" class="bg-white hover:bg-gray-300 transition duration-500 ease-in-out text-black text-center px-6 rounded-md flex items-center py-2">
                    Explore More
                </a>
                <a href="/menu?category=all" class="bg-transparent hover:bg-darkGreenJagat transition duration-500 ease-in-out text-white border border-white text-center px-6 py-0 rounded-md flex items-center">
                    Order Now<span class="ml-3"><img src="{{ asset('img/icon/icon-arrow-right.png') }}" class="h-6 md:h-8" alt="icon arrow right"></span>
                </a>
            </div>
        </div>
        <div class="flex justify-end items-center md:mt-20">
            <img src="{{ asset('img/home/landing-page.jpg') }}" 
                class=" h-64 w-64 md:h-[33rem] md:w-[33rem] rounded-full border-4 border-white object-cover" 
                alt="Jabat Kopi">
        </div>
    </div>

    {{-- Divider Right --}}
    <div class="w-full flex justify-end py-10">
        <hr class=" w-2/3">
    </div>

    {{-- Section 2 --}}
    <div class="flex flex-col justify-center items-center h-full md:h-screen">
        <h1 class="font-calistoga text-white text-2xl md:text-5xl">Explore Our Jabat Kopi</h1>

        <div class="flex flex-col md:flex-row justify-center items-center mt-5 md:mt-10 gap-y-8 md:gap-y-0 gap-x-0 md:gap-x-20">
            
            <div class="max-w-sm flex flex-col justify-center p-4 md:p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-xl md:text-4xl tracking-tight text-greenJagat font-calistoga">The Drink</h5>
                <img src="{{ asset('img/home/the-drink.jpg') }}" class=" w-48 h-48 md:w-80 md:h-80 rounded-xl object-cover" alt="The Drink">
                <a href="/menu?category=Drink" class="mt-3 md:mt-5 px-6 py-2 text-sm md:text-lg font-medium text-center text-white bg-greenJagat hover:bg-darkGreenJagat transition duration-500 ease-in-out rounded-lg w-fit">
                    Find your drink here!
                </a>
            </div>

            <div class="max-w-sm flex flex-col justify-center p-4 md:p-6 bg-white border border-gray-200 rounded-lg shadow-sm">
                <h5 class="mb-2 text-xl md:text-4xl tracking-tight text-greenJagat font-calistoga">The Food</h5>
                <img src="{{ asset('img/home/the-food.jpg') }}" class=" w-48 h-48 md:w-80 md:h-80 rounded-xl object-cover" alt="The Drink">
                <a href="/menu?category=Food" class="mt-3 md:mt-5 px-6 py-2 text-sm md:text-lg font-medium text-center text-white bg-greenJagat hover:bg-darkGreenJagat transition duration-500 ease-in-out rounded-lg w-fit">
                    Find your food here!
                </a>
            </div>

        </div>
    </div>

    {{-- Divider Left --}}
    <div class="w-full flex justify-start py-10">
        <hr class=" w-2/3">
    </div>

    {{-- Section 3 --}}
    <div class="flex flex-col justify-center items-center h-full md:h-screen">
        <h1 class="font-calistoga text-white text-2xl md:text-5xl">Special Menu</h1>
        <p class="text-base md:text-3xl text-center text-white mt-3 md:mt-5">
            Some of our special menu is given here.<br class="md:hidden sm:block">there are what people<br class="hidden md:block">
            order more.<br class="md:hidden sm:block">If you want you can order from here.
        </p>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-x-5 md:gap-x-10 gap-y-20 px-10 mt-16 md:mt-28">

            <div class="relative max-w-sm flex flex-col justify-center p-4 md:p-2 bg-white border border-gray-200 rounded-b-lg shadow-sm">
                @if($isStoreOpen)
                <a href="/detail-item/MENU3685?category=Drink" class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-white hover:bg-gray-300 transition duration-500 ease-in-out text-greenJagat text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                    <i class="fa-solid fa-plus"></i>
                </a>
                @else
                    <button type="button"
                        onclick="storeClosedAlert()"
                        class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-gray-400 cursor-not-allowed text-white text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endif

                <img src="{{ asset('img/home/special-menu-coffe-latte.jpg') }}" class="w-28 h-28 md:w-56 md:h-56 rounded-full border-4 md:border-8 border-greenJagat object-cover -mt-16 md:-mt-24" alt="The Drink">

                <p class="text-sm md:text-2xl text-center mt-5 mb-2">
                    Coffee Latte<br>
                    Rp 35.000
                </p>
            </div>

            <div class="relative max-w-sm flex flex-col justify-center p-4 md:p-2 bg-white border border-gray-200 rounded-b-lg shadow-sm">
                @if($isStoreOpen)
                <a href="/detail-item/MENU8754?category=Drink" class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-white hover:bg-gray-300 transition duration-500 ease-in-out text-greenJagat text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                    <i class="fa-solid fa-plus"></i>
                </a>
                @else
                    <button type="button"
                        onclick="storeClosedAlert()"
                        class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-gray-400 cursor-not-allowed text-white text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endif

                <img src="{{ asset('img/home/special-menu-espresso.jpg') }}" class="w-28 h-28 md:w-56 md:h-56 rounded-full border-4 md:border-8 border-greenJagat object-cover -mt-16 md:-mt-24" alt="The Drink">

                <p class="text-sm md:text-2xl text-center mt-5 mb-2">
                    Espresso<br>
                    Rp 27.000
                </p>
            </div>

            <div class="relative max-w-sm flex flex-col justify-center p-4 md:p-2 bg-white border border-gray-200 rounded-b-lg shadow-sm">
                @if($isStoreOpen)
                    <a href="/detail-item/MENU9531?category=Drink" 
                    class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-white hover:bg-gray-300 transition duration-500 ease-in-out text-greenJagat text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                        <i class="fa-solid fa-plus"></i>
                    </a>
                @else
                    <button type="button"
                        onclick="storeClosedAlert()"
                        class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-gray-400 cursor-not-allowed text-white text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endif

                <img src="{{ asset('img/home/special-menu-sally-cinnamon.jpg') }}" class="w-28 h-28 md:w-56 md:h-56 rounded-full border-4 md:border-8 border-greenJagat object-cover -mt-16 md:-mt-24" alt="The Drink">

                <p class="text-sm md:text-2xl text-center mt-5 mb-2">
                    Sally Cinnamon<br>
                    Rp 35.000
                </p>
            </div>

            <div class="relative max-w-sm flex flex-col justify-center p-4 md:p-2 bg-white border border-gray-200 rounded-b-lg shadow-sm">
                @if($isStoreOpen)
                <a href="/detail-item/MENU1646?category=Drink" class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-white hover:bg-gray-300 transition duration-500 ease-in-out text-greenJagat text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                    <i class="fa-solid fa-plus"></i>
                </a>
                @else
                    <button type="button"
                        onclick="storeClosedAlert()"
                        class="absolute -top-5 -right-5 w-10 md:w-12 h-10 md:h-12 bg-gray-400 cursor-not-allowed text-white text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                        <i class="fa-solid fa-plus"></i>
                    </button>
                @endif

                <img src="{{ asset('img/home/special-menu-matcha.jpg') }}" class="w-28 h-28 md:w-56 md:h-56 rounded-full border-4 md:border-8 border-greenJagat object-cover -mt-16 md:-mt-24" alt="The Drink">

                <p class="text-sm md:text-2xl text-center mt-5 mb-2">
                    Matcha Latte<br>
                    Rp 30.000
                </p>
            </div>

        </div>

    </div>

    {{-- Divider Right --}}
    <div class="w-full flex justify-end py-10">
        <hr class=" w-2/3">
    </div>

    {{-- Section 4 --}}
    <div class="flex flex-col-reverse md:grid md:grid-cols-2 md:justify-center items-center px-5 md:px-10 h-full pb-20 md:py-0 md:mb-8 md:h-screen">
        <div class="flex flex-col justify-start text-white mt-10 md:mt-0">
            <h1 class="font-calistoga text-xl md:text-5xl mb-3 leading-snug text-[#628A71]">
                Why Us? 
            </h1>
            <h1 class="font-calistoga text-2xl md:text-6xl mb-14 leading-snug">
                Keep Cheer With<br>Amazing Tastes 
            </h1>
            <p class="mb-4 text-base md:text-3xl leading-snug tracking-wider">
                experience the rich and bold flavor of our<br>
                exquisite coffee blends, crafted to awaken your<br>
                senses and start your day right.
            </p>
        </div>
        <div class="flex justify-end items-center">
            <img src="{{ asset('img/home/why-us-image.png') }}" 
                class=" h-64 w-64 md:h-[40rem] md:w-[40rem]" 
                alt="Jabat Kopi">
        </div>
    </div>
    
</div>

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @if(session('message'))
        <script>
            Swal.fire({
                icon: "{{ session('status') === 'success' ? 'success' : (session('status') === 'error' ? 'error' : 'info') }}",
                title: "{{ ucfirst(session('status')) }}",
                html: `
                    @if(session('queue_number'))
                        <p style="font-size: 1.2rem; margin: 5px 0; color: #555;">Your Queue Number</p>
                        <h1 style="font-size: 4rem; margin: 5px 0 15px; color: #2E6342;">
                            {{ session('queue_number') }}
                        </h1>
                    @endif
                    <p>{{ session('message') }}</p>
                `,
                confirmButtonText: 'OK',
                confirmButtonColor: '#2E6342',
            });
        </script>
    @endif
@endpush


@endsection