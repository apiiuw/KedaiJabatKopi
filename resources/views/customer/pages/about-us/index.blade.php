@extends('customer.layouts.main')
@section('container')

<div class="flex flex-col justify-center md:mt-20">
    {{-- Section 1 --}}
    <div class="w-full h-screen md:h-[41.5rem] relative bg-cover md:bg-cover" style="background-image:url('img/background/bg-about-us.png');">
        <div class="absolute text-white text-4xl md:text-8xl leading-normal font-calistoga pt-[260%] pl-[5%] md:leading-normal md:pt-[40%] md:pl-[5%]" style="transform: translate(0%, -50%); z-index: 10;">
            <p>Mission</p>
            <p class="text-xl font-amiri md:text-4xl mt-3">
                experience the rich and bold flavor of our<br>
                exquisite coffee blends, crafted to awaken your<br>
                senses and start your day right.
            </p>
        </div>
    </div>

    {{-- Section 2 --}}
    <div class="flex flex-col md:flex-row justify-center items-center h-screen px-5 md:px-10">
        <div class=" w-full md:w-1/2 flex justify-center">
            <img src="{{ asset('img/about-us/section-2.png') }}" class=" h-full rounded-lg" alt="">
        </div>

        <div class="flex flex-col justify-center items-end text-white text-end w-full md:w-1/2">
            <h1 class="font-calistoga text-3xl md:text-5xl mt-5 md:-mt-32">About Kedai Jabat Kopi</h1>
            <p class="text-xl font-amiri md:text-3xl mt-10">
                experience the rich and bold flavor of our<br>
                exquisite coffee blends, crafted to awaken your<br>
                senses and start your day right.
            </p>
        </div>

    </div>
    
    {{-- Section 3 --}}
    <div class="flex flex-col justify-center items-center w-full h-screen">
        <h1 class="font-calistoga text-3xl md:text-5xl text-center text-white mb-16 px-5">We Started Operation In 2010,  And Today:</h1>

        <div class="overflow-hidden relative w-full">
            <div class="carousel-wrapper flex gap-x-10 animate-scroll-x">
                <!-- Semua item -->
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s1.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s2.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s3.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s4.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s5.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>

                <!-- Duplikat untuk loop tak terputus -->
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s1.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s2.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s3.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s4.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
                <div class="carousel-item">
                    <img src="{{ asset('img/about-us/section-3-s5.png') }}" class="h-[30rem] rounded-lg" alt="Pizza" />
                </div>
            </div>
        </div>

    </div>

    {{-- Section 4 --}}
    <div class="flex flex-col md:flex-row justify-center items-center h-screen px-5 md:px-10">

        <div class="flex flex-col justify-center items-start text-white text-start w-full md:w-1/2">
            <h1 class="font-calistoga text-3xl md:text-5xl -mt-32">Our Location</h1>
            <p class="text-xl font-amiri md:text-3xl mt-3 md:mt-10">
                Jl. Arya Wangsakara No.2, <br>
                RT.002/RW.012, Bugel, Kec. Karawaci, <br>
                Kota Tangerang, Banten 15114 
            </p>
        </div>

        <div class=" w-full md:w-1/2 flex justify-center mt-10 md:mt-0">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3966.628073014741!2d106.60260217480283!3d-6.180510393806947!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f92a9e0949a7%3A0x6b6a97fd1c839cbb!2sJABATKOPI!5e0!3m2!1sid!2sid!4v1753562283793!5m2!1sid!2sid" 
            class=" w-full h-96 rounded-lg" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
        </div>

    </div>
</div>

@endsection