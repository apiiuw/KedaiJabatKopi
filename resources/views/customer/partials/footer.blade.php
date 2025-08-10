<footer class="bg-[#1C3B28] flex justify-center">
    <div class="mx-auto md:mx-7 w-full p-4 py-6 lg:py-8">
        <div class="md:flex md:justify-center">
          <div class="grid grid-cols-2 gap-1 sm:grid-cols-3 md:gap-x-64 w-full text-sm md:text-lg">
              <div class="w-4/5">
                <div class="flex items-end justify-start mb-1">
                    <img src="{{ asset('img/icon/icon-location.png') }}" class="h-8 mr-2" alt="Icon Location">
                    <h2 class="text-white text-lg md:text-2xl uppercase">Location</h2>
                </div>
                  <hr class="mb-6">
                  <ul class="text-white font-medium">
                      <li class="mb-4">
                          <a href="https://maps.app.goo.gl/cWAxwo5Xk8ungJPe8" class="hover:underline transition duration-500 ease-in-out">Jl. Arya Wangsakara No.2,<br>Bugel, Kec. Karawaci,<br>Kota Tangerang, Banten</a>
                      </li>
                  </ul>
              </div>
              <div class="w-4/5">
                <div class="flex items-end justify-start mb-1">
                    <img src="{{ asset('img/icon/icon-call.png') }}" class="h-8 mr-2" alt="Icon Call">
                    <h2 class="text-white text-lg md:text-2xl uppercase">Contact Us</h2>
                </div>
                  <hr class="mb-6">
                  <ul class="text-white font-medium">
                      <li class="mb-2">
                          <a href="https://wa.me/6288289997769" target="_blank" class="hover:underline transition duration-500 ease-in-out">Whatsapp Business</a>
                      </li>
                      <li>
                          <a href="mailto:kedaijabatkopi@gmail.com" target="_blank" class="hover:underline transition duration-500 ease-in-out">Email Business</a>
                      </li>
                  </ul>
              </div class="w-4/5">
              <div>
                <div class="flex items-end justify-start mb-1">
                    <img src="{{ asset('img/icon/icon-home.png') }}" class="h-8 mr-2" alt="Icon Home">
                    <h2 class="text-white text-lg md:text-2xl uppercase">Sitemap</h2>
                </div>
                <hr class="mb-6">
                  <ul class="text-white font-medium">
                      <li class="mb-2">
                          <a href="{{ route('customer.home') }}" class="hover:underline transition duration-500 ease-in-out">Home Page</a>
                      </li>
                      <li class="mb-2">
                          <a href="{{ route('customer.menu') }}" class="hover:underline transition duration-500 ease-in-out">Menu Page</a>
                      </li>
                      <li>
                          <a href="{{ route('customer.about-us') }}" class="hover:underline transition duration-500 ease-in-out">About Us Page</a>
                      </li>
                  </ul>
              </div>
          </div>
      </div>
      <hr class="my-6 border-gray-200 sm:mx-auto lg:my-8" />
      <div class="flex items-center sm:justify-between md:justify-center">
          <span class="text-sm md:text-lg text-white sm:text-center">© 2025 <a href="#" class="hover:underline transition duration-500 ease-in-out">Kedai Jabat Kopi™</a>. All Rights Reserved.
          </span>
      </div>
    </div>
</footer>
