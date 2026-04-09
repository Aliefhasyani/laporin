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
                            <label for="path_foto_jalanan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2">
                                Foto Kondisi Jalanan
                            </label>
                            <div class="mt-1 flex items-center space-x-4">
                                <input type="file" name="path_foto_jalanan" id="path_foto_jalanan" accept="image/*"
                                    class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2.5 file:px-6 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-indigo-400 cursor-pointer transition-all">
                            </div>
                            
                            <div id="image-preview-container" class="hidden mt-4">
                                <p class="text-sm font-medium text-gray-500 dark:text-gray-400 mb-2">Pratinjau Foto:</p>
                                <div class="relative w-full sm:max-w-md rounded-xl overflow-hidden border border-gray-200 dark:border-gray-700 shadow-sm bg-gray-50 dark:bg-gray-900">
                                    <img id="image-preview" src="" alt="Pratinjau" class="w-full h-auto object-cover max-h-64">
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-2">Tandai Lokasi</label>
                            
                            <div id="map-wrapper" class="relative w-full h-64 sm:h-72 rounded-lg shadow-sm border border-gray-300 dark:border-gray-700 overflow-hidden transition-all duration-300">
                                
                                <div id="map-click-overlay" class="absolute inset-0 z-[500] cursor-pointer bg-black/5 hover:bg-black/10 flex items-center justify-center transition-colors">
                                    <span class="bg-white/90 dark:bg-gray-800/90 text-gray-800 dark:text-gray-200 px-4 py-2 rounded-full text-sm font-medium shadow-sm pointer-events-none flex items-center space-x-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8V4m0 0h4M4 4l5 5m11-1V4m0 0h-4m4 0l-5 5M4 16v4m0 0h4m-4 0l5-5m11 5l-5-5m5 5v-4m0 4h-4" />
                                        </svg>
                                        <span>Klik untuk perbesar & pilih lokasi</span>
                                    </span>
                                </div>

                                <div id="map" class="w-full h-full z-10"></div>
                                
                                <button type="button" id="close-map-btn" class="hidden absolute top-4 right-4 z-[1000] bg-gray-900/90 text-white px-4 py-2 rounded-md shadow-lg hover:bg-black focus:outline-none flex items-center space-x-2 backdrop-blur-sm transition">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    <span class="text-sm font-semibold tracking-wide">Tutup Peta</span>
                                </button>
                            </div>
                            
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
            var defaultLat = -6.200000;
            var defaultLng = 106.816666;
            
            const latInput = document.getElementById('latitude_input');
            const lngInput = document.getElementById('longitude_input');
            latInput.value = defaultLat;
            lngInput.value = defaultLng;

            var map = L.map('map', {
                scrollWheelZoom: false 
            }).setView([defaultLat, defaultLng], 13); 

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; OpenStreetMap'
            }).addTo(map);

            var marker = L.marker([defaultLat, defaultLng]).addTo(map);

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    var userLat = position.coords.latitude;
                    var userLng = position.coords.longitude;

                    map.setView([userLat, userLng], 16); 
                    marker.setLatLng([userLat, userLng]);

                    latInput.value = userLat;
                    lngInput.value = userLng;
                }, function(error) {
                    console.log("Akses lokasi ditolak atau gagal. Menggunakan lokasi default.");
                });
            }

            map.on('click', function(e) {
                var lat = e.latlng.lat;
                var lng = e.latlng.lng;
                
                marker.setLatLng(e.latlng);
                latInput.value = lat;
                lngInput.value = lng;
            });

            const mapWrapper = document.getElementById('map-wrapper');
            const mapOverlay = document.getElementById('map-click-overlay');
            const closeMapBtn = document.getElementById('close-map-btn');

            mapOverlay.addEventListener('click', function() {
                mapWrapper.classList.remove('relative', 'h-64', 'sm:h-72', 'rounded-lg', 'border', 'border-gray-300', 'dark:border-gray-700');
                mapWrapper.classList.add('fixed', 'inset-0', 'z-[9999]', 'h-screen', 'w-screen', 'bg-gray-900');
                
                mapOverlay.classList.add('hidden');
                closeMapBtn.classList.remove('hidden');
                
                map.scrollWheelZoom.enable();

                setTimeout(() => map.invalidateSize(), 300);
            });

            closeMapBtn.addEventListener('click', function() {
                mapWrapper.classList.remove('fixed', 'inset-0', 'z-[9999]', 'h-screen', 'w-screen', 'bg-gray-900');
                mapWrapper.classList.add('relative', 'h-64', 'sm:h-72', 'rounded-lg', 'border', 'border-gray-300', 'dark:border-gray-700');
                
                mapOverlay.classList.remove('hidden');
                closeMapBtn.classList.add('hidden');

                map.scrollWheelZoom.disable();

                setTimeout(() => map.invalidateSize(), 300);
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        });
    </script>
</x-app-layout>