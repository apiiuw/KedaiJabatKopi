@extends('auth.layouts.main')
@section('container')

<div class="hero min-h-screen bg-cover" style="background-image: url('{{ asset('img/background/bg-auth.png') }}');">
    <div class="bg-black/50 w-full h-screen flex flex-col justify-center items-center">
        <div class="bg-white/60 py-6 px-6 rounded-md border border-greenJagat w-full max-w-md">
            <div class="bg-greenJagat text-white text-xl rounded-3xl w-fit pl-5 pr-1 py-3 mb-5 -ml-2">
                <a href="{{ route('auth.sign-up') }}">Sign up</a><span class="bg-[#D9D9D9] rounded-3xl px-10 py-1 text-greenJagat ml-5"><a href="{{ route('auth.sign-in') }}">Sign in</a></span>
            </div>

            <h1 class="text-white font-calistoga text-lg">Welcome Back</h1>
            <h2 class="text-white text-lg">Your Coffee is almost Ready!</h2>
        
            <div class="mt-5 gap-y-3 flex flex-col">
                <input type="email" name="email" id="" placeholder="Email" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-300 py-2">
                <input type="password" name="password" id="" placeholder="Enter your password" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-300 py-2">
                <button class="bg-greenJagat text-white py-2 rounded-xl mt-3">Log in</button>

                <div class="flex items-center gap-4 mt-4">
                    <hr class="flex-grow border-t border-[#746C6C]">
                    <span class="text-[#746C6C] text-xs">OR SIGN IN WITH</span>
                    <hr class="flex-grow border-t border-[#746C6C]">
                </div>

                <a class="bg-white text-black flex items-center justify-center text-center py-0 rounded-xl mt-4 mb-10">
                    <img src="{{ asset('img/icon/icon-google.png') }}" class=" w-10 h-10">
                    <p>Login with google</p>
                </a>
            </div>
        </div>
    </div>
</div>


@endsection