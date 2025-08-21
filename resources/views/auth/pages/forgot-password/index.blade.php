@extends('auth.layouts.main')

@section('container')

<div class="hero min-h-screen bg-cover main-fade-in" style="background-image: url('{{ asset('img/background/bg-auth.png') }}');">
    <div class="bg-black/50 w-full h-screen flex flex-col justify-center items-center main-fade-in">
        <div class="bg-white/60 py-6 px-6 rounded-md border border-greenJagat w-full max-w-md animate-fadeInUp">
            <div class="bg-greenJagat text-white text-xl rounded-3xl w-fit px-6 py-3 mb-5">
                <h1 class="font-calistoga">Forgot Password</h1>
            </div>

            <h1 class="text-greenJagat font-calistoga text-lg">Forgot your password?</h1>
            <h2 class="text-greenJagat text-lg">Enter your email to receive a reset link.</h2>

            <form action="{{ route('auth.send-reset-link') }}" method="POST" class="gap-y-3 flex flex-col mt-5">
                @csrf
                <input type="email" name="email" placeholder="Enter your email" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-400 py-2">
                <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat transition duration-500 ease-in-out text-white py-2 rounded-xl mt-3">Send Reset Link</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    @if(session('status'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'success',
                    title: 'Success',
                    text: '{{ session("status") }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @elseif(session('error'))
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ session("error") }}',
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 3000
                });
            });
        </script>
    @endif
@endpush

@endsection
