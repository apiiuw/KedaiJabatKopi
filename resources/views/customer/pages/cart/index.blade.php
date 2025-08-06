@extends('customer.layouts.main')
@section('container')

<div class="min-h-screen flex justify-center items-center" x-data="{ showModal: false, selectedQty: 1, selectedItem: null }">
    <div class="bg-darkGreenJagat flex flex-col justify-center items-center min-h-screen h-full pt-24 px-6 py-10 w-full max-w-md md:w-[380px] shadow-md p-6 text-sm clip-path-[polygon(0_0,100%_0,100%_96%,96%_100%,0_100%)] overflow-hidden">

        <!-- Invoice -->
        <div class="relative bg-white w-full max-w-md shadow-md p-6 border border-gray-300 font-mono text-sm clip-path-[polygon(0_0,100%_0,100%_96%,96%_100%,0_100%)] rounded-md overflow-hidden">
            <h2 class="text-center text-xl font-bold mb-4">Your Cart</h2>
            
            <div class="border-t border-dashed mb-2"></div>

            <!-- Header -->
            <div class="grid grid-cols-[2fr_1fr_0.7fr_1fr_0.5fr] font-bold mb-2">
                <span>Item</span>
                <span class="text-right">Price</span>
                <span class="text-center">Qty</span>
                <span class="text-right">Total</span>
                <span></span>
            </div>

            <div class="border-t border-dashed mb-2"></div>

            <!-- Item 1 -->
            <div class="grid grid-cols-[2fr_1fr_0.7fr_1fr_0.5fr] items-center">
                <span>Kopi Latte</span>
                <span class="text-right">35.000</span>
                <span class="text-center">
                    <button class="text-greenJagat hover:underline" @click="selectedQty = 1; selectedItem = 'Kopi Latte'; showModal = true">1</button>
                </span>
                <span class="text-right">35.000</span>
                <span class="text-right">
                    <button class="text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                    </button>
                </span>
            </div>
            <div class="text-gray-500 italic text-xs mb-2 ml-1">Ice, Less Sugar, 1shot</div>

            <!-- Item 2 -->
            <div class="grid grid-cols-[2fr_1fr_0.7fr_1fr_0.5fr] items-center">
                <span>Kopi Hitam</span>
                <span class="text-right">25.000</span>
                <span class="text-center">
                    <button class="text-greenJagat hover:underline" @click="selectedQty = 2; selectedItem = 'Kopi Hitam'; showModal = true">2</button>
                </span>
                <span class="text-right">50.000</span>
                <span class="text-right">
                    <button class="text-red-500 hover:text-red-700">
                    <i class="fas fa-trash"></i>
                    </button>
                </span>
            </div>
            <div class="text-gray-500 italic text-xs mb-2 ml-1">Hot, Normal Sugar</div>

            <div class="border-t border-dashed my-4"></div>

            <!-- Total -->
            <div class="flex justify-between font-bold text-base">
            <span>Amount</span>
            <span>Rp 85.000</span>
            </div>

            <p class="text-xs text-center mt-6">Hit checkout and sip happiness ☕</p>

            <!-- Sobekan pojok kanan bawah -->
            <div class="absolute bottom-0 right-0 w-10 h-10 bg-gray-100 rotate-45 shadow-inner"
                style="clip-path: polygon(100% 0, 0 0, 0 100%);"></div>

            <!-- Sobekan pojok kiri atas -->
            <div class="absolute top-0 left-0 w-8 h-8 bg-gray-100 -rotate-45 shadow-inner"
                style="clip-path: polygon(0 100%, 100% 100%, 100% 0);"></div>
        </div>

        <!-- Form Input Name, Email, Table -->
        <div class="mt-6 w-full max-w-md bg-white shadow-md p-6 rounded-md border border-gray-300 space-y-4">
            <h1 class="text-lg text-center text-greenJagat font-calistoga">Tell Me Your Contact!</h1>
            <div>
                <label for="name" class="block text-gray-700 text-sm mb-1">Name</label>
                <input type="text" id="name" name="name" placeholder="Your name"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-greenJagat">
            </div>

            <div>
                <label for="email" class="block text-gray-700 text-sm mb-1">Email</label>
                <input type="email" id="email" name="email" placeholder="you@example.com"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-greenJagat">
            </div>

            <div>
                <label for="table" class="block text-gray-700 text-sm mb-1">Table Number</label>
                <input type="number" id="table" name="table_number" placeholder="e.g. 7"
                    class="w-full border border-gray-300 rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-greenJagat">
            </div>

            <button class="w-full mt-2 bg-greenJagat hover:bg-darkGreenJagat text-white font-semibold py-2 px-4 rounded transition duration-200">
                Checkout Now!
            </button>
        </div>

    </div>

    <!-- Modal Quantity -->
    {{-- <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50">
        <div class="bg-white p-6 rounded shadow-lg w-80 text-center font-mono">
        <h3 class="text-lg font-bold mb-4">Edit Quantity</h3>
        <p class="mb-2 text-sm text-gray-700" x-text="'Item: ' + selectedItem"></p>
        <input type="number" x-model="selectedQty" min="1"
                class="no-spinner appearance-none w-20 border border-gray-300 rounded text-center text-lg mb-4">

        <div class="flex justify-center gap-4">
            <button class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700"
                    @click="showModal = false">
            Save
            </button>
            <button class="bg-gray-300 px-4 py-1 rounded hover:bg-gray-400"
                    @click="showModal = false">
            Cancel
            </button>
        </div>
        </div>
    </div> --}}
</div>

@endsection
