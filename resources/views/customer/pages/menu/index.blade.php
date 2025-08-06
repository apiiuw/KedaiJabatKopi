@extends('customer.layouts.main')
@section('container')

<div class="h-full flex flex-col items-center pt-28 md:pt-36 px-8">
    <div class="relative w-full md:w-1/4">
        <input type="text" id="search-navbar"
            class="block w-full h-auto md:h-9 px-2 ps-3 text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50 md:bg-white/5 md:text-white placeholder:text-white/70"
            placeholder="Search...">
        <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
            <svg class="w-4 h-4 text-gray-500 md:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                fill="none" viewBox="0 0 20 20">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
            </svg>
        </div>
    </div>
    <div class="flex flex-row items-center gap-x-16 mt-0 md:mt-0 text-[#C4C2C2]">
        <a href="#" class="flex flex-col justify-end h-28 md:hover:text-white items-center transition duration-300 ease-in-out">
            <i class="fa-solid fa-mug-hot fa-2xl"></i>
            <p class="text-lg md:text-2xl mt-5">The Drink</p>
        </a>
        <a href="#" class="flex flex-col justify-end h-28 md:hover:text-white items-center transition duration-300 ease-in-out">
            <i class="fa-solid fa-utensils fa-2xl"></i>
            <p class="text-lg md:text-2xl mt-5">The Food</p>
        </a>
        <a href="#" class="flex flex-col justify-end h-28 md:hover:text-white items-center transition duration-300 ease-in-out">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[38px]" viewBox="0 -960 960 960" fill="currentColor">
                <path d="M533-440q-32-45-84.5-62.5T340-520q-56 0-108.5 17.5T147-440h386ZM40-360q0-109 91-174.5T340-600q118 0 209 65.5T640-360H40Zm0 160v-80h600v80H40ZM720-40v-80h56l56-560H450l-10-80h200v-160h80v160h200L854-98q-3 25-22 41.5T788-40h-68Zm0-80h56-56ZM80-40q-17 0-28.5-11.5T40-80v-40h600v40q0 17-11.5 28.5T600-40H80Zm260-400Z"/>
            </svg>                 
            <p class="text-lg md:text-2xl mt-1">All Menus</p>
        </a>
    </div>

    <div class="w-full flex justify-start items-start px-32 pt-16">
        <h1 class="font-calistoga text-white text-3xl underline">Non-Coffee</h1>
    </div>
    <div class="grid grid-cols-2 md:grid-cols-3 gap-x-10 md:gap-x-40 gap-y-20 justify-center pt-20 md:pt-20 pb-28">
        @foreach($menus as $menu)
            <div class="relative max-w-sm md:w-64 flex flex-col justify-center p-2 md:p-2 bg-[#D9E3DD] border border-gray-200 rounded-b-lg shadow-sm rounded-lg">
                
                <div class="flex justify-center items-center">
                    <img src="{{ asset($menu->picture) }}" 
                        class="absolute w-28 h-28 md:w-36 md:h-36 rounded-full border-4 md:border-4 border-greenJagat object-cover -mt-16 top-4 -left-8" 
                        alt="{{ $menu->product_name }}">
                    <h1 class="font-semibold pl-20 md:pl-28 text-sm md:text-2xl">
                        {{ $menu->product_name }}
                    </h1>
                </div>

                <p class="mt-8 text-sm md:text-2xl text-center leading-relaxed">
                    {{ $menu->description ?? 'No description available' }}
                </p>

                <div class="flex justify-between items-center mb-4 mt-5 px-2">
                    <p class="text-sm md:text-2xl text-center">
                        Rp {{ number_format($menu->price, 0, ',', '.') }}
                    </p>
                    <a href="#" 
                    class="w-10 md:w-10 h-10 md:h-10 bg-greenJagat hover:bg-darkGreenJagat transition duration-500 ease-in-out text-white text-lg md:text-xl rounded-full flex justify-center items-center shadow-md">
                        <svg xmlns="http://www.w3.org/2000/svg" height="25px" viewBox="0 -960 960 960" width="25px" fill="currentColor">
                            <path d="M360-640v-80h240v80H360ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/>
                        </svg>
                    </a>
                </div>
            </div>
        @endforeach
    </div>

</div>

@endsection