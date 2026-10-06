<x-app-layout>

    <x-slot name="header">
        <div class="flex items-center justify-between">

            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Detail Kegiatan
            </h2>

            <a href="{{ route('kegiatan.index') }}"
               class="px-4 py-2 bg-gray-800 text-white rounded-md">
                Kembali
            </a>

        </div>
    </x-slot>


    <div class="py-8">

        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <div class="space-y-4">


                    <div>
                        <h3 class="text-sm text-gray-500">
                            Judul Kegiatan
                        </h3>

                        <p class="text-lg font-semibold">
                            {{ $kegiatan->judul }}
                        </p>
                    </div>



                    <div>
                        <h3 class="text-sm text-gray-500">
                            Jenis
                        </h3>

                        <p>
                            {{ $kegiatan->jenis }}
                        </p>
                    </div>



                    <div>
                        <h3 class="text-sm text-gray-500">
                            Deskripsi
                        </h3>

                        <p>
                            {{ $kegiatan->deskripsi ?? '-' }}
                        </p>
                    </div>



                    <div>
                        <h3 class="text-sm text-gray-500">
                            Target Peserta
                        </h3>

                        <p>
                            {{ $kegiatan->target_peserta ?? '-' }}
                        </p>
                    </div>



                    <div>
                        <h3 class="text-sm text-gray-500">
                            Foto
                        </h3>

                        <p>
                            {{ $kegiatan->foto ?? '-' }}
                        </p>
                    </div>



                    <div>
                        <h3 class="text-sm text-gray-500">
                            Status
                        </h3>

                        @if($kegiatan->status == 'aktif')

                            <span class="px-2 py-1 text-xs rounded bg-green-100 text-green-700">
                                Aktif
                            </span>

                        @else

                            <span class="px-2 py-1 text-xs rounded bg-gray-100 text-gray-700">
                                Nonaktif
                            </span>

                        @endif

                    </div>


                </div>

            </div>

        </div>

    </div>

</x-app-layout>