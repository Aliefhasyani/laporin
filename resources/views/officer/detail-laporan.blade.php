<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Laporan') }}
            </h2>
        </div>
    </x-slot>

    <style>
        [x-cloak] { display: none !important; }
    </style>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-6">
                <a href="{{ route('officer.dashboard') }}" class="inline-flex items-center text-sm font-medium text-gray-500 hover:text-gray-700 dark:text-gray-400 dark:hover:text-gray-200 transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                <div class="p-6 sm:p-10 flex flex-col lg:flex-row gap-10">
                    
                    <div class="w-full lg:w-1/2" x-data="{ 
                        isModalOpen: false, 
                        currentImageIndex: 0,
                        images: {{ $laporan->path_foto_jalanan ? json_encode(json_decode($laporan->path_foto_jalanan)) : json_encode([]) }},
                        nextImage() { this.currentImageIndex = (this.currentImageIndex + 1) % this.images.length; },
                        prevImage() { this.currentImageIndex = (this.currentImageIndex - 1 + this.images.length) % this.images.length; }
                    }">
                        @if($laporan->path_foto_jalanan && count(json_decode($laporan->path_foto_jalanan)) > 0)
                            @php $images = json_decode($laporan->path_foto_jalanan); @endphp
                            
                            <div class="relative rounded-2xl overflow-hidden shadow-md border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 group cursor-pointer" @click="isModalOpen = true">
                                <img :src="'{{ asset('storage') }}/' + images[currentImageIndex]" 
                                     :alt="'Foto {{ $laporan->nama_jalanan }} ' + (currentImageIndex + 1)"
                                     class="w-full h-auto aspect-video lg:aspect-[4/3] object-cover transition-transform duration-700 group-hover:scale-105">
                                
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300 flex items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10 text-white opacity-0 group-hover:opacity-100 transition-opacity duration-300 transform scale-50 group-hover:scale-100" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>

                                <div class="absolute bottom-4 right-4 bg-black/70 text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    <span x-text="currentImageIndex + 1"></span> / <span x-text="images.length"></span>
                                </div>

                                <!-- Navigation Arrows on Main Image -->
                                @if(count($images) > 1)
                                    <button @click.stop="prevImage()" class="absolute left-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button @click.stop="nextImage()" class="absolute right-3 top-1/2 -translate-y-1/2 bg-black/50 hover:bg-black/70 text-white p-2 rounded-full transition-all">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @endif
                            </div>

                            <!-- Thumbnails Gallery -->
                            @if(count($images) > 1)
                                <div class="mt-4 flex gap-2 overflow-x-auto pb-2">
                                    <template x-for="(image, index) in images" :key="index">
                                        <button 
                                            @click="currentImageIndex = index"
                                            :class="{'ring-2 ring-indigo-500 ring-offset-2 dark:ring-offset-gray-800': currentImageIndex === index}"
                                            class="flex-shrink-0 w-20 h-20 rounded-lg overflow-hidden border-2 border-gray-200 dark:border-gray-700 hover:border-indigo-500 transition-all">
                                            <img :src="'{{ asset('storage') }}/' + image" 
                                                 class="w-full h-full object-cover"
                                                 :alt="'Thumbnail ' + (index + 1)">
                                        </button>
                                    </template>
                                </div>
                            @endif

                            <!-- Modal for Fullscreen Image -->
                            <div x-show="isModalOpen" 
                                 x-cloak
                                 x-transition:enter="transition ease-out duration-300"
                                 x-transition:enter-start="opacity-0"
                                 x-transition:enter-end="opacity-100"
                                 x-transition:leave="transition ease-in duration-200"
                                 x-transition:leave-start="opacity-100"
                                 x-transition:leave-end="opacity-0"
                                 class="fixed inset-0 z-50 flex items-center justify-center bg-black/90 backdrop-blur-sm p-4 sm:p-6"
                                 @keydown.escape.window="isModalOpen = false">
                                
                                <button @click="isModalOpen = false" class="absolute top-6 right-6 text-gray-300 hover:text-white transition-colors focus:outline-none z-50">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-10 w-10" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                                    </svg>
                                </button>

                                @if(count($images) > 1)
                                    <button @click="prevImage()" class="absolute left-6 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                                        </svg>
                                    </button>
                                    <button @click="nextImage()" class="absolute right-6 top-1/2 -translate-y-1/2 text-white hover:text-gray-300 transition-colors z-50">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </button>
                                @endif

                                <div class="relative w-full max-w-6xl max-h-full flex flex-col justify-center" @click.away="isModalOpen = false">
                                    <img :src="'{{ asset('storage') }}/' + images[currentImageIndex]" 
                                         :alt="'Foto Fullscreen {{ $laporan->nama_jalanan }} ' + (currentImageIndex + 1)"
                                         class="max-w-full max-h-[85vh] object-contain rounded-lg shadow-2xl">
                                    <p class="text-center text-white text-sm mt-4">
                                        <span x-text="currentImageIndex + 1"></span> / <span x-text="images.length"></span>
                                    </p>
                                </div>
                            </div>
                        @else
                            <div class="w-full aspect-video lg:aspect-[4/3] flex flex-col items-center justify-center text-gray-400 rounded-2xl overflow-hidden shadow-md border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>Tidak ada foto tersedia</span>
                            </div>
                        @endif
                    </div>

                    <div class="w-full lg:w-1/2 flex flex-col space-y-6">
                        
                        <div>
                            <div class="flex items-center justify-between mb-3">
                                <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider">Informasi Jalan</h3>
                                
                                @php
                                    $statusColors = [
                                        'pending' => 'bg-red-100 text-red-800 dark:bg-red-900/50 dark:text-red-300 border-red-200 dark:border-red-800',
                                        'in_progress' => 'bg-yellow-100 text-yellow-800 dark:bg-yellow-900/50 dark:text-yellow-300 border-yellow-200 dark:border-yellow-800',
                                        'in_review' => 'bg-blue-100 text-blue-800 dark:bg-blue-900/50 dark:text-blue-300 border-blue-200 dark:border-blue-800',
                                        'selesai' => 'bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300 border-green-200 dark:border-green-800',
                                    ];
                                    $colorClass = $statusColors[$laporan->status] ?? 'bg-gray-100 text-gray-800 border-gray-200';
                                    $statusText = ucwords(str_replace('_', ' ', $laporan->status));
                                @endphp
                                <span class="px-3 py-1 text-xs font-semibold rounded-full border {{ $colorClass }}">
                                    {{ $statusText }}
                                </span>
                            </div>

                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-4">
                                {{ $laporan->nama_jalanan }}
                            </h1>
                            
                            <div class="flex items-center space-x-2 text-sm text-gray-600 dark:text-gray-400">
                                <div class="p-2 bg-gray-100 dark:bg-gray-800 rounded-full">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-500 dark:text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                    </svg>
                                </div>
                                <span>Dilaporkan oleh: <span class="font-semibold text-gray-900 dark:text-gray-200">{{ $laporan->user->name }}</span></span>
                            </div>
                        </div>

                        <hr class="border-gray-200 dark:border-gray-700">

                        <div class="bg-gray-50 dark:bg-gray-800/50 rounded-2xl p-6 border border-gray-200 dark:border-gray-700">
                            <h3 class="text-base font-bold text-gray-900 dark:text-white mb-4 flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Titik Koordinat Lokasi</span>
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-white dark:bg-gray-900 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                                    <span class="block text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1 font-semibold">Latitude</span>
                                    <span class="block font-mono text-sm text-gray-900 dark:text-gray-200 truncate">{{ $laporan->latitude }}</span>
                                </div>
                                <div class="bg-white dark:bg-gray-900 p-4 rounded-xl shadow-sm border border-gray-100 dark:border-gray-700">
                                    <span class="block text-xs uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1 font-semibold">Longitude</span>
                                    <span class="block font-mono text-sm text-gray-900 dark:text-gray-200 truncate">{{ $laporan->longitude }}</span>
                                </div>
                            </div>

                            <a href="https://www.google.com/maps?q={{ $laporan->latitude }},{{ $laporan->longitude }}" 
                               target="_blank" 
                               class="w-full inline-flex justify-center items-center px-4 py-3.5 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white rounded-xl font-bold text-sm shadow-sm transition-all focus:ring-4 focus:ring-blue-500/30">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                Buka di Google Maps
                            </a>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>