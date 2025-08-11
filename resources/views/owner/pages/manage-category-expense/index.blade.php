@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Manage Category Expense</h1>

      <div class="grid grid-cols-3 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-sack-dollar fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Category Active</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalActive }}">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-sack-xmark fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Category Deactive</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalDeactive }}">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <i class="fa-solid fa-coins fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Category Expense</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalAll }}">0</p>
            </div>
         </div>

      </div>

      <form method="GET" action="{{ route('owner.manage-category-expense') }}" class="flex justify-between items-end mb-4 gap-3">
         {{-- Search --}}
         <div class="relative w-full md:w-1/3">
            <input type="text" name="search" value="{{ request('search') }}"
                  placeholder="Search category..."
                  class="w-full pl-10 pr-4 py-2 border border-gray-300 rounded-md focus:ring-2 focus:ring-greenJagat outline-none text-greenJagat">
            <i class="fa-solid fa-magnifying-glass absolute left-3 top-3 text-gray-400"></i>
         </div>

         {{-- Filter Status + Add Category --}}
         <div class="flex items-end gap-3">
            {{-- Category --}}
            <div class="flex flex-col">
               <label for="s_status" class="text-sm font-medium text-gray-700">Select Status</label>
               <select name="s_status"
                        onchange="this.form.submit()"
                        class="border border-gray-300 rounded-md px-3 py-2 focus:ring-2 focus:ring-greenJagat outline-none text-greenJagat">
                  <option value="">All Status</option>
                  <option value="Active" {{ request('s_status') == 'Active' ? 'selected' : '' }}>Active</option>
                  <option value="Deactive" {{ request('s_status') == 'Deactive' ? 'selected' : '' }}>Deactive</option>
               </select>
            </div>

            <a href="{{ url()->current() }}"
               class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-500 ease-in-out">
                  Reset
            </a>

            {{-- Add Menu --}}
            <a href="{{ route('owner.manage-category-expense.add-category') }}"
               class="flex justify-center items-center py-2 px-4 bg-greenJagat text-md hover:bg-darkGreenJagat text-white rounded-md transition duration-500 ease-in-out">
               <i class="fa-solid fa-plus pb-1 mr-2"></i>
               <span>Add Category</span>
            </a>
         </div>
      </form>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

         <table class="w-full text-md text-left rtl:text-right text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                  <tr>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        ID Category Expense
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Category
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Item Name
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Price/Unit
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Status
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <span class="sr-only">Detail</span>
                     </th>
                  </tr>
            </thead>
            <tbody>
               @forelse ($categories as $cat)
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                        <th scope="row" class="px-6 py-4 whitespace-nowrap">
                           #{{ $cat->id_category_expense }}
                        </th>
                        <td class="px-6 py-4">
                           {{ $cat->category }}
                        </td>
                        <td class="px-6 py-4">
                           {{ $cat->item_name }}
                        </td>
                        <td class="px-6 py-4">
                           Rp {{ number_format($cat->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                           <span class="{{ $cat->status == 'Active' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }} text-sm font-medium px-2.5 py-0.5 rounded capitalize">
                              {{ $cat->status }}
                           </span>
                        </td>
                        <td class="px-6 py-4 text-right font-calistoga">
                           <a href="{{ route('owner.manage-category-expense.edit', $cat->id) }}"
                              class="font-medium text-greenJagat hover:underline">
                              Edit
                           </a>
                        </td>
                  </tr>
               @empty
                  <tr>
                        <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                           No category found.
                        </td>
                  </tr>
               @endforelse
            </tbody>



         </table>
      </div>

   </div>
</div>

@push('scripts')

   <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
         Toast.fire({
            icon: 'info',
            title: '{{ $filteredCount }} data found!'
         });
      @endif

      @if($isSorted)
         Toast.fire({
            icon: 'info',
            title: 'Sorted by {{ $sortedBy }} ({{ $sortedDirLabel }})'
         });
      @endif
   });
   </script>
   @endif


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