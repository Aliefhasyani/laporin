<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Detail Laporan') }}
            </h2>
      
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-2xl border border-gray-100 dark:border-gray-700">
                
                <div class="p-6 sm:p-8 flex flex-col lg:flex-row gap-8 lg:gap-12">
                    
                    <div class="w-full lg:w-1/2">
                        <div class="relative rounded-xl overflow-hidden shadow-lg border border-gray-200 dark:border-gray-700 bg-gray-100 dark:bg-gray-900 group">
                            @if($laporan->path_foto_jalanan)
                                <img src="{{ asset('storage/'.$laporan->path_foto_jalanan) }}" 
                                     alt="Foto {{ $laporan->nama_jalanan }}" 
                                     class="w-full h-auto aspect-video sm:aspect-square object-cover transition-transform duration-500 group-hover:scale-105">
                            @else
                                <div class="w-full aspect-video sm:aspect-square flex items-center justify-center text-gray-400">
                                    <span>Tidak ada foto</span>
                                </div>
                            @endif
                        </div>
                    </div>

                    <div class="w-full lg:w-1/2 flex flex-col justify-start space-y-8">
                        
                        <div>
                            <h3 class="text-sm font-bold text-indigo-600 dark:text-indigo-400 uppercase tracking-wider mb-2">Informasi Jalan</h3>
                            <h1 class="text-3xl font-extrabold text-gray-900 dark:text-white mb-2">
                                {{ $laporan->nama_jalanan }}
                            </h1>
                            <div class="flex items-center space-x-2 text-sm text-gray-500 dark:text-gray-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                <span>Dilaporkan oleh: <span class="font-semibold text-gray-700 dark:text-gray-300">{{ $laporan->user->name }}</span></span>
                                @if ($laporan->status == 'pending')
                                        <p class="text-red-500">
                                            <span class="text-black"> Status Laporan :</span> {{ $laporan->status }}
                                        </p>
                                    @elseif ($laporan->status == 'in_progress')
                                        <p class="text-yellow-500">
                                            <span class="text-black"> Status Laporan :</span> {{ $laporan->status }}
                                        </p>
                                    @elseif ($laporan->status == 'in_review')
                                        <p class="text-green-800">
                                            <span class="text-black"> Status Laporan :</span> {{ $laporan->status }}
                                        </p>
                                    @elseif ($laporan->status == 'selesai')
                                        <p class="text-green-400">
                                            <span class="text-black"> Status Laporan :</span> {{ $laporan->status }}
                                        </p>
                                    @endif
                            </div>
                        </div>

                        <hr class="border-gray-200 dark:border-gray-700">

                        <div class="bg-gray-50 dark:bg-gray-900/50 rounded-xl p-6 border border-gray-100 dark:border-gray-700">
                            <h3 class="text-sm font-bold text-gray-900 dark:text-white mb-4 flex items-center space-x-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span>Titik Koordinat</span>
                            </h3>
                            
                            <div class="grid grid-cols-2 gap-4 mb-5">
                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                                    <span class="block text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Latitude</span>
                                    <span class="block font-mono font-medium text-gray-900 dark:text-gray-200">{{ $laporan->latitude }}</span>
                                </div>
                                <div class="bg-white dark:bg-gray-800 p-3 rounded-lg shadow-sm border border-gray-100 dark:border-gray-700">
                                    <span class="block text-[11px] uppercase tracking-wider text-gray-500 dark:text-gray-400 mb-1">Longitude</span>
                                    <span class="block font-mono font-medium text-gray-900 dark:text-gray-200">{{ $laporan->longitude }}</span>
                                </div>
                            </div>

                            <a href="https://www.google.com/maps/search/?api=1&query={{ $laporan->latitude }},{{ $laporan->longitude }}" 
                               target="_blank" 
                               class="w-full inline-flex justify-center items-center px-4 py-3 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-bold text-sm shadow-md transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" viewBox="0 0 24 24" fill="currentColor">
                                    <path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zm0 9.5c-1.38 0-2.5-1.12-2.5-2.5s1.12-2.5 2.5-2.5 2.5 1.12 2.5 2.5-1.12 2.5-2.5 2.5z"/>
                                </svg>
                                Buka di Google Maps
                            </a>
                        </div>
                        <a href="{{ route('officer.dashboard') }}" class="inline-flex items-center px-4 py-2 bg-white dark:bg-gray-800 border border-gray-300 dark:border-gray-500 rounded-md font-semibold text-xs text-gray-700 dark:text-gray-300 uppercase tracking-widest shadow-sm hover:bg-gray-50 dark:hover:bg-gray-700 focus:outline-none disabled:opacity-25 transition ease-in-out duration-150">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                            </svg>
                            Kembali
                        </a>
                              
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>