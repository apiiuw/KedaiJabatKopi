@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Report</h1>

      {{-- Summary Cards --}}
      <div class="grid grid-cols-4 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-sack-dollar fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Incomes</h1>
               <p class="text-2xl text-white counter">Rp {{ number_format($totalIncome, 0, ',', '.') }}</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-[#A03A3A] px-6 rounded-md">
            <i class="fa-solid fa-coins fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Expenses</h1>
               <p class="text-2xl text-white counter">Rp {{ number_format($totalExpenses, 0, ',', '.') }}</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <i class="fa-solid fa-cart-shopping fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Orders</h1>
               <p class="text-2xl text-white counter">{{ $totalOrders }}</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[38px]" viewBox="0 -960 960 960" fill="currentColor">
               <path d="M533-440q-32-45-84.5-62.5T340-520q-56 0-108.5 17.5T147-440h386ZM40-360q0-109 91-174.5T340-600q118 0 209 65.5T640-360H40Zm0 160v-80h600v80H40ZM720-40v-80h56l56-560H450l-10-80h200v-160h80v160h200L854-98q-3 25-22 41.5T788-40h-68Zm0-80h56-56ZM80-40q-17 0-28.5-11.5T40-80v-40h600v40q0 17-11.5 28.5T600-40H80Zm260-400Z"/>
            </svg> 
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Best Seller</h1>
               <p class="text-2xl text-white counter">{{ $bestSellerName }}</p>
            </div>
         </div>

      </div>

      {{-- Filter Laporan --}}
      <div class="bg-white p-4 rounded-lg shadow mb-6">
         <form action="{{ route('owner.report') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            <div>
               <label class="block mb-1 font-semibold">Start Date</label>
               <input 
                  type="date" 
                  name="start_date" 
                  value="{{ old('start_date', $startDate) }}" 
                  max="{{ date('Y-m-d') }}" 
                  class="border rounded p-2"
               >
            </div>
            <div>
               <label class="block mb-1 font-semibold">End Date</label>
               <input 
                  type="date" 
                  name="end_date" 
                  value="{{ old('end_date', $endDate) }}" 
                  max="{{ date('Y-m-d') }}" 
                  class="border rounded p-2"
               >
            </div>

            <div>
               <button type="submit" class="bg-greenJagat text-white px-4 py-2 rounded hover:bg-darkGreenJagat">
                  Set Period
               </button>
            </div>
            <div>
               <button type="button" class="bg-gray-200 hover:bg-gray-300 text-gray-800 px-4 py-2 rounded"
                  onclick="window.location.href='{{ url()->current() }}'">
                  Reset
               </button>
            </div>
            <div class="ml-auto">
               <button type="button" id="exportPdfBtn" class="bg-greenJagat text-white px-4 py-2 rounded hover:bg-darkGreenJagat">
                  Export PDF
               </button>
            </div>
         </form>
      </div>

      {{-- Tabel Pendapatan --}}
      <div class="bg-white p-4 rounded-lg shadow mb-6 overflow-x-auto">
         <h2 class="font-bold text-lg mb-4">Incomes Report</h2>
         <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6">
            <table class="w-full text-md text-left rtl:text-right text-greenJagat">
               <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                  <tr>
                     <th class="px-6 py-3 whitespace-nowrap">ID Order</th>
                     <th class="px-6 py-3 whitespace-nowrap">Date</th>
                     <th class="px-6 py-3 whitespace-nowrap">Product Name</th>
                     <th class="px-6 py-3 whitespace-nowrap">Category</th>
                     <th class="px-6 py-3 whitespace-nowrap">Type</th>
                     <th class="px-6 py-3 whitespace-nowrap">Qty</th>
                     <th class="px-6 py-3 whitespace-nowrap">Price</th>
                     <th class="px-6 py-3 whitespace-nowrap">Total Amount</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse ($orders as $order)
                     <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                        <td class="px-6 py-4">#{{ $order->id_order }}</td>
                        <td class="px-6 py-4">{{ $order->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">
                           @foreach ($order->items as $item)
                              {{ $item->menu->product_name ?? 'Unknown' }}<br>
                           @endforeach
                        </td>
                        <td class="px-6 py-4">
                           @foreach ($order->items as $item)
                              {{ $item->menu->category ?? 'Unknown' }}<br>
                           @endforeach
                        </td>
                        <td class="px-6 py-4">
                           @foreach ($order->items as $item)
                              {{ $item->menu->type ?? 'Unknown' }}<br>
                           @endforeach
                        </td>
                        <td class="px-6 py-4">
                           @foreach ($order->items as $item)
                              {{ $item->quantity }}<br>
                           @endforeach
                        </td>
                        <td class="px-6 py-4">
                           @foreach ($order->items as $item)
                              Rp {{ number_format($item->price, 0, ',', '.') }}<br>
                           @endforeach
                        </td>
                        <td class="px-6 py-4">
                           Rp {{ number_format($order->total_amount, 0, ',', '.') }}
                        </td>
                     </tr>
                  @empty
                     <tr>
                        <td class="px-6 py-4 text-center" colspan="8">No data found.</td>
                     </tr>
                  @endforelse
               </tbody>

            </table>
         </div>
      </div>

      {{-- Tabel Pengeluaran --}}
      <div class="bg-white p-4 rounded-lg shadow mb-6 overflow-x-auto">
         <h2 class="font-bold text-lg mb-4">Expenses Report</h2>
         <div class="relative overflow-x-auto shadow-md sm:rounded-lg mb-6">
            <table class="w-full text-md text-left rtl:text-right text-[#A03A3A]">
               <thead class="text-md text-[#A03A3A] uppercase bg-[#E09A9A]">
                  <tr>
                     <th class="px-6 py-3 whitespace-nowrap">ID Expense</th>
                     <th class="px-6 py-3 whitespace-nowrap">Date</th>
                     <th class="px-6 py-3 whitespace-nowrap">Category</th>
                     <th class="px-6 py-3 whitespace-nowrap">Item</th>
                     <th class="px-6 py-3 whitespace-nowrap">Description</th>
                     <th class="px-6 py-3 whitespace-nowrap">Qty</th>
                     <th class="px-6 py-3 whitespace-nowrap">Price</th>
                     <th class="px-6 py-3 whitespace-nowrap">Total Amount</th>
                  </tr>
               </thead>
               <tbody>
                  @forelse ($expenses as $expense)
                     <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                        <td class="px-6 py-4">#{{ $expense->id_expenses }}</td>
                        <td class="px-6 py-4">{{ $expense->created_at->format('d/m/Y') }}</td>
                        <td class="px-6 py-4">{{ $expense->category ?? 'Unknown' }}</td>
                        <td class="px-6 py-4">{{ $expense->item }}</td>
                        <td class="px-6 py-4">{{ $expense->description }}</td>
                        <td class="px-6 py-4">{{ $expense->qty }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($expense->price, 0, ',', '.') }}</td>
                        <td class="px-6 py-4">Rp {{ number_format($expense->qty * $expense->price, 0, ',', '.') }}</td>
                     </tr>
                  @empty
                     <tr>
                        <td class="px-6 py-4 text-center" colspan="8">No data found.</td>
                     </tr>
                  @endforelse
               </tbody>
            </table>
         </div>
      </div>
   </div>
</div>

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

@if($isFiltered)
<script>
document.addEventListener('DOMContentLoaded', function () {
   const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000,
      timerProgressBar: false
   });

   Toast.fire({
         icon: 'info',
         title: '{{ $filteredCount }} data found!'
   });
});
</script>
@endif

<script>
document.addEventListener('DOMContentLoaded', function () {
   const exportBtn = document.getElementById('exportPdfBtn');
   if (exportBtn) {
      exportBtn.addEventListener('click', function() {
         const Toast = Swal.mixin({
            toast: true,
            position: 'top-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
         });
         Toast.fire({
            icon: 'info',
            title: 'Exporting PDF...'
         });

         setTimeout(() => {
            const startDate = '{{ $startDate ?? '' }}';
            const endDate = '{{ $endDate ?? '' }}';
            let url = '{{ route('owner.report.export-pdf') }}';
            let params = new URLSearchParams();
            if (startDate) params.append('start_date', startDate);
            if (endDate) params.append('end_date', endDate);
            if (params.toString()) url += '?' + params.toString();
            window.location.href = url;
         }, 1500);
      });
   }
});
</script>
@endpush


@endsection
