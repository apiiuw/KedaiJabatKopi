@extends('cashier.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Past Order</h1>
      <div class="grid grid-cols-3 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <i class="fa-solid fa-clipboard-list fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Past Order</h1>
               <p class="text-2xl text-white">21</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-sack-dollar fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Income</h1>
               <p class="text-2xl text-white">Rp 1.215.000</p>
            </div>
         </div>

      </div>

      {{-- <div class="flex justify-end items-center mb-4">
         <a href="#" class="flex justify-center items-center py-2 px-4 bg-greenJagat text-md hover:bg-darkGreenJagat text-white rounded-md">
            <i class="fa-solid fa-plus pb-1 mr-2"></i>
            <h1>Add Order</h1>
         </a>
      </div> --}}

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
         <table class="w-full text-md text-left rtl:text-right text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                  <tr>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        ID Order
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Tanggal
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        No. Table
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Name
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Total Price
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        Status
                     </th>
                     <th scope="col" class="px-6 py-3 whitespace-nowrap">
                        <span class="sr-only">Edit</span>
                     </th>
                  </tr>
            </thead>
            <tbody>
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                     <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        #ORD3215
                     </th>
                     <td class="px-6 py-4">
                        06/08/2025
                     </td>
                     <td class="px-6 py-4">
                        13
                     </td>
                     <td class="px-6 py-4">
                        Syawalia Nurul FItri
                     </td>
                     <td class="px-6 py-4">
                        Rp 143.000
                     </td>
                     <td class="px-6 py-4">
                        Compelete
                     </td>
                     <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-greenJagat hover:underline">Edit</a>
                     </td>
                  </tr>
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                     <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        #ORD3451
                     </th>
                     <td class="px-6 py-4">
                        06/08/2025
                     </td>
                     <td class="px-6 py-4">
                        15
                     </td>
                     <td class="px-6 py-4">
                        Nuzulul Firdaus
                     </td>
                     <td class="px-6 py-4">
                        Rp 143.000
                     </td>
                     <td class="px-6 py-4">
                        On Going
                     </td>
                     <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-greenJagat hover:underline">Edit</a>
                     </td>
                  </tr>
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                     <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        #ORD3761
                     </th>
                     <td class="px-6 py-4">
                        06/08/2025
                     </td>
                     <td class="px-6 py-4">
                        8
                     </td>
                     <td class="px-6 py-4">
                        Ghaniragazzo Dzakwan
                     </td>
                     <td class="px-6 py-4">
                        Rp 143.000
                     </td>
                     <td class="px-6 py-4">
                        On Going
                     </td>
                     <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-greenJagat hover:underline">Edit</a>
                     </td>
                  </tr>
            </tbody>
         </table>
      </div>

   </div>
</div>

@endsection