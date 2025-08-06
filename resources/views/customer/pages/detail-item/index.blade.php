@extends('customer.layouts.main')
@section('container')

<form action="{{ route('customer.detail-item.add-cart', $menu->id_menu) }}" method="POST">
    @csrf
    <input type="hidden" name="id_menu" value="{{ $menu->id_menu }}">

    <div class="flex flex-col h-full pt-28 pb-10 px-10 md:px-16">
        <div class="flex flex-col md:flex-row items-center md:items-start">
            {{-- Gambar Menu --}}
            <img src="{{ asset($menu->picture) }}" 
                 class="rounded-md w-full md:h-64 md:w-64 object-cover" 
                 alt="{{ $menu->product_name }}">

            <div class="flex flex-col justify-start text-white md:ml-10 w-full md:h-64 md:w-[32rem] mt-5 md:mt-0">
                <h1 class="font-calistoga text-2xl md:text-4xl">{{ $menu->product_name }}</h1>

                <p class="text-lg md:text-2xl mt-1 md:mt-3">
                    {{ $menu->description ?? '' }}
                </p>

                {{-- Iced & Hot --}}
                @if($menu->iced_hot == 1)
                    <div class="flex flex-row justify-start items-start mt-4 md:mt-12 gap-x-3 md:gap-x-7">
                        <label class="flex flex-col justify-center items-center cursor-pointer">
                            <input type="radio" name="iced_hot" value="iced" class="hidden peer">
                            <div class="bg-greenJagat py-2 px-12 text-[#C4C2C2] border border-[#C4C2C2] rounded-md transition duration-300 ease-in-out peer-checked:bg-white peer-checked:text-greenJagat">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10" viewBox="0 -960 960 960" fill="currentColor">
                                    <path d="M444-600q-55 0-108 15.5T238-538l42 378h400l44-400h-28q-38 0-69-5.5T542-587q-23-7-48-10t-50-3Zm-216-25q51-27 105.5-41T445-680q30 0 59.5 4t58.5 12q50 14 76.5 19t56.5 5h37l17-160H210l18 175Zm51 545q-31 0-53.5-20T200-151l-80-729h720l-80 729q-3 31-25.5 51T681-80H279Zm165-80h236-400 164Z"/>
                                </svg>
                                <p class="text-base md:text-lg">iced</p>
                            </div>
                        </label>

                        <label class="flex flex-col justify-center items-center cursor-pointer">
                            <input type="radio" name="iced_hot" value="hot" class="hidden peer">
                            <div class="bg-greenJagat py-2 px-12 text-[#C4C2C2] border border-[#C4C2C2] rounded-md transition duration-300 ease-in-out peer-checked:bg-white peer-checked:text-greenJagat">
                                <div class="h-10 flex justify-center items-center">
                                    <i class="fa-solid fa-mug-hot fa-2xl"></i>
                                </div>
                                <p class="text-base md:text-lg">hot</p>
                            </div>
                        </label>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sweetness --}}
        @if($menu->sweetness == 1)
            <div class="flex flex-col w-full md:w-2/5 mt-8 text-white">
                <div class="grid grid-cols-2 items-center">
                    <h1 class="font-calistoga text-2xl md:text-3xl">Sweetness</h1>
                    <p class="text-lg md:text-xl text-center">Must Choose 1</p>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Normal Sweet</p>
                    <div class="flex justify-center">
                        <input type="radio" name="sweetness" value="normal" class="bg-white/30 border border-white h-4 w-4 cursor-pointer">
                    </div>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Less Sweet</p>
                    <div class="flex justify-center">
                        <input type="radio" name="sweetness" value="less" class="bg-white/30 border border-white h-4 w-4 cursor-pointer">
                    </div>
                </div>
            </div>
        @endif

        {{-- Espresso --}}
        @if($menu->espresso == 1)
            <div class="flex flex-col w-full md:w-2/5 mt-5 text-white">
                <div class="grid grid-cols-2 items-center">
                    <h1 class="font-calistoga text-2xl md:text-3xl">Espresso</h1>
                    <p class="text-lg md:text-xl text-center">Must Choose 1</p>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Single Shot</p>
                    <div class="flex justify-center">
                        <input type="radio" name="espresso" value="single" class="bg-white/30 border border-white h-4 w-4 cursor-pointer">
                    </div>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Double Shot</p>
                    <div class="flex justify-center">
                        <input type="radio" name="espresso" value="double" class="bg-white/30 border border-white h-4 w-4 cursor-pointer">
                    </div>
                </div>
            </div>
        @endif

        {{-- Another Request --}}
        <div class="flex flex-col w-full md:w-1/2 mt-5">
            <label class="block mb-1 text-white font-calistoga text-2xl md:text-3xl">Another Request</label>
            <textarea name="notes" placeholder="Enter another request"
                class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none"
                rows="3"></textarea>
        </div>

        {{-- Quantity & Add to Cart --}}
        <div class="flex flex-col md:flex-row justify-center md:justify-end gap-x-10 mt-5 md:mt-0">
                <h1 class="text-white text-lg md:text-2xl mt-1 md:mt-3">
                    Rp {{ number_format($menu->price, 0, ',', '.') }}
                </h1>
            <div class="flex flex-row justify-center items-center mb-3 md:mb-0">
                <button type="button" 
                    class="btn-minus flex justify-center items-center rounded-full p-2 text-[#C4C2C2] border border-[#C4C2C2]">
                    <i class="fa-solid fa-minus"></i>
                </button>

                <input type="number" name="quantity" id="qty" 
                    class="no-spinner bg-transparent px-2 w-8 border-none text-white text-lg text-center" 
                    value="1" min="1">

                <button type="button" 
                    class="btn-plus flex justify-center items-center rounded-full p-2 text-greenJagat bg-white hover:bg-gray-300 transition duration-300 ease-in-out">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>

            <button type="submit" class="bg-white hover:bg-gray-300 py-2 px-8 rounded-3xl text-greenJagat flex justify-center items-center transition duration-300 ease-in-out">
                Add to Cart
            </button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyInput = document.getElementById('qty');
        const btnPlus = document.querySelector('.btn-plus');
        const btnMinus = document.querySelector('.btn-minus');

        btnPlus.addEventListener('click', function () {
            qtyInput.value = parseInt(qtyInput.value) + 1;
        });

        btnMinus.addEventListener('click', function () {
            let currentVal = parseInt(qtyInput.value);
            if (currentVal > 1) {
                qtyInput.value = currentVal - 1;
            }
        });
    });
</script>
@endpush

@endsection
