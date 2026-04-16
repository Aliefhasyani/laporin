<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Officer Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg mb-6">
                <div class="p-6 text-gray-900 dark:text-gray-100">
                    {{ __("You're logged in as Officer!") }}
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 overflow-x-auto">
                    <table class="w-full text-sm text-left text-gray-500 dark:text-gray-400 border-collapse">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-100 dark:bg-gray-700 dark:text-gray-300">
                            <tr>
                                <th scope="col" class="px-6 py-4 font-semibold border-b dark:border-gray-600">Nama Jalanan</th>
                                <th scope="col" class="px-6 py-4 font-semibold border-b dark:border-gray-600">Status</th>
                                <th scope="col" class="px-6 py-4 font-semibold border-b dark:border-gray-600">Latitude</th>
                                <th scope="col" class="px-6 py-4 font-semibold border-b dark:border-gray-600">Longitude</th>
                                <th scope="col" class="px-6 py-4 font-semibold border-b dark:border-gray-600">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($reports as $report)
                                <tr class="bg-white dark:bg-gray-800 hover:bg-gray-50 dark:hover:bg-gray-700 border-b dark:border-gray-700 transition duration-150 ease-in-out">
                                    <td class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                        {{ $report->nama_jalanan }}
                                    </td>
                                    @if ($report->status == 'pending')
                                        <td class="px-6 py-4 text-red-500">
                                            {{ $report->status }}
                                        </td>
                                    @elseif ($report->status == 'in_progress')
                                        <td class="px-6 py-4 text-yellow-500">
                                            {{ $report->status }}
                                        </td>
                                    @elseif ($report->status == 'in_review')
                                        <td class="px-6 py-4 text-green-800">
                                            {{ $report->status }}
                                        </td>
                                    @elseif ($report->status == 'selesai')
                                        <td class="px-6 py-4 text-green-400">
                                            {{ $report->status }}
                                        </td>
                                    @endif
                                    <td class="px-6 py-4">
                                        {{ $report->latitude }}
                                    </td>
                                    <td class="px-6 py-4">
                                        {{ $report->longitude }}
                                    </td>
                                    <td class="px-6 py-4">
                                        <a href="{{ route('officer.show-laporan',$report->id) }}"
                                            class="font-medium text-blue-600 dark:text-blue-500 hover:underline">
                                            Lihat Laporan
                                        </a>
                                        <form action="{{ route('officer.destroy-laporan',$report->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:underline">Hapus Laporan</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>