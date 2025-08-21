@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Expense Records</h1>

      <div class="grid grid-cols-2 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-calendar-day fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Expense</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalExpenseAll }}">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-money-bill-transfer fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Amount Expense</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalAmountAll }}" data-currency="idr"></p>
            </div>
         </div>

      </div>

      <form method="GET" action="{{ route('owner.expense-records') }}" class="mb-4">
         <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">

            {{-- Search di kiri --}}
            <div class="w-full md:w-1/3 flex">
               <input type="text" name="q" value="{{ request('q') }}"
                     placeholder="Search ID Expense/Category/Item..."
                     class="w-full border border-gray-300 rounded-l-md px-3 py-2">
               <button type="submit"
                     class="px-4 bg-greenJagat hover:bg-darkGreenJagat text-white rounded-r-md flex items-center justify-center transition duration-500 ease-in-out">
               <i class="fa fa-search"></i>
               </button>
            </div>

            {{-- Filter category di kanan --}}
            <div class="flex flex-col md:flex-row items-start md:items-end gap-3">
               <div class="flex flex-col">
                  <label for="category" class="text-sm font-medium text-gray-700">Category</label>
                  <select id="category" name="category" class="border border-gray-300 rounded-md px-3 py-2" onchange="this.form.submit()">
                     <option value="" {{ request('category')==='' ? 'selected' : '' }}>All Category</option>
                     @foreach($categories as $cat)
                        <option value="{{ $cat }}" {{ request('category')===$cat ? 'selected' : '' }}>
                              {{ $cat }}
                        </option>
                     @endforeach
                  </select>
               </div>

               {{-- Start Date --}}
               <div class="flex flex-col">
                  <label for="from" class="text-sm font-medium text-gray-700">Start Date</label>
                  <input type="date" id="from" name="from" value="{{ request('from') }}"
                           class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-greenJagat">
               </div>

               <div class="flex flex-col items-center justify-center px-0 py-2">
                  -
               </div>

               {{-- End Date --}}
               <div class="flex flex-col">
                  <label for="to" class="text-sm font-medium text-gray-700">End Date</label>
                  <input type="date" id="to" name="to" value="{{ request('to') }}"
                           class="border border-gray-300 rounded-md px-3 py-2 focus:outline-none focus:ring-2 focus:ring-greenJagat">
               </div>

               <button type="submit"
                     class="px-4 py-2 bg-greenJagat hover:bg-darkGreenJagat text-white rounded-md transition duration-500 ease-in-out">
               Set Period
               </button>
               <a href="{{ route('owner.expense-records') }}"
                  class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-500 ease-in-out">
               Reset
               </a>
            </div>

         </div>
      </form>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

         {{-- @php
            $nextDirTime   = (request('sort') === 'time'   && request('dir') === 'asc') ? 'desc' : 'asc';
            $nextDirAmount = (request('sort') === 'amount' && request('dir') === 'asc') ? 'desc' : 'asc';
         @endphp --}}

         <table class="w-full text-md text-left rtl:text-right text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                  <tr>
                     <th scope="col" class="px-6 py-3">
                        ID Expense
                     </th>
                     <th scope="col" class="px-6 py-3">
                        <a href="{{ route('owner.expense-records', array_merge(request()->all(), [
                           'sort' => 'created_at',
                           'dir' => request('dir') === 'asc' ? 'desc' : 'asc'
                        ])) }}" class="inline-flex items-center gap-1">
                           Date
                           @if(request('sort') === 'created_at')
                              <i class="fa-solid {{ request('dir') === 'asc' ? 'fa-sort-down pb-2' : 'fa-sort-up pt-2' }}"></i>
                           @else
                              <i class="fa-solid fa-sort"></i>
                           @endif
                        </a>
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Category
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Item
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Description
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Qty
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Price/Unit
                     </th>
                     <th scope="col" class="px-6 py-3">
                        <a href="{{ route('owner.expense-records', array_merge(request()->all(), [
                           'sort' => 'amount',
                           'dir' => request('dir') === 'asc' ? 'desc' : 'asc'
                        ])) }}" class="inline-flex items-center gap-1">
                           Total Amount
                           @if(request('sort') === 'amount')
                              <i class="fa-solid {{ request('dir') === 'asc' ? 'fa-sort-down pb-2' : 'fa-sort-up pt-2' }}"></i>
                           @else
                              <i class="fa-solid fa-sort"></i>
                           @endif
                        </a>
                     </th>
                     <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Detail</span>
                     </th>
                  </tr>
            </thead>
            <tbody>
               @forelse ($expenses as $expense)
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                        <th scope="row" class="px-6 py-4 whitespace-nowrap">
                           #{{ $expense->id_expenses }}
                        </th>
                        <td class="px-6 py-4">
                           {{ \Carbon\Carbon::parse($expense->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                           {{ $expense->category ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                           {{ $expense->item ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                           {{ $expense->description ?? '-' }}
                        </td>
                        <td class="px-6 py-4">
                           {{ $expense->qty ?? 0 }}
                        </td>
                        <td class="px-6 py-4">
                           Rp {{ number_format($expense->price, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                           Rp {{ number_format($expense->amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 text-right font-calistoga">

                        </td>
                  </tr>
               @empty
                  <tr>
                        <td colspan="9" class="px-6 py-4 text-center text-gray-500">
                           No expense found
                        </td>
                  </tr>
               @endforelse
            </tbody>
         </table>
      </div>

      <div class="relative overflow-x-auto shadow-md rounded-lg mt-5">
         <table class="w-full text-md text-left rtl:text-right text-greenJagat rounded-lg">
            <tbody>
                  <tr class="bg-white border border-gray-300">
                     <th scope="row" class="px-6 py-4 text-end w-3/4">
                        Total Amount Expense
                     </th>
                     <td class="px-6 py-4 text-end w-3/12">
                        Rp {{ number_format($totalCountAmount, 0, ',', '.') }}
                     </td>
                  </tr>
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
         const durationMs = 900; // total animasi dalam ms

         counters.forEach(counter => {
            const target = Number(counter.getAttribute("data-target")) || 0;
            const isRupiah = counter.dataset.currency === "idr"; // cek apakah perlu format Rp
            const start = 0;
            const startTime = performance.now();

            function tick(now) {
               const elapsed = now - startTime;
               const progress = Math.min(elapsed / durationMs, 1);
               const current = Math.floor(start + (target - start) * progress);
               let formatted = current.toLocaleString('id-ID');

               if (isRupiah) {
               formatted = "Rp " + formatted;
               }

               counter.textContent = formatted;

               if (progress < 1) {
               requestAnimationFrame(tick);
               } else {
               counter.textContent = isRupiah
                  ? "Rp " + target.toLocaleString('id-ID')
                  : target.toLocaleString('id-ID');
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