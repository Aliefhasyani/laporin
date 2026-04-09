<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pelaporan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">
            
            @if (session('success'))
                <div class="bg-emerald-50 dark:bg-emerald-900/30 border-l-4 border-emerald-500 p-4 rounded-md shadow-sm">
                    <p class="text-sm text-emerald-800 dark:text-emerald-200">{{ session('success') }}</p>
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-rose-50 dark:bg-rose-900/30 border-l-4 border-rose-500 p-4 rounded-md shadow-sm">
                    <h3 class="text-sm font-bold text-rose-800 dark:text-rose-200 mb-1">Terjadi masalah!</h3>
                    <ul class="list-disc list-inside text-xs text-rose-700 dark:text-rose-300">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-6 text-gray-600 dark:text-gray-400 flex items-center space-x-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <span class="text-sm">{{ __("Lengkapi formulir di bawah untuk mengirimkan laporan kondisi jalanan.") }}</span>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-md sm:rounded-lg border border-gray-100 dark:border-gray-700">
                <div class="p-8">
                    <form action="{{ route('laporan') }}" method="POST" enctype="multipart/form-data" class="space-y-8"> 
                        @csrf 
                        
                        <div class="group">
                            <label for="nama_jalanan" class="block text-sm font-semibold text-gray-700 dark:text-gray-300 mb-2 group-focus-within:text-indigo-500 transition-colors">
                                Nama Jalanan
                            </label>
                            <input type="text" name="nama_jalanan" id="nama_jalanan" 
                                class="block w-full rounded-lg border-gray-300 dark:border-gray-700 dark:bg-gray-900 dark:text-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm transition-all duration-200" 
                                placeholder="Contoh: Jl. Sudirman No. 12"
                                value="{{ old('nama_jalanan') }}">
                        </div>

                        <div>
                            <label for="path_foto_jalanan" class="block text-sm font-medium text-gray-700 dark:text-gray-300 mb-1">Foto Jalanan</label>
                            <input type="file" name="path_foto_jalanan" id="path_foto_jalanan" 
                                class="block w-full text-sm text-gray-500 dark:text-gray-400 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100 dark:file:bg-gray-700 dark:file:text-gray-300 dark:hover:file:bg-gray-600 cursor-pointer transition duration-150">
                        </div>

                        <div>
                            <div class="flex items-center justify-between mb-2">
                                <label class="block text-sm font-semibold text-gray-700 dark:text-gray-300">Tandai Lokasi Kejadian</label>
                                <span class="text-[10px] uppercase tracking-widest text-gray-400 font-bold">Wajib diisi</span>
                            </div>
                            
                            <div id="map-wrapper" class="relative w-full h-72 rounded-xl shadow-inner border-2 border-gray-100 dark:border-gray-700 overflow-hidden group transition-all duration-500">
                                
                                <div id="map-click-overlay" class="absolute inset-0 z-[500] cursor-pointer bg-gray-900/10 backdrop-blur-[1px] hover:backdrop-blur-0 flex items-center justify-center transition-all">
                                    <div class="bg-white/90 dark:bg-gray-800/90 text-indigo-600 dark:text-indigo-400 px-6 py-3 rounded-xl text-sm font-bold shadow-xl flex items-center space-x-3 border border-white dark:border-gray-700">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 animate-bounce" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        <span>Ketuk untuk Pilih Lokasi</span>
                                    </div>
                                </div>

                                <div id="map" class="w-full h-full z-10"></div>
                                
                                <button type="button" id="close-map-btn" class="hidden absolute top-6 right-6 z-[1000] bg-white dark:bg-gray-900 text-gray-800 dark:text-white px-5 py-2.5 rounded-full shadow-2xl hover:scale-105 active:scale-95 focus:outline-none flex items-center space-x-2 transition-all font-bold text-xs uppercase tracking-wider border border-gray-200 dark:border-gray-700">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                        <path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                    <span>Simpan Lokasi</span>
                                </button>
                            </div>
                            
                            <input type="hidden" name="latitude" id="latitude_input">
                            <input type="hidden" name="longitude" id="longitude_input">
                        </div>

                        <div class="flex items-center justify-end pt-6 border-t border-gray-100 dark:border-gray-700">
                            <button type="submit" 
                                class="w-full sm:w-auto inline-flex items-center justify-center px-8 py-3 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl font-bold text-sm uppercase tracking-widest shadow-lg shadow-indigo-500/30 transition-all active:scale-95 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 dark:focus:ring-offset-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                                </svg>
                                Kirim Laporan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            
            const fileInput = document.getElementById('path_foto_jalanan');
            const previewContainer = document.getElementById('image-preview-container');
            const imagePreview = document.getElementById('image-preview');

            fileInput.addEventListener('change', function() {
                const file = this.files[0];
                
                if (file) {
                    const reader = new FileReader();
                    
                    reader.onload = function(e) {
                        imagePreview.src = e.target.result;
                        previewContainer.classList.remove('hidden');
                    }
                    
                    reader.readAsDataURL(file);
                } else {
                    imagePreview.src = "";
                    previewContainer.classList.add('hidden');
                }
            });
            // ---------------------------

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
                // Switch to Fullscreen mode
                mapWrapper.classList.remove('relative', 'h-72', 'rounded-xl', 'border-2');
                mapWrapper.classList.add('fixed', 'inset-0', 'z-[9999]', 'w-full', 'h-full');
                
                mapOverlay.classList.add('hidden');
                closeMapBtn.classList.remove('hidden');
                
                map.scrollWheelZoom.enable();

                setTimeout(() => {
                    map.invalidateSize();
                }, 550); 
            });

            closeMapBtn.addEventListener('click', function() {
                mapWrapper.classList.remove('fixed', 'inset-0', 'z-[9999]', 'w-full', 'h-full');
                mapWrapper.classList.add('relative', 'h-72', 'rounded-xl', 'border-2');
                
                mapOverlay.classList.remove('hidden');
                closeMapBtn.classList.add('hidden');

                map.scrollWheelZoom.disable();

                setTimeout(() => {
                    map.invalidateSize();
                }, 550); 
            });

            setTimeout(function() {
                map.invalidateSize();
            }, 100);
        });
    </script>
</x-app-layout>