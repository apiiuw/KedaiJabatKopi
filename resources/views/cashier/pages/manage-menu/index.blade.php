@extends('cashier.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Manage Menu</h1>
      <div class="grid grid-cols-3 gap-4 mb-4">

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-mug-hot fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Drinks</h1>
               <p class="text-2xl text-white">13</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md">
            <i class="fa-solid fa-utensils fa-2xl text-white"></i>
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Foods</h1>
               <p class="text-2xl text-white">8</p>
            </div>
         </div>

         <div class="flex flex-row-reverse items-center justify-between h-32 bg-greenJagat px-6 rounded-md text-white">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-[38px]" viewBox="0 -960 960 960" fill="currentColor">
                <path d="M533-440q-32-45-84.5-62.5T340-520q-56 0-108.5 17.5T147-440h386ZM40-360q0-109 91-174.5T340-600q118 0 209 65.5T640-360H40Zm0 160v-80h600v80H40ZM720-40v-80h56l56-560H450l-10-80h200v-160h80v160h200L854-98q-3 25-22 41.5T788-40h-68Zm0-80h56-56ZM80-40q-17 0-28.5-11.5T40-80v-40h600v40q0 17-11.5 28.5T600-40H80Zm260-400Z"/>
            </svg>     
            <div class="flex flex-col items-start">
               <h1 class="text-white font-semibold text-xl">Total Menus</h1>
               <p class="text-2xl text-white">21</p>
            </div>
         </div>

      </div>

      <div class="flex justify-end items-center mb-4">
         <a href="#" class="flex justify-center items-center py-2 px-4 bg-greenJagat text-md hover:bg-darkGreenJagat text-white rounded-md">
            <i class="fa-solid fa-plus pb-1 mr-2"></i>
            <h1>Add Menu</h1>
         </a>
      </div>

      <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
         <table class="w-full text-md text-left rtl:text-right text-greenJagat">
            <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                  <tr>
                     <th scope="col" class="px-6 py-3">
                        Product name
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Category
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Price
                     </th>
                     <th scope="col" class="px-6 py-3">
                        Availability
                     </th>
                     <th scope="col" class="px-6 py-3">
                        <span class="sr-only">Edit</span>
                     </th>
                  </tr>
            </thead>
            <tbody>
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                     <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        Americano
                     </th>
                     <td class="px-6 py-4">
                        Drink
                     </td>
                     <td class="px-6 py-4">
                        Rp 23.000
                     </td>
                     <td class="px-6 py-4">
                        Available
                     </td>
                     <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-greenJagat hover:underline">Edit</a>
                     </td>
                  </tr>
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                     <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        Matcha Latte
                     </th>
                     <td class="px-6 py-4">
                        Drink
                     </td>
                     <td class="px-6 py-4">
                        Rp 35.000
                     </td>
                     <td class="px-6 py-4">
                        Not Available
                     </td>
                     <td class="px-6 py-4 text-right">
                        <a href="#" class="font-medium text-greenJagat hover:underline">Edit</a>
                     </td>
                  </tr>
                  <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                     <th scope="row" class="px-6 py-4 whitespace-nowrap">
                        Long Black
                     </th>
                     <td class="px-6 py-4">
                        Drink
                     </td>
                     <td class="px-6 py-4">
                        Rp 25.000
                     </td>
                     <td class="px-6 py-4">
                        Available
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