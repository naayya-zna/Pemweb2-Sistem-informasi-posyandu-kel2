<x-layouts.panel title="Warga">

<div>
    {{-- Alert sukses --}}
    @if (session('success'))
        <div class="mb-6 flex items-center justify-between rounded-xl border border-[#8EB69B] bg-[#DAF1DE] px-4 py-3 text-sm font-semibold text-[#051F20] shadow-2xs">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-[#163832] hover:text-[#051F20]">&times;</button>
        </div>
    @endif

    {{-- Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#051F20]">Data Warga</h1>
            <p class="mt-1 text-sm text-[#3C5A52]">Kelola data dan profil pendaftaran warga Posyandu.</p>
        </div>

        <a href="{{ route('warga.create') }}" class="btn-primary">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Warga
        </a>
    </div>

    {{-- Ringkasan Metric Cards --}}
    <div class="mb-6 grid grid-cols-2 gap-3.5 lg:grid-cols-4">
        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-[#0B2B26]"></span>
                <p class="text-xs font-semibold text-[#55766A]">Total Warga</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['total'] ?? 0 }}</p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-[#235347]"></span>
                <p class="text-xs font-semibold text-[#55766A]">Balita</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['balita'] ?? 0 }}</p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                <p class="text-xs font-semibold text-[#55766A]">Ibu Hamil</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['ibu_hamil'] ?? 0 }}</p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-[#8EB69B]"></span>
                <p class="text-xs font-semibold text-[#55766A]">Lansia</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['lansia'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Search and Chips Filter --}}
    <div class="mb-6 space-y-3.5 rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('warga.index') }}" class="space-y-3.5">
            <div class="flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Cari nama atau NIK warga..."
                        class="input-field pl-10"
                    >
                    <svg class="pointer-events-none absolute left-3.5 top-3 h-4 w-4 text-[#7FA08C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
                <button type="submit" class="btn-primary shrink-0 sm:w-auto">Cari</button>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-1 pt-1">
                <a href="{{ route('warga.index', array_merge(request()->except('kategori'), [])) }}"
                   class="chip-filter {{ !request('kategori') ? 'chip-active' : 'chip-idle' }}">
                    Semua
                </a>
                @foreach ($kategoris as $key => $label)
                    <a href="{{ route('warga.index', array_merge(request()->except('kategori'), ['kategori' => $key])) }}"
                       class="chip-filter {{ request('kategori') == $key ? 'chip-active' : 'chip-idle' }}">
                        {{ $label }}
                    </a>
                @endforeach

                @if(request('search') || request('kategori'))
                    <a href="{{ route('warga.index') }}" class="ml-auto whitespace-nowrap text-sm font-semibold text-[#163832] underline hover:text-[#051F20]">
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    {{-- Desktop & Tablet Table --}}
    <div class="block overflow-hidden rounded-2xl border border-[#DAF1DE] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-[#DAF1DE]/50 text-left text-xs font-bold uppercase tracking-wider text-[#051F20]">
                    <tr>
                        <th class="px-5 py-4">NIK</th>
                        <th class="px-5 py-4">Nama Warga</th>
                        <th class="px-5 py-4">Usia / JK</th>
                        <th class="px-5 py-4">Kategori</th>
                        <th class="px-5 py-4">RT/RW</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                @forelse ($wargas as $warga)
                    <tr class="transition hover:bg-[#DAF1DE]/20">
                        <td class="px-5 py-4 font-mono text-xs font-semibold text-[#163832]">
                            {{ $warga->nik }}
                        </td>

                        <td class="px-5 py-4">
                            <p class="font-bold text-[#051F20]">{{ $warga->nama }}</p>
                            <p class="mt-0.5 text-xs text-[#55766A]">{{ $warga->nama_wali ? 'Wali: '.$warga->nama_wali : '-' }}</p>
                        </td>

                        <td class="px-5 py-4 font-medium text-[#163832]">
                            {{ $warga->umur }} th
                            <span class="text-xs text-[#7FA08C]">/ {{ $warga->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</span>
                        </td>

                        <td class="px-5 py-4">
                            <span class="badge-mint">
                                {{ $warga->kategori == 'ibu_hamil' ? 'Ibu Hamil' : ucfirst($warga->kategori) }}
                            </span>
                        </td>

                        <td class="px-5 py-4 text-[#163832] font-medium">
                            {{ $warga->rt_rw }}
                        </td>

                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('warga.show', $warga) }}" class="btn-ghost">
                                    Detail
                                </a>

                                <a href="{{ route('warga.edit', $warga) }}" class="btn-ghost">
                                    Edit
                                </a>

                                <form action="{{ route('warga.destroy', $warga) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button onclick="return confirm('Hapus data warga ini?')" class="btn-danger">
                                        Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="px-5 py-12 text-center text-[#55766A] font-medium">
                            Belum ada data warga.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Smartphone Mobile Cards View --}}
    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse ($wargas as $warga)
            <div class="card-panel flex flex-col gap-3">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <h3 class="font-bold text-[#051F20] text-base">{{ $warga->nama }}</h3>
                        <p class="font-mono text-xs text-[#55766A]">NIK: {{ $warga->nik }}</p>
                    </div>
                    <span class="badge-mint shrink-0">
                        {{ $warga->kategori == 'ibu_hamil' ? 'Ibu Hamil' : ucfirst($warga->kategori) }}
                    </span>
                </div>

                <div class="grid grid-cols-2 gap-2 text-xs text-[#163832] border-t border-b border-[#DAF1DE] py-2.5">
                    <div>
                        <span class="text-[#7FA08C] block font-medium">Usia & JK</span>
                        <span class="font-bold text-[#051F20]">{{ $warga->umur }} th ({{ $warga->jenis_kelamin }})</span>
                    </div>
                    <div>
                        <span class="text-[#7FA08C] block font-medium">RT/RW</span>
                        <span class="font-bold text-[#051F20]">{{ $warga->rt_rw }}</span>
                    </div>
                    @if($warga->nama_wali)
                        <div class="col-span-2">
                            <span class="text-[#7FA08C] block font-medium">Nama Wali</span>
                            <span class="font-semibold text-[#051F20]">{{ $warga->nama_wali }}</span>
                        </div>
                    @endif
                </div>

                <div class="flex items-center justify-end gap-2 pt-1">
                    <a href="{{ route('warga.show', $warga) }}" class="btn-ghost flex-1 text-center justify-center">Detail</a>
                    <a href="{{ route('warga.edit', $warga) }}" class="btn-ghost flex-1 text-center justify-center">Edit</a>
                    <form action="{{ route('warga.destroy', $warga) }}" method="POST" class="inline flex-1">
                        @csrf
                        @method('DELETE')
                        <button onclick="return confirm('Hapus data warga ini?')" class="btn-danger w-full justify-center">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="card-panel p-8 text-center text-[#55766A]">
                Belum ada data warga.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $wargas->links() }}
    </div>
</div>

</x-layouts.panel>