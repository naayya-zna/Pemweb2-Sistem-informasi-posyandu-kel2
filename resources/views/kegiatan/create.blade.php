<x-app-layout>

    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Tambah Kegiatan
        </h2>
    </x-slot>


    <div class="py-8">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white shadow-sm rounded-lg p-6">

                <form method="POST" action="{{ route('kegiatan.store') }}">

                    @csrf

                    <div class="space-y-4">

                        <div>
                            <x-input-label value="Judul Kegiatan"/>

                            <x-text-input
                                name="judul"
                                class="mt-1 block w-full"
                                value="{{ old('judul') }}"
                            />

                            <x-input-error :messages="$errors->get('judul')" />
                        </div>


                        <div>
                            <x-input-label value="Jenis Kegiatan"/>

                            <x-text-input
                                name="jenis"
                                class="mt-1 block w-full"
                                value="{{ old('jenis') }}"
                            />

                            <x-input-error :messages="$errors->get('jenis')" />
                        </div>


                        <div>
                            <x-input-label value="Deskripsi"/>

                            <textarea
                                name="deskripsi"
                                class="mt-1 block w-full border-gray-300 rounded-md"
                            >{{ old('deskripsi') }}</textarea>

                        </div>


                        <div>
                            <x-input-label value="Target Peserta"/>

                            <x-text-input
                                name="target_peserta"
                                class="mt-1 block w-full"
                                value="{{ old('target_peserta') }}"
                            />

                        </div>


                        <div>
                            <x-input-label value="Foto"/>

                            <x-text-input
                                name="foto"
                                class="mt-1 block w-full"
                                value="{{ old('foto') }}"
                            />

                        </div>


                        <div>
                            <x-input-label value="Status"/>

                            <select name="status"
                                class="mt-1 block w-full border-gray-300 rounded-md">

                                <option value="aktif">
                                    Aktif
                                </option>

                                <option value="nonaktif">
                                    Nonaktif
                                </option>

                            </select>
                        </div>


                        <div class="flex justify-end">

                            <button
                                class="px-4 py-2 bg-indigo-600 text-white rounded-md">
                                Simpan
                            </button>

                        </div>

                    </div>

                </form>

            </div>

        </div>
    </div>

</x-app-layout>