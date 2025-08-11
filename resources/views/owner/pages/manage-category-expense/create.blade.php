@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      {{-- Header --}}
      <div class="flex items-center mb-6">
         <a href="javascript:history.back()" class="flex justify-center">
               <i class="fa-solid fa-chevron-left fa-xl text-greenJagat hover:text-darkGreenJagat transition duration-500 ease-in-out"></i>
         </a>
         <h1 class="font-calistoga text-greenJagat text-3xl ms-3">Manage Category Expense | Add Category</h1>
      </div>

      {{-- Form Card --}}
      <div class="bg-white px-6">
         <form action="{{ route('owner.manage-category-expense.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
               @csrf

               {{-- Category --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Category</label>
                  <select id="category-select" name="category"
                     class="w-full border rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                     <option value="">-- Select Category --</option>
                     <option value="Coffee Beans" {{ old('category') == 'Coffee Beans' ? 'selected' : '' }}>Coffee Beans</option>
                     <option value="Liquid Milk" {{ old('category') == 'Liquid Milk' ? 'selected' : '' }}>Liquid Milk</option>
                     <option value="Other" {{ old('category') == 'Other' ? 'selected' : '' }}>Other</option>
                  </select>
                  @error('category')
                     <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror

                  {{-- Tempat inputan "Other" --}}
                  <div id="other-input-container" class="mt-2"></div>
               </div>

               {{-- Item Name --}}
               <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Item Name</label>
                    <input type="text" name="item_name" value="{{ old('item_name') }}" placeholder="Enter item name"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                  @error('item_name')
                     <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
               </div>

               {{-- Price/Unit --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Price/Unit</label>
                  <input type="text" id="price-input" name="price" value="{{ old('price') }}" 
                     placeholder="Enter price/unit"
                     class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                  @error('price')
                     <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
               </div>

               {{-- Status --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Status</label>
                  <select name="status"
                     class="w-full border rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                     <option value="">-- Select Status --</option>
                     <option value="Active" {{ old('status') == 'Active' ? 'selected' : '' }}>Active</option>
                     <option value="Deactive" {{ old('status') == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                  </select>
                  @error('status')
                     <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
               </div>

               {{-- Submit Button --}}
               <div class="pt-4">
                  <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat text-white px-6 py-2 rounded-md transition duration-300">
                     Save Category
                  </button>
               </div>

         </form>
      </div>

   </div>
</div>

@push('scripts')
    <script>
      document.addEventListener("DOMContentLoaded", function () {
         const categorySelect = document.getElementById("category-select");
         const otherContainer = document.getElementById("other-input-container");

         function toggleOtherInput() {
               if (categorySelect.value === "Other") {
                  otherContainer.innerHTML = `
                     <input type="text" name="other_category" value="{{ old('other_category') }}" 
                           placeholder="Enter other category" 
                           class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                  `;
               } else {
                  otherContainer.innerHTML = "";
               }
         }

         categorySelect.addEventListener("change", toggleOtherInput);

         // jalankan sekali pas halaman load, biar kalau old value "Other" tetap muncul
         toggleOtherInput();
      });
   </script>

   <script>
   document.addEventListener("DOMContentLoaded", function () {
      const priceInput = document.getElementById('price-input');

      priceInput.addEventListener('input', function (e) {
         let value = e.target.value.replace(/[^,\d]/g, '');
         let numberString = value.toString();
         let split = numberString.split(',');
         let sisa = split[0].length % 3;
         let rupiah = split[0].substr(0, sisa);
         let ribuan = split[0].substr(sisa).match(/\d{3}/gi);

         if (ribuan) {
               let separator = sisa ? '.' : '';
               rupiah += separator + ribuan.join('.');
         }

         rupiah = split[1] !== undefined ? rupiah + ',' + split[1] : rupiah;
         e.target.value = rupiah ? 'Rp ' + rupiah : '';
      });

      // Hilangkan format saat submit agar yang dikirim hanya angka
      priceInput.form.addEventListener('submit', function () {
         priceInput.value = priceInput.value.replace(/[^0-9]/g, '');
      });
   });
   </script>

@endpush

@endsection