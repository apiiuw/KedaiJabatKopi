@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      {{-- Header --}}
      <div class="flex items-center mb-6">
         <a href="javascript:history.back()" class="flex justify-center">
               <i class="fa-solid fa-chevron-left fa-xl text-greenJagat hover:text-darkGreenJagat transition duration-500 ease-in-out"></i>
         </a>
         <h1 class="font-calistoga text-greenJagat text-3xl ms-3">Daily's Expense | Add Expense</h1>
      </div>

      {{-- Form Card --}}
      <div class="bg-white px-6">
         <form action="{{ route('owner.dailys-expense.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf

                {{-- Category --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Category</label>
                    <select id="category-select" name="category" class="w-full border rounded-md p-2">
                        <option value="">-- Select Category --</option>
                        @foreach($categories as $category)
                            <option value="{{ $category->category }}">{{ $category->category }}</option>
                        @endforeach
                    </select>
                </div>

                {{-- Item --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Item</label>
                    <select id="item-select" name="item" class="w-full border rounded-md p-2">
                        <option value="">-- Select Item --</option>
                    </select>
                </div>

                {{-- Price/Unit --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Price/Unit</label>
                    <input type="text" id="price-input" name="price" value="{{ old('price') }}" 
                        placeholder="Select category and item first" readonly
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 bg-gray-100">
                    @error('price')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Quantity --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Quantity</label>
                    <input type="number" id="qty-input" name="qty" value="{{ old('qty') }}" 
                        placeholder="Enter quantity"
                        min="1"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                    @error('qty')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

               {{-- Description --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Description</label>
                  <textarea type="text" id="description-input" name="description" value="{{ old('description') }}" 
                     placeholder="Enter description"
                     class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none"></textarea>
                  @error('description')
                     <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
               </div>

                {{-- Amount --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Amount</label>
                    <input type="text" id="amount-input" value="{{ old('amount') }}" 
                        readonly
                        class="w-full border placeholder:text-gray-400 bg-gray-100 rounded-md p-2">
                    {{-- hidden input untuk dikirim ke server --}}
                    <input type="text" class="hidden" id="raw-amount-input" name="amount" value="{{ old('amount') }}">
                </div>

               {{-- Submit Button --}}
               <div class="pt-4">
                  <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat text-white px-6 py-2 rounded-md transition duration-300">
                     Save Expense
                  </button>
               </div>

         </form>
      </div>
      
   </div>
</div>

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const categorySelect = document.getElementById('category-select');
        const itemSelect = document.getElementById('item-select');
        const priceInput = document.getElementById('price-input');
        const qtyInput = document.getElementById("qty-input");
        const amountInput = document.getElementById("amount-input");
        const rawAmountInput = document.getElementById("raw-amount-input");

        function formatRupiah(angka) {
            return 'Rp ' + angka.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }

        function updateAmount() {
            let qty = parseFloat(qtyInput.value) || 0;
            let rawPrice = parseFloat(priceInput.getAttribute('data-raw-price')) || 0;
            let total = qty * rawPrice;
            rawAmountInput.value = total; // angka murni untuk server
            amountInput.value = formatRupiah(total); // format untuk tampilan
        }

        // Load items when category changes
        categorySelect.addEventListener('change', function () {
            const category = categorySelect.value;
            itemSelect.innerHTML = '<option value="">-- Select Item --</option>';

            if (category) {
                fetch(`/owner/dailys-expense/get-items?category=${category}`)
                    .then(res => res.json())
                    .then(items => {
                        items.forEach(item => {
                            let option = document.createElement('option');
                            option.value = item;
                            option.textContent = item;
                            itemSelect.appendChild(option);
                        });
                    });
            }

            priceInput.value = '';
            priceInput.removeAttribute('data-raw-price');
            amountInput.value = '';
            rawAmountInput.value = '';
        });

        // Load price when item changes
        itemSelect.addEventListener('change', function () {
            const category = categorySelect.value;
            const item = itemSelect.value;

            if (category && item) {
                fetch(`/owner/dailys-expense/get-price?category=${category}&item=${item}`)
                    .then(res => res.json())
                    .then(data => {
                        priceInput.value = data.price_formatted;
                        priceInput.setAttribute('data-raw-price', data.price);
                        updateAmount();
                    });
            }
        });

        qtyInput.addEventListener("input", updateAmount);

        // Saat submit, ubah price jadi angka mentah
        document.querySelector('form').addEventListener('submit', function () {
            const rawPrice = priceInput.getAttribute('data-raw-price');
            if (rawPrice) priceInput.value = rawPrice;
        });
    });
</script>
@endpush


@endsection