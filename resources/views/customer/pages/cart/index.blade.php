@extends('customer.layouts.main')
@section('container')

<div class="min-h-screen flex justify-center items-center" x-data="{ showModal: false, selectedQty: 1, selectedItem: null, selectedId: null }">
    <div class="bg-darkGreenJagat flex flex-col md:flex-row md:gap-x-20 justify-center items-center min-h-screen h-full pt-24 px-6 py-10 w-full max-w-md md:max-w-full md:w-full shadow-md p-6 text-sm clip-path-[polygon(0_0,100%_0,100%_96%,96%_100%,0_100%)] overflow-hidden">

    <!-- Invoice -->
    <div class="relative bg-white w-full max-w-md md:max-w-2xl shadow-md p-6 border border-gray-300 font-mono text-sm clip-path-[polygon(0_0,100%_0,100%_96%,96%_100%,0_100%)] rounded-md overflow-hidden">
        <h2 class="text-center text-xl font-bold mb-4">Your Cart</h2>

        <!-- Scrollable Container -->
        <div class="overflow-x-auto w-full">

            <div class="min-w-[600px] border-t border-dashed mb-2"></div>

            <!-- Header -->
            <div class="min-w-[600px] w-full grid grid-cols-[2fr_1fr_0.7fr_1fr_1fr_0.5fr] font-bold mb-2">
                <span>Item</span>
                <span class="text-right">Price</span>
                <span class="text-center">Qty</span>
                <span class="text-right">Total</span>
                <span></span>
                <span></span>
            </div>

            <div class="min-w-[600px] border-t border-dashed mb-2"></div>

            @forelse($carts as $cart)
                <div class="min-w-[600px] w-full grid grid-cols-[2fr_1fr_0.7fr_1fr_1fr_0.5fr] items-center">
                    <span>{{ $cart->menu->product_name }}</span>
                    <span class="text-right">Rp {{ number_format($cart->menu->price, 0, ',', '.') }}</span>
                    <span class="text-center">
                        <button
                            class="text-greenJagat hover:underline"
                            @click="
                                selectedQty = {{ $cart->quantity }};
                                selectedItem = '{{ $cart->menu->product_name }}';
                                selectedId = {{ $cart->id }};
                                showModal = true;
                            "
                        >
                            {{ $cart->quantity }}
                        </button>
                    </span>
                    <span class="text-right">Rp {{ number_format($cart->price, 0, ',', '.') }}</span>
                    <span class="text-right">
                        <a href="{{ route('customer.cart.edit', $cart->id) }}" class="text-greenJagat hover:underline">
                            Edit
                        </a>
                    </span>
                    <span class="text-right">
                        <form action="{{ route('customer.cart.delete', $cart->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                    </span>
                </div>
                @if($cart->description)
                    <div class="min-w-[600px] text-gray-500 italic text-xs mb-2 ml-1">
                        {{ $cart->description }}
                    </div>
                @endif
            @empty
                <div class="text-center text-gray-500 mt-6">
                    Let's add something delicious! 🍽️
                </div>
            @endforelse

        </div>

        <div class="border-t border-dashed my-4"></div>

        <!-- Total -->
        <div class="flex justify-between font-bold text-base">
            <span>Amount</span>
            <span>Rp {{ number_format($totalPrice, 0, ',', '.') }}</span>
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

            <button
                type="button"
                id="pay-button"
                class="w-full mt-2 bg-greenJagat hover:bg-darkGreenJagat text-white font-semibold py-2 px-4 rounded transition duration-200"
                onclick="openConfirmModal()"
            >
                Checkout Now!
            </button>

        </div>

    </div>

    <!-- Modal Quantity -->
    <div x-show="showModal" class="fixed inset-0 bg-black bg-opacity-30 flex justify-center items-center z-50"
        x-cloak>
        <div class="bg-white p-6 rounded shadow-lg w-80 text-center font-mono">
            <h3 class="text-lg font-bold mb-4">Edit Quantity</h3>
            <p class="mb-2 text-sm text-gray-700" x-text="'Item: ' + selectedItem"></p>

            <form method="POST" :action="'/cart/update-qty/' + selectedId">
                @csrf
                @method('PUT')
                <input type="number" name="quantity" x-model="selectedQty" min="1"
                    class="no-spinner appearance-none w-20 border border-gray-300 rounded text-center text-lg mb-4">

                <div class="flex justify-center gap-4">
                    <button type="submit"
                            class="bg-green-600 text-white px-4 py-1 rounded hover:bg-green-700">
                        Save
                    </button>
                    <button type="button"
                            class="bg-gray-300 px-4 py-1 rounded hover:bg-gray-400"
                            @click="showModal = false">
                        Cancel
                    </button>
                </div>
            </form>

        </div>
    </div>

    <!-- Confirm Checkout Modal -->
    <div id="confirmModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 flex items-center justify-center">
        <div class="bg-white rounded-lg shadow-lg w-full max-w-md p-6">
            <h2 class="text-lg font-semibold text-gray-800 mb-4">Confirm Your Order</h2>
            <p class="text-gray-600 mb-6">Are you sure you want to proceed with this order?</p>
            <div class="flex justify-end space-x-4">
                <button
                    onclick="closeConfirmModal()"
                    class="bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold py-2 px-4 rounded"
                >
                    Cancel
                </button>
                <button
                    onclick="submitCheckout()"
                    class="bg-greenJagat hover:bg-darkGreenJagat text-white font-semibold py-2 px-4 rounded"
                >
                    Yes, Proceed
                </button>
            </div>
        </div>
    </div>


</div>

@push('scripts')
    @if(session('success'))
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: 'success',
                title: '{{ session('success') }}',
            });
        });
    </script>
    @endif

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
            data-client-key="{{ config('services.midtrans.client_key') }}"></script>

    <script>
        // Show confirmation modal when user clicks "Checkout Now"
        document.getElementById('pay-button').addEventListener('click', function () {
            openConfirmModal();
        });

        function openConfirmModal() {
            document.getElementById('confirmModal').classList.remove('hidden');
        }

        function closeConfirmModal() {
            document.getElementById('confirmModal').classList.add('hidden');
        }

        function submitCheckout() {
            closeConfirmModal();

            const name = document.getElementById('name').value;
            const email = document.getElementById('email').value;
            const table = document.getElementById('table').value;

            fetch('{{ route('customer.checkout') }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ name, email, table_number: table })
            })
            .then(response => response.json())
            .then(data => {
                window.snap.pay(data.snap_token, {
                    onSuccess: function(result) {
                        console.log("Success:", result);
                        window.location.href = "/payment/success";
                    },
                    onPending: function(result) {
                        console.log("Pending:", result);
                    },
                    onError: function(result) {
                        console.log("Error:", result);
                    },
                    onClose: function() {
                        console.log("User closed the popup");
                    }
                });
            });
        }
    </script>
@endpush

@endsection
