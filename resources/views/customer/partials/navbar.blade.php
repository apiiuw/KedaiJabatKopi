<nav class=" bg-greenJagat border-gray-200">
  <div class="w-full flex flex-wrap md:grid md:grid-cols-3 justify-between md:justify-center items-center mx-0 py-4">
    <div class="flex justify-start ml-5 md:ml-10">
        <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/icon/icon.png') }}" class="h-12" alt="Icon Jagat Kopi" />
        </a>
    </div>
    <div class="md:hidden"></div>
    <div class="flex md:order-2">
        <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="md:hidden text-white hover:bg-gray-100 focus:outline-none focus:ring-4 focus:ring-gray-200 rounded-lg text-sm p-2.5 me-1">
        <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
        </svg>
        <span class="sr-only">Search</span>
        </button>
        <div class="relative hidden md:flex justify-end items-center space-x-2">
            <div class="relative w-full md:w-1/2">
                <input type="text" id="search-navbar"
                    class="block w-full h-auto md:h-9 px-2 ps-3 text-lg text-gray-900 border border-gray-300 rounded-lg bg-gray-50 md:bg-white/5 md:text-white placeholder:text-white/70"
                    placeholder="Search...">
                <div class="absolute inset-y-0 end-0 flex items-center pe-3 pointer-events-none">
                    <svg class="w-4 h-4 text-gray-500 md:text-white" aria-hidden="true" xmlns="http://www.w3.org/2000/svg"
                        fill="none" viewBox="0 0 20 20">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                    </svg>
                </div>
            </div>

            <a href="/" class="flex items-center space-x-3 rtl:space-x-reverse">
                <img src="{{ asset('img/icon/icon-cart.png') }}" class="h-12" alt="Icon Jagat Kopi" />
            </a>
        </div>

        <a href="/" class="flex items-center rtl:space-x-reverse md:hidden">
            <img src="{{ asset('img/icon/icon-cart.png') }}" class="h-10" alt="Icon Jagat Kopi" />
        </a>

        <button data-collapse-toggle="navbar-search" type="button" class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-white rounded-lg md:hidden" aria-controls="navbar-search" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
            </svg>
        </button>
    </div>
    <div class="items-center justify-center hidden w-full md:flex md:w-auto md:order-1 px-5" id="navbar-search">
      <div class="relative mt-3 md:hidden">
        <div class="absolute inset-y-0 start-0 flex items-center ps-3 pointer-events-none">
          <svg class="w-4 h-4 text-black" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 20">
            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z"/>
          </svg>
        </div>
        <input type="text" id="search-navbar" class="block w-full p-2 ps-10 text-sm text-gray-900 border border-gray-300 rounded-lg bg-gray-50" placeholder="Search...">
      </div>
      <ul class="flex flex-col p-4 md:p-0 mt-4 font-medium text-sm md:text-lg border border-gray-100 rounded-lg bg-gray-50 md:bg-transparent md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 md:border-0">
        <li>
          <a href="#" class="block py-2 px-3 text-white bg-greenJagat rounded-sm md:bg-transparent md:text-white md:p-0" aria-current="page">Home</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:text-white md:hover:text-gray-300 md:p-0">Menu</a>
        </li>
        <li>
          <a href="#" class="block py-2 px-3 text-gray-900 rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:text-white md:hover:text-gray-300 md:p-0">About Us</a>
        </li>
      </ul>
    </div>
  </div>
</nav>
