@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Past Order</h1>
      <div class="grid grid-cols-2 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <i class="fa-solid fa-clipboard-list fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Past Order</h1>
               <p class="text-2xl text-white counter" data-target="{{ $countPastOrdersAll }}"></p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-sack-dollar fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Income</h1>
               <p class="text-2xl text-white counter" data-target="{{ $totalIncomePastAll }}" data-currency="idr"></p>
            </div>
         </div>

      </div>

      {{-- <div class="flex justify-end items-center mb-4">
         <a href="#" class="flex justify-center items-center py-2 px-4 bg-greenJagat text-md hover:bg-darkGreenJagat text-white rounded-md">
            <i class="fa-solid fa-plus pb-1 mr-2"></i>
            <h1>Add Order</h1>
         </a>
      </div> --}} 

      <form method="GET" action="{{ route('cashier.past-order') }}" class="mb-4">
         <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-3">
            
            {{-- Search di kiri --}}
            <div class="w-full md:w-1/3 flex">
               <input type="text" name="q" value="{{ request('q') }}"
                     placeholder="Search ID Order/Name/Table..."
                     class="w-full border border-gray-300 rounded-l-md px-3 py-2 ">

               <button type="submit"
                        class="px-4 bg-greenJagat hover:bg-darkGreenJagat text-white rounded-r-md transition flex items-center justify-center">
                  <i class="fa fa-search"></i>
               </button>
            </div>

            {{-- Filter tanggal di kanan --}}
            <div class="flex flex-col md:flex-row items-start md:items-end gap-3">
               
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

               {{-- Buttons --}}
               <div class="flex items-end gap-2">
                  <button type="submit"
                           class="px-4 py-2 bg-greenJagat hover:bg-darkGreenJagat text-white rounded-md transition duration-500 ease-in-out">
                        Set Period
                  </button>
                  <a href="{{ url()->current() }}"
                     class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-md transition duration-500 ease-in-out">
                        Reset
                  </a>
               </div>
            </div>

         </div>
      </form>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

         @php
            $nextDirDate   = (request('sort') === 'date'   && request('dir') === 'asc') ? 'desc' : 'asc';
            $nextDirAmount = (request('sort') === 'amount' && request('dir') === 'asc') ? 'desc' : 'asc';
         @endphp

         <table class="w-full text-md text-left rtl:text-right text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                  <tr>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        ID Order
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <a href="{{ route('cashier.past-order', array_merge(request()->all(), ['sort'=>'date','dir'=>$nextDirDate])) }}"
                           class="inline-flex items-center gap-1">
                        Date
                        @if(request('sort')==='date')
                           <i class="fa-solid {{ request('dir')==='asc' ? 'fa-sort-down pb-2' : 'fa-sort-up pt-2' }}"></i>
                        @else
                           <i class="fa-solid fa-sort"></i>
                        @endif
                        </a>
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        No. Table
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Name
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <a href="{{ route('cashier.past-order', array_merge(request()->all(), ['sort'=>'amount','dir'=>$nextDirAmount])) }}"
                           class="inline-flex items-center gap-1">
                        Total Amount
                        @if(request('sort')==='amount')
                           <i class="fa-solid {{ request('dir')==='asc' ? 'fa-sort-down pb-2' : 'fa-sort-up pt-2' }}"></i>
                        @else
                           <i class="fa-solid fa-sort"></i>
                        @endif
                        </a>
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
               @foreach ($orders as $order)
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                        <th scope="row" class="px-6 py-4 whitespace-nowrap">
                           #{{ $order->id_order }}
                        </th>
                        <td class="px-6 py-4">
                           {{ \Carbon\Carbon::parse($order->created_at)->format('d/m/Y') }}
                        </td>
                        <td class="px-6 py-4">
                           {{ $order->table_number }}
                        </td>
                        <td class="px-6 py-4">
                           {{ $order->name }}
                        </td>
                        <td class="px-6 py-4">
                           Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4">
                           <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
                              {{ ucwords($order->status) }}
                           </span>
                        </td>
                        <td class="px-6 py-4 text-right font-calistoga">
                           <button type="button"
                              onclick="openModal({{ $order->id }})"
                              class="font-medium text-greenJagat hover:underline">
                              Detail
                           </button>
                        </td>
                  </tr>
               @endforeach
            </tbody>

         </table>
      </div>

      <div class="relative overflow-x-auto shadow-md rounded-lg mt-5">
         <table class="w-full text-md text-left rtl:text-right text-greenJagat rounded-lg">
         <tbody>
            <tr class="bg-white border border-gray-300">
               <th scope="row" class="px-6 py-4 text-end w-3/4">
               Total Income
               </th>
               <td class="px-6 py-4 text-end w-3/12">
               Rp {{ number_format($totalIncomePast, 0, ',', '.') }}
               </td>
            </tr>
         </tbody>
         </table>
      </div>

   </div>
