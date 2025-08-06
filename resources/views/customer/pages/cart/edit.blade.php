@extends('customer.layouts.main')
@section('container')

<form action="{{ route('customer.cart.updateForm', $cart->id) }}" method="POST">
    @csrf
    @method('PUT')
    <input type="hidden" name="id_menu" value="{{ $menu->id_menu }}">

@php
    use Illuminate\Support\Str;

    $descFull = $cart->description ?? '';
    $descParts = collect(explode(',', $descFull))->map(fn($item) => trim($item))->values();

    // Hanya cocokkan persis
    $sugar     = $descParts->contains('Normal Sugar') ? 'Normal Sugar' :
                 ($descParts->contains('Less Sugar') ? 'Less Sugar' : '');

    $espresso  = $descParts->contains('Single Shot') ? 'Single Shot' :
                 ($descParts->contains('Double Shot') ? 'Double Shot' : '');

    $icedHot   = $descParts->contains('Iced') ? 'Iced' :
                 ($descParts->contains('Hot') ? 'Hot' : '');

    // Ambil note: asumsi bagian terakhir (tidak termasuk keywords di atas)
    $noteKeywords = ['Iced', 'Hot', 'Normal Sugar', 'Less Sugar', 'Single Shot', 'Double Shot'];
    $note = $descParts->reject(fn($item) => in_array($item, $noteKeywords))->implode(', ');
@endphp

    <div class="flex flex-col h-full pt-28 pb-10 px-10 md:px-16">
        <div class="flex flex-col md:flex-row items-center md:items-start">
            <img src="{{ asset($menu->picture) }}" class="rounded-md w-full md:h-64 md:w-64 object-cover" alt="{{ $menu->product_name }}">

            <div class="flex flex-col justify-start text-white md:ml-10 w-full md:h-64 md:w-[32rem] mt-5 md:mt-0">
                <h1 class="font-calistoga text-2xl md:text-4xl">{{ $menu->product_name }}</h1>
                <p class="text-lg md:text-2xl mt-1 md:mt-3">{{ $menu->description ?? '' }}</p>


                @if($menu->iced_hot == 1)
                    <div class="flex flex-row mt-4 md:mt-12 gap-x-3 md:gap-x-7">
                        <label class="flex flex-col items-center cursor-pointer">
                            <input type="radio" name="iced_hot" value="iced" class="hidden peer" {{ $icedHot == 'Iced' ? 'checked' : '' }}>
                            <div class="bg-greenJagat py-2 px-12 text-[#C4C2C2] border border-[#C4C2C2] rounded-md peer-checked:bg-white peer-checked:text-greenJagat">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-10" viewBox="0 -960 960 960" fill="currentColor">
                                    <path d="M444-600q-55 0-108 15.5T238-538l42 378h400l44-400h-28q-38 0-69-5.5T542-587q-23-7-48-10t-50-3Zm-216-25q51-27 105.5-41T445-680q30 0 59.5 4t58.5 12q50 14 76.5 19t56.5 5h37l17-160H210l18 175Zm51 545q-31 0-53.5-20T200-151l-80-729h720l-80 729q-3 31-25.5 51T681-80H279Zm165-80h236-400 164Z"/>
                                </svg>
                                <p class="text-base md:text-lg">iced</p>
                            </div>
                        </label>

                        <label class="flex flex-col items-center cursor-pointer">
                            <input type="radio" name="iced_hot" value="hot" class="hidden peer" {{ $icedHot == 'Hot' ? 'checked' : '' }}>
                            <div class="bg-greenJagat py-2 px-12 text-[#C4C2C2] border border-[#C4C2C2] rounded-md peer-checked:bg-white peer-checked:text-greenJagat">
                                <i class="fa-solid fa-mug-hot fa-2xl h-10 flex items-center"></i>
                                <p class="text-base md:text-lg">hot</p>
                            </div>
                        </label>
                    </div>
                @endif
            </div>
        </div>


        @if($cart->menu->sweetness == 1)
            <div class="flex flex-col w-full md:w-2/5 mt-8 text-white">
                <div class="grid grid-cols-2 items-center">
                    <h1 class="font-calistoga text-2xl md:text-3xl">Sweetness</h1>
                    <p class="text-lg md:text-xl text-center">Must Choose 1</p>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Normal Sweet</p>
                    <div class="flex justify-center">
                        <input type="radio" name="sweetness" value="Normal Sugar" class="bg-white/30 border border-white h-4 w-4 cursor-pointer" {{ $sugar == 'Normal Sugar' ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Less Sweet</p>
                    <div class="flex justify-center">
                        <input type="radio" name="sweetness" value="Less Sugar" class="bg-white/30 border border-white h-4 w-4 cursor-pointer" {{ $sugar == 'Less Sugar' ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
         @endif

        @if($cart->menu->espresso == 1)
            <div class="flex flex-col w-full md:w-2/5 mt-5 text-white">
                <div class="grid grid-cols-2 items-center">
                    <h1 class="font-calistoga text-2xl md:text-3xl">Espresso</h1>
                    <p class="text-lg md:text-xl text-center">Must Choose 1</p>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Single Shot</p>
                    <div class="flex justify-center">
                        <input type="radio" name="espresso" value="Single Shot" class="bg-white/30 border border-white h-4 w-4 cursor-pointer" {{ $espresso == 'Single Shot' ? 'checked' : '' }}>
                    </div>
                </div>
                <div class="grid grid-cols-2 items-center mt-1">
                    <p class="text-lg md:text-xl">Double Shot</p>
                    <div class="flex justify-center">
                        <input type="radio" name="espresso" value="Double Shot" class="bg-white/30 border border-white h-4 w-4 cursor-pointer" {{ $espresso == 'Double Shot' ? 'checked' : '' }}>
                    </div>
                </div>
            </div>
        @endif

        <div class="flex flex-col w-full md:w-1/2 mt-5">
            <label class="block mb-1 text-white font-calistoga text-2xl md:text-3xl">Another Request</label>
            <textarea name="notes" placeholder="Enter another request"
                class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none"
                rows="3">{{ $note }}</textarea>
        </div>

        <div class="flex flex-col md:flex-row justify-center md:justify-end gap-x-10 mt-5 md:mt-0">
            <h1 class="text-white text-lg md:text-2xl mt-1 md:mt-3">Rp {{ number_format($menu->price, 0, ',', '.') }}</h1>
            <div class="flex items-center">
                <button type="button" class="btn-minus flex justify-center items-center rounded-full p-2 text-[#C4C2C2] border border-[#C4C2C2]">
                    <i class="fa-solid fa-minus"></i>
                </button>

                <input type="number" name="quantity" id="qty" class="no-spinner bg-transparent px-2 w-8 border-none text-white text-lg text-center" value="{{ $cart->quantity }}" min="1">
                
                <button type="button" class="btn-plus flex justify-center items-center rounded-full p-2 text-greenJagat bg-white hover:bg-gray-300 transition duration-300 ease-in-out">
                    <i class="fa-solid fa-plus"></i>
                </button>
            </div>
            <button type="submit" class="bg-white hover:bg-gray-300 py-2 px-8 rounded-3xl text-greenJagat transition duration-300">Update Cart</button>
        </div>
    </div>
</form>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const qtyInput = document.getElementById('qty');
        document.querySelector('.btn-plus').addEventListener('click', () => qtyInput.value++);
        document.querySelector('.btn-minus').addEventListener('click', () => {
            if (parseInt(qtyInput.value) > 1) qtyInput.value--;
        });
    });
</script>
@endpush

@endsection
