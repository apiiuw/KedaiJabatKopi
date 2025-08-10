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
               <a href="{{ route('cashier.dashboard') }}" class="{{ request()->is('cashier/dashboard') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }} flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">
                  <svg class="w-5 h-5 text-greenJagat transition duration-500 ease-in-out {{ request()->is('cashier/dashboard') ? 'text-white' : '' }}" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 22 21">
                     <path d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z"/>
                     <path d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z"/>
                  </svg>
                  <span class="ms-3">Dashboard</span>
               </a>
            </li>
            <li>
               <a href="{{ route('cashier.order') }}" class="{{ request()->is('cashier/order') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }} flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">
                  <i class="fa-solid fa-cart-shopping fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out {{ request()->is('cashier/order') ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Today's Order</span>
                  <span class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-darkGreenJagat bg-[#9FB9A9]/70 rounded-full">{{ $countPaid }}</span>
               </a>
            </li>
            <li>
               <a href="{{ route('cashier.past-order') }}" class="{{ request()->is('cashier/past-order') ? 'bg-greenJagat text-white' : 'hover:bg-lightGreenJagat' }} flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">
                  <i class="fa-solid fa-clock-rotate-left fa-lg shrink-0 text-greenJagat transition duration-500 ease-in-out {{ request()->is('cashier/past-order') ? 'text-white' : '' }}"></i>
                  <span class="flex-1 ms-3 whitespace-nowrap">Past Order</span>
               </a>
            </li>
            <li>
               <a href="{{ route('cashier.manage-menu') }}" 
                  class="{{ request()->is('cashier/manage-menu') 
                     || request()->is('cashier/manage-menu/add-menu') 
                     || request()->is('cashier/manage-menu/edit-menu*') 
                     ? 'bg-greenJagat text-white' 
                     : 'hover:bg-lightGreenJagat' }} 
                     flex items-center p-2 text-greenJagat rounded-lg group transition duration-500 ease-in-out">

                  <svg class="w-6 h-6 text-greenJagat transition duration-500 ease-in-out 
                     {{ request()->is('cashier/manage-menu') 
                           || request()->is('cashier/manage-menu/add-menu') 
                           || request()->is('cashier/manage-menu/edit-menu*') 
                           ? 'text-white' : '' }}" 
                        aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor" 
                        viewBox="0 -960 960 960">
                     <path d="M533-440q-32-45-84.5-62.5T340-520q-56 0-108.5 17.5T147-440h386ZM40-360q0-109 91-174.5T340-600q118 0 209 65.5T640-360H40Zm0 160v-80h600v80H40ZM720-40v-80h56l56-560H450l-10-80h200v-160h80v160h200L854-98q-3 25-22 41.5T788-40h-68Zm0-80h56-56ZM80-40q-17 0-28.5-11.5T40-80v-40h600v40q0 17-11.5 28.5T600-40H80Zm260-400Z"/>
                  </svg>     

                  <span class="flex-1 ms-3 whitespace-nowrap">Manage Menu</span>
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
