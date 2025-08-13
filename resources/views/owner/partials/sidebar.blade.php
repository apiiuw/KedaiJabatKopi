<button data-drawer-target="separator-sidebar" data-drawer-toggle="separator-sidebar" aria-controls="separator-sidebar" type="button" class="inline-flex items-center p-2 mt-2 ms-3 text-sm text-greenJagat rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
   <span class="sr-only">Open sidebar</span>
   <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
   <path clip-rule="evenodd" fill-rule="evenodd" d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z"></path>
   </svg>
</button>

<aside id="separator-sidebar" class="fixed top-0 left-0 z-40 w-64 h-screen transition-transform -translate-x-full sm:translate-x-0" aria-label="Sidebar">
   <div id="sidebar-anim" class="h-full transition-all duration-500 ease-out sm:translate-x-[-16px] sm:opacity-0">
      <div class="flex flex-row justify-center items-center py-3 bg-[#F3F7F5]">
         <img src="{{ asset('img/icon/icon.png') }}" class="w-16 h-16" alt="Logo Jabat Kopi">
         <h1 class="text-xl font-calistoga text-greenJagat">Kedai Jabat Kopi</h1>
      </div>
      <hr class="border-t border-gray-300 mx-3">
      <div class="px-3 py-4 bg-[#F3F7F5]">
         <div class="flex items-center p-2 text-greenJagat group bg-lightGreenJagat">
            <i class="fa-solid fa-user-gear fa-lg shrink-0"></i>
            <div class="flex flex-col justify-start">
               <h1 class="font-semibold ms-3">
                  {{ ucfirst(Auth::user()->role) }}, 
               </h1>
               <h1 class="font-normal ms-3">
                  {{ Auth::user()->name }}
               </h1>
            </div>
         </div>
      </div>
      <hr class="border-t border-gray-300 mx-3">
      <div class="h-full px-3 py-4 overflow-y-auto bg-[#F3F7F5]">
         <ul class="space-y-2 font-medium">
            <li>
               <a href="{{ route('owner.dashboard') }}" class="{{ request()->is('owner/dashboard') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }} flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">
                  <svg class="w-5 h-5 text-greenJagat transition duration-500 ease-in-out {{ request()->is('owner/dashboard') ? 'text-white' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                     <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                  </svg>
                  <span class="ms-3">Dashboard</span>
               </a>
            </li>
            <li>
               <a href="{{ route('owner.dailys-expense') }}" 
                  class="{{ request()->is('owner/dailys-expense')
                     || request()->is('owner/dailys-expense/add-expense') 
                     || request()->is('owner/dailys-expense/edit*') 
                     ? 'bg-greenJagat text-white' 
                     : 'hover:bg-lightGreenJagat' }}  
                     flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">

                  <i class="fa-solid fa-money-bill-transfer fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out 
                     {{ request()->is('owner/dailys-expense')
                        || request()->is('owner/dailys-expense/add-expense') 
                        || request()->is('owner/dailys-expense/edit*') 
                        ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Daily's Expense</span>
                  <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-darkGreenJagat bg-[#9FB9A9]/70 rounded-full">{{ $todayExpenseCount ?? 0 }}</span>
               </a>
            </li>
            <li>
               <a href="{{ route('owner.expense-records') }}" class="{{ request()->is('owner/expense-records') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }} flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">
                  <i class="fa-solid fa-money-bill-trend-up fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out {{ request()->is('owner/expense-records') ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Expense Records</span>
               </a>
            </li>
            <li>
               <a href="{{ route('owner.manage-category-expense') }}" 
                  class="{{ request()->is('owner/manage-category-expense') 
                     || request()->is('owner/manage-category-expense/add-category') 
                     || request()->is('owner/manage-category-expense/edit*') 
                     ? 'bg-greenJagat text-white' 
                     : 'hover:bg-lightGreenJagat' }}  
                     flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">

                  <i class="fa-solid fa-coins fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out 
                     {{ request()->is('owner/manage-category-expense') 
                        || request()->is('owner/manage-category-expense/add-category') 
                        || request()->is('owner/manage-category-expense/edit*') 
                        ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Manage Category Expense</span>
               </a>
            </li>
            <li>
               <a href="{{ route('owner.order-records') }}" class="{{ request()->is('owner/order-records') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }} flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">
                  <i class="fa-solid fa-clock-rotate-left fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out {{ request()->is('owner/order-records') ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Order Records</span>
               </a>
            </li>
            <li>
                <a href="{{ route('owner.report') }}" 
                    class="{{ request()->is('owner/report') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }}
                        flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">

                    <i class="fa-solid fa-file-arrow-down  fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out {{ request()->is('owner/report') ? 'text-white' : '' }}"></i>

                    <span class="flex-1 ms-3 whitespace-nowrap">Report</span>
                </a>
            </li>
            <li>
               <a href="{{ route('owner.access-control') }}" 
                  class="{{ request()->is('owner/access-control') 
                     || request()->is('owner/access-control/add-account') 
                     || request()->is('owner/access-control/edit*') 
                     ? 'bg-greenJagat text-white' 
                     : 'hover:bg-lightGreenJagat' }} 
                     flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">

                  <i class="fa-solid fa-universal-access fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out 
                  {{ request()->is('owner/access-control') 
                           || request()->is('owner/access-control/add-account') 
                           || request()->is('owner/access-control/edit*') 
                           ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Access Control</span>
               </a>
            </li>
            <li>
               <a href="{{ route('owner.store-operational-schedule') }}" 
                  class="{{ request()->is('owner/store-operational-schedule') 
                     ? 'bg-greenJagat text-white' 
                     : 'hover:bg-lightGreenJagat' }} 
                     flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">

                  <i class="fa-solid fa-store fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out 
                  {{ request()->is('owner/store-operational-schedule') 
                           ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Store Operational Schedule</span>
               </a>
            </li>
         </ul>
         <ul class="pt-4 mt-4 space-y-2 font-medium border-t border-gray-300">
            <li>
               <a href="{{ route('auth.sign-out') }}" class="{{ request()->is('cashier/sign-out') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }} flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">
                  <i class="fa-solid fa-right-from-bracket fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out {{ request()->is('cashier/sign-out') ? 'text-white' : '' }}"></i>
                  <span class="ms-3">Sign Out</span>
               </a>
            </li>
         </ul>
      </div>
   </div>
</aside>
 
@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
  const el = document.getElementById('sidebar-anim');
  if (!el) return;

  // Jalankan di frame berikutnya supaya transition kepicu
  requestAnimationFrame(() => {
    el.classList.remove('sm:translate-x-[-16px]', 'sm:opacity-0');
    el.classList.add('sm:translate-x-0', 'sm:opacity-100');
  });
});
</script>
@endpush
