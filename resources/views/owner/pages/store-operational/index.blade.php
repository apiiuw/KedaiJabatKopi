@extends('owner.layouts.main')
@section('container')

<div class="p-4 sm:ml-64">
   <div class="p-4">

      {{-- Title --}}
      <h1 class="font-calistoga text-greenJagat text-3xl mb-6">Store Operational Schedule</h1>

      {{-- Store Status Card --}}
      <div class="bg-white rounded-xl shadow p-6 mb-8 border border-gray-200">
         <div class="flex items-center justify-between">
            <div>
               <h2 class="text-lg font-semibold text-gray-700">Store Status</h2>
               <p class="text-sm text-gray-500">Turn your store on or off manually.</p>
            </div>

            {{-- On/Off Switch --}}
            <label class="relative inline-flex items-center cursor-pointer">
                <input 
                    type="checkbox" 
                    id="storeStatus" 
                    class="sr-only peer" 
                    {{ $is_open ? 'checked' : '' }}
                >
                <div class="w-14 h-8 bg-gray-200 peer-focus:outline-none peer-focus:ring-2 peer-focus:ring-greenJagat rounded-full peer peer-checked:after:translate-x-[12px] peer-checked:after:border-white after:content-[''] after:absolute after:top-1 after:left-1 after:bg-white after:border-gray-300 after:border after:rounded-full after:h-6 after:w-6 after:transition-all peer-checked:bg-greenJagat"></div>
            </label>

         </div>
      </div>

      {{-- Operational Schedule Table --}}
      <div class="bg-white rounded-xl shadow p-6 border border-gray-200">
         <h2 class="text-lg font-semibold text-gray-700">Automatic Operational Schedule</h2>
         <p class="text-sm text-gray-500 mb-6">Set the store's opening and closing hours for each day. The store will open/close automatically.</p>

         <form id="scheduleForm" action="{{ route('owner.store-operational-schedule.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="relative overflow-x-auto shadow-md sm:rounded-lg">
                <table class="w-full text-md text-left rtl:text-right text-greenJagat rounded">
                    <thead class="text-md text-greenJagat uppercase bg-lightGreenJagat">
                        <tr>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap">Day</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">Open Time</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">Close Time</th>
                            <th scope="col" class="px-6 py-3 whitespace-nowrap text-center">Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($days as $day)
                            <tr class="bg-white border-b border-gray-200 hover:bg-[#F3F7F5]">
                                {{-- Day --}}
                                <td class="px-6 py-4 font-medium whitespace-nowrap">
                                    {{ $day['name'] }}
                                </td>

                                {{-- Open Time --}}
                                <td class="px-6 py-4 text-center">
                                    <input type="time" name="schedule[{{ $day['key'] }}][open]" 
                                        value="{{ $day['open'] ?? '' }}" 
                                        class="border rounded px-2 py-1 w-32 focus:ring-greenJagat focus:border-greenJagat">
                                </td>

                                {{-- Close Time --}}
                                <td class="px-6 py-4 text-center">
                                    <input type="time" name="schedule[{{ $day['key'] }}][close]" 
                                        value="{{ $day['close'] ?? '' }}" 
                                        class="border rounded px-2 py-1 w-32 focus:ring-greenJagat focus:border-greenJagat">
                                </td>

                                {{-- Action Toggle --}}
                                <td class="px-6 py-4 text-center font-calistoga">
                                    <input type="checkbox" name="schedule[{{ $day['key'] }}][active]" 
                                        {{ $day['active'] ? 'checked' : '' }} 
                                        class="w-5 h-5 text-greenJagat border-gray-300 rounded focus:ring-greenJagat transition duration-500 ease-in-out">
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="mt-6 flex justify-start">
               <button type="submit" class="px-6 py-2 bg-greenJagat text-white rounded-lg hover:bg-darkGreenJagat transition duration-500 ease-in-out">
                  Save Schedule
               </button>
            </div>
         </form>
      </div>

   </div>
</div>

@push('scripts')
    <script>
        document.getElementById('storeStatus').addEventListener('change', function() {
            let status = this.checked ? 1 : 0;
            
            fetch("{{ route('owner.store-operational-schedule.status') }}", {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ is_open: status })
            })
            .then(res => res.json())
            .then(data => {
                console.log(data.message);
            })
            .catch(err => {
                console.error("Error updating store status:", err);
            });
        });
    </script>

    <script>
        document.querySelector('#scheduleForm').addEventListener('submit', function(e) {
            e.preventDefault();

            fetch(this.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: new FormData(this)
            })
            .then(res => res.json())
            .then(data => {
                const Toast = Swal.mixin({
                    toast: true,
                    position: 'top-end',
                    showConfirmButton: false,
                    timer: 4000,
                    timerProgressBar: false,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer)
                        toast.addEventListener('mouseleave', Swal.resumeTimer)
                    }
                });

                Toast.fire({
                    icon: data.success ? 'success' : 'error',
                    title: data.message
                });
            })
            .catch(err => {
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Failed to update schedule!'
                });
            });
        });
    </script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
    document.getElementById('storeStatus').addEventListener('change', function() {
        let status = this.checked ? 1 : 0;

        fetch("{{ route('owner.store-operational-schedule.status') }}", {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ is_open: status })
        })
        .then(res => res.json())
        .then(data => {
            // Tampilkan notifikasi toast
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 4000,
                timerProgressBar: false,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            });

            Toast.fire({
                icon: data.success ? 'success' : 'error',
                title: data.message || (status ? 'Store opened' : 'Store closed'),
            });
        })
        .catch(err => {
            console.error("Error updating store status:", err);
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Failed to update store status!'
            });
        });
    });
    </script>

@endpush

@endsection
