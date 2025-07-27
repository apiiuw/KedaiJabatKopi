<nav id="navbar" class="w-full fixed top-0 left-0 z-50 bg-greenJagat transition duration-300 ease-in-out">
  <div class="w-full flex flex-wrap md:grid md:grid-cols-3 justify-between md:justify-center items-center mx-0 py-4">
    <div class="flex justify-start ml-5 md:ml-10">
        <a href="{{ route('customer.home') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('img/icon/icon.png') }}" class="h-12" alt="Icon Jagat Kopi" />
        </a>
    </div>
    <div class="md:hidden"></div>
    <div class="flex md:order-2">
        <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search" aria-expanded="false" class="md:hidden text-white text-sm p-2.5 me-1">
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
 
            <a href="{{ route('customer.cart') }}" class="flex items-center space-x-3 rtl:space-x-reverse text-white md:hover:text-gray-300 transition duration-300 ease-in-out">
                <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="currentColor">
                  <path d="M360-640v-80h240v80H360ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/>
                </svg>
            </a>
        </div>

        <a href="{{ route('customer.cart') }}" class="flex items-center rtl:space-x-reverse md:hidden text-white">
          <svg xmlns="http://www.w3.org/2000/svg" height="32px" viewBox="0 -960 960 960" width="32px" fill="currentColor">
            <path d="M360-640v-80h240v80H360ZM280-80q-33 0-56.5-23.5T200-160q0-33 23.5-56.5T280-240q33 0 56.5 23.5T360-160q0 33-23.5 56.5T280-80Zm400 0q-33 0-56.5-23.5T600-160q0-33 23.5-56.5T680-240q33 0 56.5 23.5T760-160q0 33-23.5 56.5T680-80ZM40-800v-80h131l170 360h280l156-280h91L692-482q-11 20-29.5 31T622-440H324l-44 80h480v80H280q-45 0-68.5-39t-1.5-79l54-98-144-304H40Z"/>
          </svg>
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
          <a href="{{ route('customer.home') }}" class="{{ request()->is('/') ? 'md:underline bg-greenJagat text-white' : 'md:hover:text-gray-300' }} block py-2 px-3 rounded-sm md:hover:bg-transparent md:bg-transparent md:text-white transition duration-500 ease-in-out md:p-0" aria-current="page">Home</a>
        </li>
        <li class="{{ request()->is('menu') ? 'bg-greenJagat text-white' : '' }} relative block py-2 px-3 rounded-sm md:hover:bg-transparent md:bg-transparent md:text-white transition duration-500 ease-in-out md:p-0">
          <button onclick="toggleSubMenu()" class="{{ request()->is('menu') ? 'md:underline' : '' }} flex w-full justify-between items-center rounded-sm md:bg-transparent md:text-white transition duration-300 ease-in-out">
            Menu
            <svg class="w-4 h-4 transition-transform duration-300 ml-1" id="submenu-arrow" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
          </button>

          <!-- Submenu -->
          <ul id="submenu" class="absolute left-0 mt-2 md:mt-[1.6rem] hidden text-black md:text-white w-full md:w-40 z-50 bg-white md:bg-greenJagat/70 md:backdrop-blur-md">
            <li><a href="{{ route('customer.menu') }}" class="{{ request()->is('menu') ? 'md:underline bg-greenJagat text-white' : '' }} block px-4 py-2 md:hover:text-gray-300 md:text-white transition duration-300 ease-in-out">The Drink</a></li>
            <li><a href="#noncoffee" class="block px-4 py-2 md:hover:text-gray-300 transition duration-300 ease-in-out">The Food</a></li>
          </ul>
        </li>
          <a href="{{ route('customer.about-us') }}" class="{{ request()->is('about-us') ? 'md:underline bg-greenJagat text-white' : 'md:hover:text-gray-300' }} block py-2 px-3 rounded-sm md:hover:bg-transparent md:bg-transparent md:text-white transition duration-500 ease-in-out md:p-0">About Us</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script>
  const navbar = document.getElementById('navbar');

  window.addEventListener('scroll', () => {
    if (window.scrollY > 10) {
      // Navbar blur dan transparan
      navbar.classList.remove('bg-greenJagat');
      navbar.classList.add('backdrop-blur-md', 'bg-greenJagat/70');
    } else {
      navbar.classList.remove('backdrop-blur-md', 'bg-greenJagat/70');
      navbar.classList.add('bg-greenJagat');
    }
  });
</script>

<script>
  function toggleSubMenu() {
    const submenu = document.getElementById("submenu");
    const arrow = document.getElementById("submenu-arrow");
    submenu.classList.toggle("hidden");
    arrow.classList.toggle("rotate-180");
  }

  // Optional: klik di luar submenu akan menutup submenu
  document.addEventListener("click", function (event) {
    const button = event.target.closest("button[onclick='toggleSubMenu()']");
    const submenu = document.getElementById("submenu");
    if (!button && !event.target.closest("#submenu")) {
      submenu.classList.add("hidden");
      document.getElementById("submenu-arrow")?.classList.remove("rotate-180");
    }
  });
</script>


