@extends('auth.layouts.main')

@section('container')

<div class="hero min-h-screen bg-cover main-fade-in" style="background-image: url('{{ asset('img/background/bg-auth.png') }}');">
    <div class="bg-black/50 w-full h-screen flex flex-col justify-center items-center main-fade-in">
        <div class="bg-white/60 py-6 px-6 rounded-md border border-greenJagat w-full max-w-md animate-fadeInUp">
            <div class="bg-greenJagat text-white text-xl rounded-3xl w-fit px-6 py-3 mb-5">
                <h1 class="font-calistoga">Reset Password</h1>
            </div>

            @if (isset($error))
                <div class="bg-red-500 text-white text-center py-2 px-4 rounded-xl mb-4" id="error-message">
                    <p>{{ $error }}</p>
                </div>
            @endif

            <!-- Form will be hidden if there's an error -->
            <form action="{{ route('auth.update-password') }}" method="POST" class="gap-y-3 flex flex-col mt-5" id="resetPasswordForm">
                @csrf
                <h1 class="text-greenJagat font-calistoga text-lg">Enter your new password</h1>
                <input type="hidden" name="token" value="{{ $token }}">
                <input type="email" name="email" placeholder="Enter your email" value="{{ old('email') }}" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-400 py-2" required>
                <input type="password" name="password" placeholder="New Password" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-400 py-2" required>
                <input type="password" name="password_confirmation" placeholder="Confirm New Password" class="bg-white border border-[#746C6C] rounded-xl placeholder:text-gray-400 py-2" required>
                <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat transition duration-500 ease-in-out text-white py-2 rounded-xl mt-3">Reset Password</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
    @if(isset($error))
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                // Menyembunyikan form jika ada error
                document.getElementById('resetPasswordForm').style.display = 'none';
                // Menampilkan pesan error dengan SweetAlert2
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: '{{ $error }}',
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
