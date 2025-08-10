@extends('cashier.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Manage Menu</h1>
      <div class="grid grid-cols-3 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-mug-hot fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Drinks</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalDrinks }}">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-utensils fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Foods</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalFoods }}">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[38px]" viewBox="0 -960 960 960" fill="currentColor">
               <path d="M533-440q-32-45-84.5-62.5T340-520q-56 0-108.5 17.5T147-440h386ZM40-360q0-109 91-174.5T340-600q118 0 209 65.5T640-360H40Zm0 160v-80h600v80H40ZM720-40v-80h56l56-560H450l-10-80h200v-160h80v160h200L854-98q-3 25-22 41.5T788-40h-68Zm0-80h56-56ZM80-40q-17 0-28.5-11.5T40-80v-40h600v40q0 17-11.5 28.5T600-40H80Zm260-400Z"/>
            </svg>     
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Menus</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalMenus }}">0</p>
            </div>
         </div>

      </div>

      <form method="GET" action="{{ route('cashier.manage-menu') }}" class="flex justify-between items-end mb-4 gap-3">
         {{-- Search --}}
         <div class="relative w-full md:w-1/3">
            <input type="text" name="q" value="{{ request('q') }}"
                  placeholder="Search menu..."
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-greenJagat outline-none text-greenJagat">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
         </div>

         {{-- Filter Category + Availability + Add Menu --}}
         <div class="flex items-end gap-3">
            {{-- Category --}}
            <div class="flex flex-col">
               <label for="category" class="text-sm font-medium text-gray-700">Select Category</label>
               <select name="category"
                        onchange="this.form.submit()"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-greenJagat outline-none text-greenJagat">
                  <option value="" {{ request('category')==='' ? 'selected' : '' }}>All Categories</option>
                  <option value="Food"  {{ request('category')==='Food'  ? 'selected' : '' }}>Food</option>
                  <option value="Drink" {{ request('category')==='Drink' ? 'selected' : '' }}>Drink</option>
               </select>
            </div>

            {{-- Availability --}}
            <div class="flex flex-col">
               <label for="availability" class="text-sm font-medium text-gray-700">Select Availability</label>
               <select name="availability"
                        onchange="this.form.submit()"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-greenJagat outline-none text-greenJagat">
                  <option value="" {{ request('availability')==='' ? 'selected' : '' }}>All Availability</option>
                  <option value="available"   {{ request('availability')==='available'   ? 'selected' : '' }}>Available</option>
                  <option value="not available" {{ request('availability')==='not available' ? 'selected' : '' }}>Not Unavailable</option>
               </select>
            </div>

            <a href="{{ url()->current() }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-500 ease-in-out">
                  Reset
            </a>

            {{-- Add Menu --}}
            <a href="{{ route('cashier.manage-menu.add') }}"
               class="flex justify-center items-center py-2 px-4 bg-greenJagat text-md hover:bg-darkGreenJagat text-white rounded-md transition duration-500 ease-in-out">
               <i class="fa-solid fa-plus pb-1 mr-2"></i>
               <span>Add Menu</span>
            </a>
         </div>
      </form>


      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

         @php
         $nextDirPrice = (request('sort') === 'price' && request('dir') === 'asc') ? 'desc' : 'asc';
         @endphp

         <table class="w-full text-md text-left rtl:text-right text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
               <tr>
                  <th scope="col" class="px-6 py-3">ID Menu</th>
                  <th scope="col" class="px-6 py-3">Product name</th>
                  <th scope="col" class="px-6 py-3">Category</th>
                  <th scope="col" class="px-6 py-3">Iced/Hot</th>
                  <th scope="col" class="px-6 py-3">Sweetness</th>
                  <th scope="col" class="px-6 py-3">Espresso</th>
                  <th scope="col" class="px-6 py-3">
                     <a href="{{ route('cashier.manage-menu', array_merge(request()->all(), ['sort'=>'price','dir'=>$nextDirPrice])) }}"
                        class="inline-flex items-center gap-1">
                     Price
                     @if(request('sort')==='price')
                        <i class="fa-solid {{ request('dir')==='asc' ? 'fa-sort-down pb-2' : 'fa-sort-up pt-2' }}"></i>
                     @else
                        <i class="fa-solid fa-sort"></i>
                     @endif
                     </a>
                  </th>
                  <th scope="col" class="px-6 py-3">Availability</th>
                  <th scope="col" class="px-6 py-3"><span class="sr-only">Edit</span></th>
               </tr>
            </thead>
            <tbody>
               @foreach($menus as $menu)
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                        {{-- ID Menu diawali # --}}
                        <th scope="row" class="px-6 py-4 whitespace-nowrap">#{{ $menu->id_menu }}</th>

                        {{-- Nama Produk --}}
                        <td class="px-6 py-4 whitespace-nowrap">{{ $menu->product_name }}</td>

                        {{-- Category --}}
                        <td class="px-6 py-4">{{ $menu->category }}</td>

                        {{-- ICED/HOT --}}
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                           @if($menu->iced_hot == 1)
                              <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">Active</span>
                           @else
                              <span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded">Non Active</span>
                           @endif
                        </td>

                        {{-- Sweetness --}}
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                           @if($menu->sweetness == 1)
                              <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">Active</span>
                           @else
                              <span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded">Non Active</span>
                           @endif
                        </td>

                        {{-- Espresso --}}
                        <td class="px-6 py-4 whitespace-nowrap text-center">
                           @if($menu->espresso == 1)
                              <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">Active</span>
                           @else
                              <span class="bg-red-100 text-red-800 text-sm font-medium px-2.5 py-0.5 rounded">Non Active</span>
                           @endif
                        </td>

                        {{-- Price --}}
                        <td class="px-6 py-4 whitespace-nowrap">Rp {{ number_format($menu->price, 0, ',', '.') }}</td>

                        {{-- Availability --}}
                        <td class="px-6 py-4 whitespace-nowrap">{{ $menu->availability }}</td>

                        {{-- Edit Button --}}
                        <td class="px-6 py-4 text-right whitespace-nowrap">
                           <a href="{{ route('cashier.manage-menu.edit', $menu->id_menu) }}" 
                              class="font-calistoga text-greenJagat hover:underline">
                              Edit
                           </a>
                        </td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>

   </div>
</div>

@push('scripts')

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

   @if($isFiltered || $isSorted)
      <script>
         document.addEventListener('DOMContentLoaded', function () {
         const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: false
         });

         @if($isFiltered)
            Toast.fire({ icon: 'info', title: '{{ $filteredCount }} data found!' });
         @endif

         @if($isSorted)
            Toast.fire({ icon: 'info', title: 'Sorted by {{ $sortedBy }} ({{ $sortedDirLabel }})' });
         @endif
         });
      </script>
   @endif

   <script>
      document.addEventListener("DOMContentLoaded", function () {
         const counters = document.querySelectorAll(".counter");
         const durationMs = 500; // lama animasi total (ms)

         counters.forEach(counter => {
            const target = Number(counter.getAttribute("data-target")) || 0;
            const start  = 0;
            const startTime = performance.now();

            function tick(now) {
               const elapsed = now - startTime;
               const progress = Math.min(elapsed / durationMs, 1);      // 0..1
               const current = Math.floor(start + (target - start) * progress);
               counter.textContent = current.toLocaleString('id-ID');   // format 1.234

               if (progress < 1) {
               requestAnimationFrame(tick);
               } else {
               counter.textContent = target.toLocaleString('id-ID');  // pastikan nilai akhir
               }
            }

            requestAnimationFrame(tick);
         });
      });
   </script>


   @if(session('success'))
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

@endpush


@endsection