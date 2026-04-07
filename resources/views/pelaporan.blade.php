<x-app-layout>

    @if ($errors->any())
    <div class="bg-red-100 text-red-600 p-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
        <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Pelaporan') }}
        </h2>
    </x-slot>
    
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("Anda di halaman pelaporan!") }}
                </div>
            </div>
        </div>
    </div>
    

    <div>
        <form class="flex items-center justify-center" 
            action="{{ route('laporan') }}" 
            method="POST" 
            enctype="multipart/form-data"> @csrf <label>Nama Jalanan : </label> 
            <input type="text" name="nama_jalanan" placeholder="Masukkan nama jalanan">
            
            <input type="file" name="path_foto_jalanan">

            <input type="hidden" name="latitude" id="latitude_input">
            <input type="hidden" name="longitude" id="longitude_input">

            <button type="submit" class="">Submit</button>
        </form>
    </div>
</x-app-layout>