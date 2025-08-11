@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      {{-- Header --}}
      <div class="flex items-center mb-6">
         <a href="javascript:history.back()" class="flex justify-center">
               <i class="fa-solid fa-chevron-left fa-xl text-greenJagat hover:text-darkGreenJagat transition duration-500 ease-in-out"></i>
         </a>
         <h1 class="font-calistoga text-greenJagat text-3xl ms-3">Manage Category Expense | Edit Category #{{ $category->id_category_expense }}</h1>
      </div>

      {{-- Form Card --}}
      <div class="bg-white px-6">
         {{-- Form Edit --}}
         <form action="{{ route('owner.manage-category-expense.update', $category->id) }}" 
               method="POST" 
               class="space-y-5">
               @csrf
               @method('PUT')

               {{-- Category --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Category</label>
                  <select id="category-select" name="category" disabled
                     class="w-full border rounded-md p-2 bg-gray-100">
                     <option value="">-- Select Category --</option>
                     <option value="Coffee Beans" {{ old('category', $category->category) == 'Coffee Beans' ? 'selected' : '' }}>Coffee Beans</option>
                     <option value="Liquid Milk" {{ old('category', $category->category) == 'Liquid Milk' ? 'selected' : '' }}>Liquid Milk</option>
                     <option value="Other" {{ !in_array($category->category, ['Coffee Beans','Liquid Milk']) ? 'selected' : '' }}>Other</option>
                  </select>
                  <div id="other-input-container" class="{{ !in_array($category->category, ['Coffee Beans','Liquid Milk']) ? '' : 'hidden' }} mt-2">
                     <input type="text" name="other_category" readonly
                           value="{{ !in_array($category->category, ['Coffee Beans','Liquid Milk']) ? $category->category : '' }}" 
                           placeholder="Enter other category"
                           class="w-full border rounded-md p-2 bg-gray-100">
                  </div>
               </div>

               {{-- Item Name --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Item Name</label>
                  <input type="text" value="{{ $category->item_name }}" readonly
                     class="w-full border bg-gray-100 rounded-md p-2 outline-none">
               </div>

               {{-- Price/Unit --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Price/Unit</label>
                  <input type="text" value="Rp {{ number_format($category->price, 0, ',', '.') }}" readonly
                     class="w-full border bg-gray-100 rounded-md p-2 outline-none">
               </div>

               {{-- Status --}}
               <div>
                  <label class="block font-semibold mb-1 text-greenJagat">Status</label>
                  <select name="status"
                     class="w-full border rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                     <option value="">-- Select Status --</option>
                     <option value="Active" {{ old('status', $category->status) == 'Active' ? 'selected' : '' }}>Active</option>
                     <option value="Deactive" {{ old('status', $category->status) == 'Deactive' ? 'selected' : '' }}>Deactive</option>
                  </select>
                  @error('status')
                     <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                  @enderror
               </div>

               {{-- Action Buttons --}}
               <div class="pt-4 flex gap-3">
                  <button type="submit" 
                     class="bg-greenJagat hover:bg-darkGreenJagat text-white px-6 py-2 rounded-md transition duration-300">
                     Save
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
    const otherInputContainer = document.getElementById("other-input-container");

    categorySelect.addEventListener("change", function () {
        if (this.value === "Other") {
            otherInputContainer.classList.remove("hidden");
        } else {
            otherInputContainer.classList.add("hidden");
            otherInputContainer.querySelector("input").value = "";
        }
    });
});
</script>
@endpush

@endsection
