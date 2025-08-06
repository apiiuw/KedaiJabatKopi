@extends('cashier.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
        {{-- Header --}}
        <div class="flex items-center mb-6">
            <a href="javascript:history.back()" class="flex justify-center">
                <i class="fa-solid fa-chevron-left fa-xl text-greenJagat hover:text-darkGreenJagat transition duration-500 ease-in-out"></i>
            </a>
            <h1 class="font-calistoga text-greenJagat text-3xl ms-3">Manage Menu | Add Menu</h1>
        </div>

        {{-- Form Card --}}
        <div class="bg-white px-6">
            <form action="{{ route('cashier.manage-menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Product Name --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Product Name</label>
                    <input type="text" name="product_name" placeholder="Enter product name" class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                </div>

                {{-- Description --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Description Product</label>
                    <textarea name="description" placeholder="Enter product description"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none"
                        rows="3"></textarea>
                </div>

                {{-- Category --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Category</label>
                    <select name="category" id="category" class="w-full border rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                        <option value="">-- Select Category --</option>
                        <option value="Drink">Drink</option>
                        <option value="Food">Food</option>
                    </select>
                </div>

                {{-- Type --}}
                <div id="type-container" class="hidden">
                    <label class="block font-semibold mb-1 text-greenJagat">Type</label>
                    <select name="type" id="type" class="w-full border rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                        <option value="">-- Select Type --</option>
                    </select>

                    {{-- Custom Type Input --}}
                    <input type="text" id="custom-type" name="custom_type" placeholder="Enter custom type" class="w-full border placeholder:text-gray-400 rounded-md p-2 mt-2 focus:ring-2 focus:ring-greenJagat outline-none hidden">
                </div>

                {{-- Add Ons --}}
                <div id="addons-section">
                    <h1 class="font-semibold block text-greenJagat mb-1">Add Ons</h1>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="iced_hot" id="iced_hot" class="w-5 h-5 text-greenJagat focus:ring-greenJagat border-gray-300 rounded">
                        <label for="iced_hot" class="text-greenJagat font-medium">Iced/Hot Available</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="sweetness" id="sweetness" class="w-5 h-5 text-greenJagat focus:ring-greenJagat border-gray-300 rounded">
                        <label for="sweetness" class="text-greenJagat font-medium">Sweetness Available</label>
                    </div>
                    <div class="flex items-center space-x-3">
                        <input type="checkbox" name="espresso" id="espresso" class="w-5 h-5 text-greenJagat focus:ring-greenJagat border-gray-300 rounded">
                        <label for="espresso" class="text-greenJagat font-medium">Espresso Shot Available</label>
                    </div>
                </div>

                {{-- Availability --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Availability</label>
                    <select name="availability" class="w-full border rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                        <option class="text-gray-400" value="">-- Select Availability --</option>
                        <option value="Available">Available</option>
                        <option value="Not Available">Not Available</option>
                    </select>
                </div>

                {{-- Price --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Price</label>
                    <input type="text" id="price" name="price" placeholder="Enter price" class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                </div>

                {{-- Picture Upload --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Picture</label>
                    <input type="file" name="picture" accept="image/*" class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none" onchange="previewImage(event)">
                    <div class="mt-3">
                        <img id="preview" src="#" alt="Preview" class="hidden w-32 h-32 object-cover rounded-md border">
                    </div>
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat text-white px-6 py-2 rounded-md transition duration-300">
                        Save Menu
                    </button>
                </div>
            </form>
        </div>
   </div>
</div>

@push('scripts')
<script>
    const categorySelect = document.getElementById('category');
    const typeContainer = document.getElementById('type-container');
    const typeSelect = document.getElementById('type');
    const customTypeInput = document.getElementById('custom-type');
    const addonsSection = document.getElementById('addons-section');
    const priceInput = document.getElementById('price');

    const options = {
        Drink: ['Coffee', 'Non-Coffee', 'Tea', 'Other'],
        Food: ['Snack', 'Main Course', 'Dessert', 'Other']
    };

    categorySelect.addEventListener('change', function() {
        const category = this.value;
        typeSelect.innerHTML = '<option value="">-- Select Type --</option>';

        if (options[category]) {
            typeContainer.classList.remove('hidden');
            options[category].forEach(function(opt) {
                const option = document.createElement('option');
                option.value = opt;
                option.textContent = opt;
                typeSelect.appendChild(option);
            });

            // Hide Add Ons if category is Food
            if (category === 'Food') {
                addonsSection.classList.add('hidden');
            } else {
                addonsSection.classList.remove('hidden');
            }
        } else {
            typeContainer.classList.add('hidden');
            addonsSection.classList.remove('hidden');
        }
        customTypeInput.classList.add('hidden');
    });

    typeSelect.addEventListener('change', function() {
        if (this.value === 'Other') {
            customTypeInput.classList.remove('hidden');
        } else {
            customTypeInput.classList.add('hidden');
        }
    });

    function previewImage(event) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(event.target.files[0]);
        preview.classList.remove('hidden');
    }

    priceInput.addEventListener('input', function(e) {
        let value = this.value.replace(/[^,\d]/g, '');
        if (value) {
            let split = value.split(',');
            let sisa = split[0].length % 3;
            let rupiah = split[0].substr(0, sisa);
            let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

            if (ribuan) {
                let separator = sisa ? '.' : '';
                rupiah += separator + ribuan.join('.');
            }

            rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
            this.value = 'Rp ' + rupiah;
        } else {
            this.value = '';
        }
    });

    document.querySelector('form').addEventListener('submit', function() {
        priceInput.value = priceInput.value.replace(/[^0-9]/g, '');
    });
</script>
@endpush

@endsection
