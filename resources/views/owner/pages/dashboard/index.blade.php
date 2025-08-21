@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Owner Dashboard</h1>

      {{-- Ringkasan Statistik Utama --}}
      <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-dollar-sign fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h3 class="text-white font-semibold text-xl">Total Income (Today)</h3>
               <p class="text-2xl text-white counter" data-target="{{ $incomeToday }}" data-currency="idr">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-money-bill-wave fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h3 class="text-white font-semibold text-xl">Total Expense (Today)</h3>
               <p class="text-2xl text-white counter" data-target="{{ $expenseToday }}" data-currency="idr">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-receipt fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h3 class="text-white font-semibold text-xl">Total Orders (Today)</h3>
               <p class="text-2xl text-white counter" data-target="{{ $ordersToday }}">0</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-users fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h3 class="text-white font-semibold text-xl">Total Users</h3>
               <p class="text-2xl text-white counter" data-target="{{ $userCount }}">0</p>
            </div>
         </div>
      </div>

      {{-- Quick Access Menu --}}
      <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
         <a href="{{ route('owner.dailys-expense') }}"
            class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
            <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Daily's Expense</div>
            </div>
            <i class="fa-solid fa-money-bill-transfer text-greenJagat text-xl"></i>
         </a>

         <a href="{{ route('owner.expense-records') }}"
            class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
            <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Expense Record</div>
            </div>
            <i class="fa-solid fa-money-bill-trend-up text-greenJagat text-xl"></i>
         </a>

         <a href="{{ route('owner.manage-category-expense') }}"
            class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
            <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Manage Category Expense</div>
            </div>
            <i class="fa-solid fa-coins text-greenJagat text-xl"></i>
         </a>

         <a href="{{ route('owner.order-records') }}"
            class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
            <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Order Records</div>
            </div>
            <i class="fa-solid fa-clock-rotate-left text-greenJagat text-xl"></i>
         </a>

         <a href="{{ route('owner.report') }}"
            class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
            <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Report</div>
            </div>
            <i class="fa-solid fa-file-arrow-down text-greenJagat text-xl"></i>
         </a>

         <a href="{{ route('owner.access-control') }}"
            class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
            <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Access Control</div>
            </div>
            <i class="fa-solid fa-universal-access text-greenJagat text-xl"></i>
         </a>

         <a href="{{ route('owner.store-operational-schedule') }}"
            class="flex items-center justify-between bg-white hover:bg-lightGreenJagat border border-gray-200 rounded-md p-4 hover:shadow transition duration-500 ease-in-out">
            <div>
               <div class="text-sm text-gray-500">Go to</div>
               <div class="text-greenJagat font-semibold">Store Operational Schedule</div>
            </div>
            <i class="fa-solid fa-store text-greenJagat text-xl"></i>
         </a>
      </div>

      {{-- Grafik Pendapatan vs Pengeluaran Hari Ini --}}
      <div class="bg-white rounded-md border border-gray-200 p-4">
         <div class="flex items-center justify-between mb-2">
            <h4 class="text-greenJagat font-semibold">Income vs Expense Today (by Hour)</h4>
            <span class="text-xs text-gray-500">Summary of total amount</span>
         </div>
         <canvas id="incomeExpenseChart" height="110"></canvas>
      </div>
   </div>
</div>

@push('scripts')
<script>
   document.addEventListener("DOMContentLoaded", function () {
      const counters = document.querySelectorAll(".counter");
      const durationMs = 900;

      counters.forEach(counter => {
         const target = Number(counter.getAttribute("data-target")) || 0;
         const isRupiah = counter.dataset.currency === "idr";
         const startTime = performance.now();

         function tick(now) {
            const elapsed = now - startTime;
            const progress = Math.min(elapsed / durationMs, 1);
            const current = Math.floor(target * progress);
            let formatted = current.toLocaleString('id-ID');

            if (isRupiah) formatted = "Rp " + formatted;

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

<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.1/dist/chart.umd.min.js"></script>
<script>
   document.addEventListener('DOMContentLoaded', function () {
      const ctx = document.getElementById('incomeExpenseChart').getContext('2d');
      const labels = @json($hourLabels);  // misal ['08:00', '09:00', ...]
      const incomeData = @json($incomeByHour);  // array angka pendapatan per jam
      const expenseData = @json($expenseByHour); // array angka pengeluaran per jam

      new Chart(ctx, {
         type: 'bar',
         data: {
            labels,
            datasets: [
               {
                  label: 'Income',
                  data: incomeData,
                  backgroundColor: 'rgba(46, 99, 66, 0.8)',
                  borderColor: '#2E6342',
                  borderWidth: 1,
                  borderRadius: 6,
                  hoverBorderWidth: 2,
               },
               {
                  label: 'Expense',
                  data: expenseData,
                  backgroundColor: 'rgba(220, 53, 69, 0.8)', // merah
                  borderColor: '#DC3545',
                  borderWidth: 1,
                  borderRadius: 6,
                  hoverBorderWidth: 2,
               }
            ]
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
                     callback: function(value) {
                        return 'Rp ' + new Intl.NumberFormat('id-ID').format(value);
                     }
                  }
               }
            },
            plugins: {
               legend: { position: 'top' },
               tooltip: {
                  callbacks: {
                     label: function(ctx) {
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
