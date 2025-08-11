@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
        {{-- Header --}}
        <div class="flex items-center mb-6">
            <a href="javascript:history.back()" class="flex justify-center">
                <i class="fa-solid fa-chevron-left fa-xl text-greenJagat hover:text-darkGreenJagat transition duration-500 ease-in-out"></i>
            </a>
            <h1 class="font-calistoga text-greenJagat text-3xl ms-3">Access Control | Add Account</h1>
        </div>

        {{-- Form Card --}}
        <div class="bg-white px-6">
            <form action="{{ route('owner.access-control.add-account.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf

                {{-- Full Name --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Full Name</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Enter full name"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                    @error('name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Role --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Role</label>
                    <select name="role"
                        class="w-full border rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                        <option value="">-- Select Role --</option>
                        <option value="cashier" {{ old('role') == 'Cashier' ? 'selected' : '' }}>Cashier</option>
                        <option value="owner" {{ old('role') == 'Owner' ? 'selected' : '' }}>Owner</option>
                    </select>
                    @error('role')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Email --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="Enter email"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Password --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Password</label>
                    <input type="password" name="password" placeholder="Enter password"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Confirm Password --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Confirm Password</label>
                    <input type="password" name="password_confirmation" placeholder="Enter confirm password"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat text-white px-6 py-2 rounded-md transition duration-300">
                        Save Account
                    </button>
                </div>

            </form>
        </div>

   </div>
</div>

@endsection