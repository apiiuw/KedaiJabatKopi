@extends('cashier.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Cashier Dashboard</h1>

      {{-- Ringkasan Statistik Utama --}}
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
      <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
         <i class="fa-solid fa-clipboard-list fa-2xl text-white"></i>
         <div class="flex flex-col items-start">
            <h3 class="text-white font-semibold text-xl">Total Orders (Today)</h3>
            <p class="text-2xl text-white counter" data-target="{{ number_format($ordersToday) }}">0</p>
         </div>
      </div>

      <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
         <i class="fa-solid fa-sack-dollar fa-2xl text-white"></i>
         <div class="flex flex-col items-start">
            <h3 class="text-white font-semibold text-xl">Total Income (Today)</h3>
            <p class="text-2xl text-white counter" data-target="{{ $incomeToday }}" data-currency="idr"></p>
         </div>
      </div>

      <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
         <i class="fa-solid fa-clipboard-question fa-2xl text-white"></i>
         <div class="flex flex-col items-start">
            <h3 class="text-white font-semibold text-xl">On Going</h3>
            <p class="text-2xl text-white counter" data-target="{{ $onGoingCount }}">0</p>
         </div>
      </div>

      <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
         <i class="fa-solid fa-clipboard-check fa-2xl text-white"></i>
         <div class="flex flex-col items-start">
            <h3 class="text-white font-semibold text-xl">Complete</h3>
            <p class="text-2xl text-white counter" data-target="{{ $completeCount }}">0</p>
         </div>
      </div>
      </div>

      {{-- Best Seller Today --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
         <div class="col-span-1 bg-white rounded-md border border-gray-200 p-4">
            <h4 class="text-greenJagat font-semibold mb-2">Best Seller (Today)</h4>
            <p class="text-gray-700"><span class="font-medium">{{ $bestSellerName }}</span></p>
            <p class="text-sm text-gray-500">Qty: {{ number_format($bestSellerQty) }}</p>
         </div>

         {{-- Quick Access Menu --}}
         <div class="col-span-1 md:col-span-2 grid grid-cols-1 sm:grid-cols-3 gap-3">
            <a href="{{ route('cashier.order') }}"
               class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
               <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Today's Order</div>
               </div>
               <i class="fa-solid fa-cart-shopping text-greenJagat text-xl"></i>
            </a>
            <a href="{{ route('cashier.past-order') }}"
               class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
               <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Past Order</div>
               </div>
               <i class="fa-solid fa-clock-rotate-left text-greenJagat text-xl"></i>
            </a>
            <a href="{{ route('cashier.manage-menu') }}"
               class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
               <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Manage Menu</div>
               </div>
               <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" viewBox="0 -960 960 960" fill="#2E6342">
                  <path d="M533-440q-32-45-84.5-62.5T340-520q-56 0-108.5 17.5T147-440h386ZM40-360q0-109 91-174.5T340-600q118 0 209 65.5T640-360H40Zm0 160v-80h600v80H40ZM720-40v-80h56l56-560H450l-10-80h200v-160h80v160h200L854-98q-3 25-22 41.5T788-40h-68Zm0-80h56-56ZM80-40q-17 0-28.5-11.5T40-80v-40h600v40q0 17-11.5 28.5T600-40H80Zm260-400Z"/>
               </svg>    
            </a>
         </div>
      </div>

      {{-- Grafik Penjualan Sederhana (Hari Ini) --}}
      <div class="bg-white rounded-md border border-gray-200 p-4">
      <div class="flex items-center justify-between mb-2">
         <h4 class="text-greenJagat font-semibold">Sales Today (by Hour)</h4>
         <span class="text-xs text-gray-500">Sum of total amount</span>
      </div>
      <canvas id="salesChart" height="110"></canvas>
      </div>
   </div>
</div>

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

   {{-- Chart.js CDN --}}
   <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
   <script>
      document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('salesChart').getContext('2d');
      const labels = @json($labels);
      const dataVals = @json($values);

      new Chart(ctx, {
         type: 'bar',
         data: {
            labels,
            datasets: [{
            label: 'Income (Rp)',
            data: dataVals,
            backgroundColor: 'rgba(46, 99, 66, 0.8)',
            borderColor: '#2E6342',
            borderWidth: 1,
            borderRadius: 6,              // biar bar agak rounded
            hoverBorderWidth: 2,
            }]
         },
         options: {
            responsive: true,
            aspectRatio: 3,

            // ✨ Animations
            animation: {
            duration: 300,
            easing: 'easeOutQuart',
            delay: (ctx) => {
               // delay per bar biar muncul bergantian
               if (ctx.type === 'data' && ctx.mode === 'default') {
                  return ctx.dataIndex * 120;
               }
               return 0;
            }
            },
            animations: {
            y: {
               // bar “tumbuh” dari sumbu X (0) ke nilai akhirnya
               from: 0
            }
            },

            // UX kecil saat hover
            onHover: (evt, elements, chart) => {
            const canvas = chart.canvas;
            canvas.style.cursor = elements.length ? 'pointer' : 'default';
            },

            scales: {
            y: {
               beginAtZero: true,
               ticks: {
                  callback: function(value){
                  return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                  }
               }
            }
            },
            plugins: {
            legend: { display: false },
            tooltip: {
               callbacks: {
                  label: function(ctx){
                  const val = ctx.parsed.y || 0;
                  return 'Rp ' + new Intl.NumberFormat('id-ID').format(val);
                  }
               }
            }
            }
         }
      });
      });
   </script>


@endpush

@endsection