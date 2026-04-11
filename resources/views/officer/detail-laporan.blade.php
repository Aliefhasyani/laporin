<x-app-layout>

    <div>
        <p>Nama Jalanan: {{ $laporan->nama_jalanan }}</p>
        <p>Foto Jalanan: </p><br>
        <img src="{{ asset('storage/'.$laporan->path_foto_jalanan) }}">
        <p>Latitude: {{ $laporan->latitude }}</p>
        <p>Longitude: {{ $laporan->longitude }}</p>
    </div>

</x-app-layout>
