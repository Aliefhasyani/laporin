<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pelaporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-900/30 border-l-4 border-red-500 p-4 rounded-md shadow-sm">
                    <h3 class="text-sm font-medium text-red-800 dark:text-red-200 mb-2">Ada kesalahan pada input Anda:</h3>
                    <ul class="list-disc list-inside text-sm text-red-700 dark:text-red-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Silahkan isi form di bawah ini untuk membuat laporan.") }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    <form action="{{ route('laporan') }}" method="POST" enctype="multipart/form-data" class="space-y-6"> 
                        @csrf 
                        
                        <div>
                            <label for="nama_jalanan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Nama Jalanan</label>
                            <input type="text" name="nama_jalanan" id="nama_jalanan" 
                                class="block w-full rounded-md border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition duration-150" 
                                placeholder="Masukkan nama jalanan">
                        </div>

                        <div>
                            <label for="path_foto_jalanan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Jalanan</label>
                            <input type="file" name="path_foto_jalanan" id="path_foto_jalanan" 
                                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600 cursor-pointer transition duration-150">
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tandai Lokasi</label>
                            <div id="map" class="w-full rounded-lg shadow-sm border border-gray-300 dark:border-gray-700" style="height: 550px; z-index: 10;"></div>
                            
                            <input type="hidden" name="latitude" id="latitude_input">
                            <input type="hidden" name="longitude" id="longitude_input">
                        </div>

                        <div class="flex items-center justify-end pt-4">
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-gray-800 dark:bg-gray-200 border border-transparent rounded-md font-semibold text-xs text-white dark:text-gray-800 uppercase tracking-widest hover:bg-gray-700 dark:hover:bg-white focus:bg-gray-700 dark:focus:bg-white active:bg-gray-900 dark:active:bg-gray-300 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-800 transition ease-in-out duration-150">
                                Submit Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var map = L.map('map').setView([-6.200000, 106.816666], 13); 

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(map);

            var marker = L.marker([-6.200000, 106.816666]).addTo(map);

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                
                marker.setLatLng(e.latlng);
                
                document.getElementById('latitude_input').value = lat;
                document.getElementById('longitude_input').value = lng;
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        });
    </script>
</x-app-layout>