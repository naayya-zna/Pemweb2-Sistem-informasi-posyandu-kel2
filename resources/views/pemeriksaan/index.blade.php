```blade
<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Data Pemeriksaan
            </h2>

            <a href="{{ route('pemeriksaan.create') }}"
               class="px-4 py-2 bg-indigo-600 text-white text-sm rounded-md hover:bg-indigo-700">
                + Tambah Pemeriksaan
            </a>
        </div>
    </x-slot>


    <div class="py-8">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Alert --}}
            @if(session('success'))
                <div class="mb-4 p-3 bg-green-100 text-green-700 rounded">
                    {{ session('success') }}
                </div>
            @endif


            {{-- Filter --}}
            <div class="bg-white shadow-sm sm:rounded-lg mb-6">
                <div class="p-6">

                    <form method="GET"
                          action="{{ route('pemeriksaan.index') }}">

                        <div class="grid grid-cols-1 md:grid-cols-12 gap-4">

                            <div class="md:col-span-6">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Cari Warga
                                </label>

                                <input type="text"
                                       name="search"
                                       class="w-full border-gray-300 rounded-md shadow-sm"
                                       placeholder="Nama atau NIK..."
                                       value="{{ request('search') }}">
                            </div>


                            <div class="md:col-span-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Tanggal
                                </label>

                                <input type="date"
                                       name="tanggal"
                                       class="w-full border-gray-300 rounded-md shadow-sm"
                                       value="{{ request('tanggal') }}">
                            </div>


                            <div class="md:col-span-2 flex items-end">

                                <button type="submit"
                                        class="w-full px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">
                                    Cari
                                </button>

                            </div>

                        </div>

                    </form>

                </div>
            </div>


            {{-- Table --}}
            <div class="bg-white shadow-sm sm:rounded-lg overflow-x-auto">

                <div class="p-6">

                    <table class="min-w-full divide-y divide-gray-200 text-sm">

                        <thead class="bg-gray-50 text-left text-gray-600">

                            <tr>
                                <th class="px-4 py-3">No</th>
                                <th class="px-4 py-3">Warga</th>
                                <th class="px-4 py-3">Jadwal</th>
                                <th class="px-4 py-3">Tanggal</th>
                                <th class="px-4 py-3">Berat</th>
                                <th class="px-4 py-3">Tinggi</th>
                                <th class="px-4 py-3">Tekanan Darah</th>
                                <th class="px-4 py-3">Status Gizi</th>
                                <th class="px-4 py-3">Pemeriksa</th>
                                <th class="px-4 py-3 text-right">Aksi</th>
                            </tr>

                        </thead>


                        <tbody class="divide-y divide-gray-100">

                        @forelse($pemeriksaans as $pemeriksaan)

                            <tr>

                                <td class="px-4 py-3">
                                    {{ $pemeriksaans->firstItem() + $loop->index }}
                                </td>


                                <td class="px-4 py-3">

                                    <strong>
                                        {{ $pemeriksaan->warga?->nama ?? '-' }}
                                    </strong>

                                    <br>

                                    <small class="text-gray-500">
                                        NIK:
                                        {{ $pemeriksaan->warga?->nik ?? '-' }}
                                    </small>

                                </td>


                                <td class="px-4 py-3">
                                    {{ $pemeriksaan->jadwal?->lokasi ?? '-' }}
                                </td>


                                <td class="px-4 py-3">
                                    {{ $pemeriksaan->tanggal?->format('d/m/Y') ?? '-' }}
                                </td>


                                <td class="px-4 py-3">
                                    {{ $pemeriksaan->berat_badan ?? '-' }} kg
                                </td>


                                <td class="px-4 py-3">
                                    {{ $pemeriksaan->tinggi_badan ?? '-' }} cm
                                </td>


                                <td class="px-4 py-3">
                                    {{ $pemeriksaan->tekanan_darah ?? '-' }}
                                </td>


                                <td class="px-4 py-3">

                                    @if($pemeriksaan->status_gizi)

                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded bg-blue-100 text-blue-700">
                                            {{ $pemeriksaan->status_gizi }}
                                        </span>

                                    @else

                                        -

                                    @endif

                                </td>


                                <td class="px-4 py-3">
                                    {{ $pemeriksaan->pemeriksa?->name ?? '-' }}
                                </td>


                                <td class="px-4 py-3 text-right whitespace-nowrap">

                                    <a href="{{ route('pemeriksaan.show', $pemeriksaan) }}"
                                       class="inline-block px-3 py-1 bg-blue-500 text-white text-xs rounded hover:bg-blue-600">
                                        Detail
                                    </a>


                                    <a href="{{ route('pemeriksaan.edit', $pemeriksaan) }}"
                                       class="inline-block ml-1 px-3 py-1 bg-yellow-500 text-white text-xs rounded hover:bg-yellow-600">
                                        Edit
                                    </a>


                                    <form action="{{ route('pemeriksaan.destroy', $pemeriksaan) }}"
                                          method="POST"
                                          class="inline"
                                          onsubmit="return confirm('Yakin ingin menghapus data ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="ml-1 px-3 py-1 bg-red-600 text-white text-xs rounded hover:bg-red-700">
                                            Hapus
                                        </button>

                                    </form>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="10"
                                    class="px-4 py-8 text-center text-gray-500">

                                    Belum ada data pemeriksaan.

                                </td>

                            </tr>

                        @endforelse

                        </tbody>

                    </table>

                </div>

            </div>


            {{-- Pagination --}}
            <div class="mt-4">
                {{ $pemeriksaans->links() }}
            </div>

        </div>
    </div>

</x-app-layout>
```
