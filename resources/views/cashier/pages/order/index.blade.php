@extends('cashier.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">
         Today's Order - {{ \Carbon\Carbon::now()->translatedFormat('d F Y') }}
      </h1>

      <div class="grid grid-cols-4 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-credit-card fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Order Paid</h1>
               <p class="text-2xl text-white">{{ $countPaid }}</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-clipboard-question fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Order On Going</h1>
               <p class="text-2xl text-white">{{ $countOnGoing }}</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-clipboard-check fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Order Complete</h1>
               <p class="text-2xl text-white">{{ $countComplete }}</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <i class="fa-solid fa-clipboard-list fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Order</h1>
               <p class="text-2xl text-white">{{ $countAll }}</p>
            </div>
         </div>

      </div>

      {{-- <div class="flex justify-end items-center mb-4">
         <a href="#" class="flex justify-center items-center py-2 px-4 bg-greenJagat text-md hover:bg-darkGreenJagat text-white rounded-md">
            <i class="fa-solid fa-plus pb-1 mr-2"></i>
            <h1>Add Order</h1>
         </a>
      </div> --}}

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
         <table class="w-full text-md text-left rtl:text-right text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                  <tr>
                     <th scope="col" class="px-6 py-3">
                        ID Order
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Time
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Table Number
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Name
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Total Amount
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Status
                     </th>
                     <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
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
                  {{ \Carbon\Carbon::parse($order->created_at)->format('H.i') }}
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
                  <td class="px-6 py-4 capitalize">
                  @if ($order->status == 'paid')
                     <span class="bg-green-100 text-green-800 text-sm font-medium px-2.5 py-0.5 rounded">
                        {{ ucwords($order->status) }}
                     </span>
                  @elseif ($order->status == 'on going')
                     <span class="bg-yellow-100 text-yellow-800 text-sm font-medium px-2.5 py-0.5 rounded">
                        {{ ucwords($order->status) }}
                     </span>
                  @elseif ($order->status == 'complete')
                     <span class="bg-blue-100 text-blue-800 text-sm font-medium px-2.5 py-0.5 rounded">
                        {{ ucwords($order->status) }}
                     </span>
                  @else
                     <span class="bg-gray-100 text-gray-800 text-sm font-medium px-2.5 py-0.5 rounded">
                        {{ ucwords($order->status) }}
                     </span>
                  @endif
                  </td>
                  <td class="px-6 py-4 text-right">
                  <button
                     type="button"
                     onclick="document.getElementById('modal-{{ $order->id }}').classList.remove('hidden')"
                     class="font-medium text-greenJagat hover:underline">
                     View
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
                        Rp 424.000
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
       class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
    <div class="bg-white rounded-lg w-[800px] p-6">
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

      <div class="mt-4 flex justify-end gap-2">
         @if ($order->status === 'complete')
            {{-- Tidak ada tombol --}}
         @elseif ($order->status === 'on going')
            <!-- Tombol Finish Order -->
            <button 
               onclick="document.getElementById('confirm-process-{{ $order->id }}').classList.remove('hidden')" 
               class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition duration-500 ease-in-out">
               Finish Order
            </button>
         @else
            <!-- Tombol Process Order -->
            <button 
               onclick="document.getElementById('confirm-process-{{ $order->id }}').classList.remove('hidden')" 
               class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition duration-500 ease-in-out">
               Process Order
            </button>
         @endif

         <!-- Tombol Close -->
         <button 
            onclick="document.getElementById('modal-{{ $order->id }}').classList.add('hidden')" 
            class="px-4 py-2 bg-greenJagat hover:bg-darkGreenJagat text-white rounded transition duration-500 ease-in-out">
            Close
         </button>
      </div>

      <!-- Confirmation Modal -->
      <div id="confirm-process-{{ $order->id }}" 
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
         <div class="bg-white rounded-lg w-[400px] p-6">
            <h3 class="text-lg font-semibold mb-4">Confirmation</h3>

            @if ($order->status === 'on going')
                  <p>Are you sure you want to finish order <strong>#{{ $order->id_order }}</strong>?</p>
            @else
                  <p>Are you sure you want to process order <strong>#{{ $order->id_order }}</strong>?</p>
            @endif

            <div class="mt-6 flex justify-end gap-2">
                  <!-- Cancel Button -->
                  <button 
                     onclick="document.getElementById('confirm-process-{{ $order->id }}').classList.add('hidden')" 
                     class="px-4 py-2 bg-gray-300 hover:bg-gray-400 rounded transition duration-500 ease-in-out">
                     Cancel
                  </button>

                  <!-- Action Button -->
                  <form action="{{ route('orders.process', $order->id_order) }}" method="POST">
                     @csrf
                     @if ($order->status === 'on going')
                        <button type="submit" class="px-4 py-2 bg-green-600 hover:bg-green-700 text-white rounded transition duration-500 ease-in-out">
                              Yes, Finish
                        </button>
                     @else
                        <button type="submit" class="px-4 py-2 bg-yellow-500 hover:bg-yellow-600 text-white rounded transition duration-500 ease-in-out">
                              Yes, Process
                        </button>
                     @endif
                  </form>
            </div>
         </div>
      </div>


    </div>
  </div>
@endforeach

@push('scripts')
    @if(session('successOnGoing'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success',
                text: "{{ session('successOnGoing') }}",
                confirmButtonText: 'OK',
                confirmButtonColor: '#2E6342', // greenJagat
            });
        </script>
    @endif

    @if(session('successFinish'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Completed',
                text: "{{ session('successFinish') }}",
                confirmButtonText: 'OK',
                confirmButtonColor: '#2E6342', // biru untuk complete
            });
        </script>
    @endif
@endpush

@endsection