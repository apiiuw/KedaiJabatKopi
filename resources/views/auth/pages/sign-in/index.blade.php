@extends('auth.layouts.main')
@section('container')

<style>
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(30px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    @keyframes mainFadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    .main-fade-in {
        animation: mainFadeIn 1s ease-out forwards;
    }

    .animate-fadeInUp {
        animation: fadeInUp 0.7s ease-out forwards;
    }
</style>

<div class="hero min-h-screen bg-cover main-fade-in" style="background-image: url('{{ asset('img/background/bg-auth.png') }}');">
    <div class="bg-black/50 w-full h-screen flex flex-col justify-center items-center main-fade-in">
        <div class="bg-white/60 py-6 px-6 rounded-md border border-greenJagat w-full max-w-md animate-fadeInUp">
            <div class="bg-greenJagat text-white text-xl rounded-3xl w-fit px-6 py-3 mb-5">
                <h1 class="font-calistoga">Sign In</h1>
            </div>

            <h1 class="text-greenJagat font-calistoga text-lg">Welcome Back</h1>
            <h2 class="text-greenJagat text-lg">Your Coffee is almost Ready!</h2>
        
            <div class="mt-5 gap-y-3 flex flex-col">
                <form action="{{ route('auth.sign-in.post') }}" method="POST" class="gap-y-3 flex flex-col">
                    @csrf
                    <input type="email" name="email" placeholder="Email" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-400 py-2">
                    <input type="password" name="password" placeholder="Enter your password" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-400 pt-2">
                    <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat transition duration-500 ease-in-out text-white py-2 rounded-xl mt-3">Sign in</button>
                </form>
                <a href="{{ route('auth.forgot-password') }}" class="text-sm text-greenJagat hover:underline self-end">Forgot Password?</a>

                <div class="flex items-center gap-4 mt-4">
                    <hr class="flex-grow border-t border-[#746C6C]">
                    <span class="text-[#746C6C] text-xs">OR SIGN IN WITH</span>
                    <hr class="flex-grow border-t border-[#746C6C]">
                </div>

                <a href="{{ route('auth.google') }}" class="bg-white hover:bg-gray-200 transition duration-500 ease-in-out text-black flex items-center justify-center text-center py-0 rounded-xl mt-4 mb-10">
                    <img src="{{ asset('img/icon/icon-google.png') }}" class=" w-10 h-10">
                    <p>Sign in with google</p>
                </a>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    @if ($errors->any())
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const firstError = @json($errors->first());
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({ icon: 'error', title: firstError });
            });
        </script>
    @endif

    @if (session('status'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const statusMessage = @json(session('status'));
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
                Toast.fire({ icon: 'success', title: statusMessage });
            });
        </script>
    @endif
@endpush


@endsection