</div>

{{-- Render semua modal DI LUAR tabel --}}
@foreach ($orders as $order)
  <div id="modal-{{ $order->id }}" 
       class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 transition-opacity duration-300 ease-out">
    <div class="bg-white rounded-lg w-[800px] p-6 transform transition-all duration-300 ease-out scale-95 opacity-0"
         id="modal-content-{{ $order->id }}">
      <h2 class="text-xl font-semibold mb-4">Order Detail</h2>

      <div class="grid grid-cols-2 gap-y-2 text-sm mb-4">
         <div class="flex">
            <span class="font-semibold w-32">ID Order</span>
            <span>: #{{ $order->id_order }}</span>
         </div>
         <div class="flex">
            <span class="font-semibold w-32">Table Number</span>
            <span>: {{ $order->table_number }}</span>
         </div>
         <div class="flex">
            <span class="font-semibold w-32">Name</span>
            <span>: {{ $order->name }}</span>
         </div>
         <div class="flex">
            <span class="font-semibold w-32">Total Amount</span>
            <span>: Rp {{ number_format($order->total_amount, 0, ',', '.') }}</span>
         </div>
         <div class="flex col-span-2">
            <span class="font-semibold w-32">Status</span>
            <span>: {{ ucwords($order->status) }}</span>
         </div>
      </div>

      <!-- Table Detail Items -->
      <div class="mt-6 overflow-x-auto shadow-md sm:rounded-lg">
         <table class="w-full text-md text-left text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
               <tr>
                  <th class="px-6 py-3">Product Name</th>
                  <th class="px-6 py-3">Category</th>
                  <th class="px-6 py-3">Type</th>
                  <th class="px-6 py-3">Quantity</th>
                  <th class="px-6 py-3">Price</th>
               </tr>
            </thead>
            <tbody>
               @foreach ($order->items as $item)
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                        <td class="px-6 py-4">
                           <div class="font-medium">
                              {{ $item->menu->product_name ?? '-' }}
                           </div>
                           <div class="text-sm text-gray-500 italic">
                              {{ $item->description ?? '-' }}
                           </div>
                        </td>
                        <td class="px-6 py-4">{{ $item->menu->category ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->menu->type ?? '-' }}</td>
                        <td class="px-6 py-4">{{ $item->quantity }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                  </tr>
               @endforeach
            </tbody>
         </table>
      </div>

      <!-- Tombol Close -->
      <div class="mt-4 flex justify-end">
         <button 
            onclick="closeModal({{ $order->id }})" 
            class="px-4 py-2 bg-greenJagat hover:bg-darkGreenJagat text-white rounded transition duration-300 ease-in-out">
            Close
         </button>
      </div>
    </div>
  </div>
@endforeach

@push('scripts')

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

   <script>
   function openModal(id) {
      const modal = document.getElementById(`modal-${id}`);
      const content = document.getElementById(`modal-content-${id}`);
      modal.classList.remove('hidden');
      setTimeout(() => {
         content.classList.remove('scale-95', 'opacity-0');
         content.classList.add('scale-100', 'opacity-100');
      }, 10);
   }

   function closeModal(id) {
      const modal = document.getElementById(`modal-${id}`);
      const content = document.getElementById(`modal-content-${id}`);
      content.classList.remove('scale-100', 'opacity-100');
      content.classList.add('scale-95', 'opacity-0');
      setTimeout(() => {
         modal.classList.add('hidden');
      }, 300);
   }
   </script>

   @if($isFiltered || $isSorted)
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
@endpush


@endsection