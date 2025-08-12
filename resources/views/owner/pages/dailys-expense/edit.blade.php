@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
        {{-- Header --}}
        <div class="flex items-center mb-6">
            <a href="javascript:history.back()" class="flex justify-center">
                <i class="fa-solid fa-chevron-left fa-xl text-greenJagat hover:text-darkGreenJagat transition duration-500 ease-in-out"></i>
            </a>
            <h1 class="font-calistoga text-greenJagat text-3xl ms-3">Daily's Expense | Edit Expense #{{ $expense->id_expenses }}</h1>
        </div>

        {{-- Form Card --}}
        <div class="bg-white px-6">
            <form action="{{ route('owner.dailys-expense.update', $expense->id) }}" method="POST" enctype="multipart/form-data" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- Category --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Category</label>
                    <select name="category" class="w-full border rounded-md p-2 bg-gray-100" disabled>
                            <option value="{{ $expense->category }}" {{ $expense->category == $expense->category ? 'selected' : '' }}>
                                {{ $expense->category }}
                            </option>
                    </select>
                </div>

                {{-- Item --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Item</label>
                    <select name="item" class="w-full border rounded-md p-2 bg-gray-100" disabled>
                        <option value="{{ $expense->item }}" {{ $expense->item == $expense->item ? 'selected' : '' }}>
                            {{ $expense->item }}
                        </option>
                    </select>
                </div>

                {{-- Price/Unit --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Price/Unit</label>
                    <input type="text" value="Rp {{ number_format($expense->price, 0, ',', '.') }}" readonly
                        class="w-full border rounded-md p-2 bg-gray-100">
                </div>

                {{-- Quantity --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Quantity</label>
                    <input type="number" value="{{ $expense->qty }}" readonly
                        class="w-full border rounded-md p-2 bg-gray-100">
                </div>

                {{-- Description --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Description</label>
                    <textarea name="description"
                        placeholder="Enter description"
                        class="w-full border placeholder:text-gray-400 rounded-md p-2 focus:ring-2 focus:ring-greenJagat outline-none">{{ old('description', $expense->description) }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Amount --}}
                <div>
                    <label class="block font-semibold mb-1 text-greenJagat">Amount</label>
                    <input type="text" value="Rp {{ number_format($expense->amount, 0, ',', '.') }}" readonly
                        class="w-full border rounded-md p-2 bg-gray-100">
                </div>

                {{-- Submit Button --}}
                <div class="pt-4">
                    <button type="submit" class="bg-greenJagat hover:bg-darkGreenJagat text-white px-6 py-2 rounded-md transition duration-300">
                        Update Expense
                    </button>
                </div>
            </form>
        </div>

   </div>
</div>

@endsection