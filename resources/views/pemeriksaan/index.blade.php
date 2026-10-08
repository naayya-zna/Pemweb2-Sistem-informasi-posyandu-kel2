<x-layouts.panel title="Pemeriksaan">

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
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#051F20]">Data Pemeriksaan</h1>
            <p class="mt-1 text-sm text-[#3C5A52]">Hasil pemeriksaan kesehatan warga pada setiap jadwal kegiatan.</p>
        </div>
        <a href="{{ route('pemeriksaan.create') }}" class="btn-primary shrink-0">
            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>
            Tambah Pemeriksaan
        </a>
    </div>

    {{-- Ringkasan Metric Cards --}}
    <div class="mb-6 grid grid-cols-2 gap-3.5 lg:grid-cols-4">
        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-[#0B2B26]"></span>
                <p class="text-xs font-semibold text-[#55766A]">Total Pemeriksaan</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['total'] ?? 0 }}</p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-[#235347]"></span>
                <p class="text-xs font-semibold text-[#55766A]">Bulan Ini</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['bulan_ini'] ?? 0 }}</p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                <p class="text-xs font-semibold text-[#55766A]">Gizi Baik / Normal</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['normal'] ?? 0 }}</p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-amber-500"></span>
                <p class="text-xs font-semibold text-[#55766A]">Perlu Perhatian</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">{{ $stats['perlu_perhatian'] ?? 0 }}</p>
        </div>
    </div>

    {{-- Filter Bar --}}
    <div class="mb-6 rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('pemeriksaan.index') }}" class="grid gap-3 md:grid-cols-12">
            <div class="md:col-span-5">
                <label class="mb-1 block text-xs font-bold text-[#051F20]">Cari warga</label>
                <div class="relative">
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Nama atau NIK..." class="input-field pl-9">
                    <svg class="pointer-events-none absolute left-3 top-3 h-4 w-4 text-[#7FA08C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>
            </div>

            <div class="md:col-span-4">
                <label class="mb-1 block text-xs font-bold text-[#051F20]">Tanggal Pemeriksaan</label>
                <input type="date" name="tanggal" value="{{ request('tanggal') }}" class="input-field">
            </div>

            <div class="flex items-end gap-2 md:col-span-3">
                <button type="submit" class="btn-primary flex-1 justify-center py-2.5">Filter</button>
                @if(request('search') || request('tanggal'))
                    <a href="{{ route('pemeriksaan.index') }}" class="btn-secondary py-2.5 px-3 text-center">Reset</a>
                @endif
            </div>
        </form>
    </div>

    {{-- Tabel Desktop / Tablet --}}
    <div class="block overflow-hidden rounded-2xl border border-[#DAF1DE] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-[#DAF1DE]/50 text-left text-xs font-bold uppercase tracking-wider text-[#051F20]">
                    <tr>
                        <th class="px-4 py-3.5">No</th>
                        <th class="px-4 py-3.5">Warga</th>
                        <th class="px-4 py-3.5">Jadwal</th>
                        <th class="px-4 py-3.5">Tanggal</th>
                        <th class="px-4 py-3.5 text-right">Berat</th>
                        <th class="px-4 py-3.5 text-right">Tinggi</th>
                        <th class="px-4 py-3.5">Tekanan Darah</th>
                        <th class="px-4 py-3.5">Status Gizi</th>
                        <th class="px-4 py-3.5">Pemeriksa</th>
                        <th class="px-4 py-3.5 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($pemeriksaans as $index => $item)
                        @php
                            $giziLower = strtolower($item->status_gizi ?? '');
                            $giziBadge = 'bg-slate-100 text-slate-700 border-slate-200';
                            if (preg_match('/baik|normal|ideal/i', $giziLower)) {
                                $giziBadge = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                            } elseif (preg_match('/kurang|stunting|obesitas|sangat|risiko/i', $giziLower)) {
                                $giziBadge = 'bg-rose-50 text-rose-800 border-rose-200';
                            }
                        @endphp
                        <tr class="transition hover:bg-[#DAF1DE]/20">
                            <td class="px-4 py-3.5 tabular-nums text-[#55766A] font-semibold">
                                {{ $pemeriksaans->firstItem() + $index }}
                            </td>
                            <td class="px-4 py-3.5">
                                <p class="font-bold text-[#051F20]">{{ $item->warga?->nama ?? '-' }}</p>
                                <p class="text-xs font-mono text-[#55766A]">{{ $item->warga?->nik ?? '-' }}</p>
                            </td>
                            <td class="px-4 py-3.5 text-[#163832] font-medium">
                                {{ $item->jadwal?->kegiatan?->judul ?? $item->jadwal?->nama ?? 'Jadwal #'.$item->jadwal_id }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-[#163832] font-medium">
                                {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') : '-' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-right tabular-nums font-bold text-[#051F20]">
                                {{ $item->berat_badan ? $item->berat_badan . ' kg' : '-' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 text-right tabular-nums font-bold text-[#051F20]">
                                {{ $item->tinggi_badan ? $item->tinggi_badan . ' cm' : '-' }}
                            </td>
                            <td class="whitespace-nowrap px-4 py-3.5 tabular-nums font-medium text-[#163832]">
                                {{ $item->tekanan_darah ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5">
                                <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-bold border {{ $giziBadge }}">
                                    {{ $item->status_gizi ?? '-' }}
                                </span>
                            </td>
                            <td class="px-4 py-3.5 text-[#163832] font-medium">
                                {{ $item->pemeriksa?->name ?? '-' }}
                            </td>
                            <td class="px-4 py-3.5 whitespace-nowrap text-right">
                                <div class="flex justify-end gap-1.5">
                                    <a href="{{ route('pemeriksaan.show', $item) }}" class="btn-ghost text-xs px-2.5 py-1">Detail</a>
                                    <a href="{{ route('pemeriksaan.edit', $item) }}" class="btn-ghost text-xs px-2.5 py-1">Edit</a>
                                    <form action="{{ route('pemeriksaan.destroy', $item) }}" method="POST" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button onclick="return confirm('Hapus data pemeriksaan ini?')" class="btn-danger text-xs px-2.5 py-1">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="10" class="px-6 py-12 text-center text-[#55766A] font-medium">
                                Belum ada data pemeriksaan.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{-- Kartu Mobile (Smartphone) --}}
    <div class="space-y-3.5 md:hidden">
        @forelse ($pemeriksaans as $item)
            @php
                $giziLower = strtolower($item->status_gizi ?? '');
                $giziBadge = 'bg-slate-100 text-slate-700 border-slate-200';
                if (preg_match('/baik|normal|ideal/i', $giziLower)) {
                    $giziBadge = 'bg-emerald-50 text-emerald-800 border-emerald-200';
                } elseif (preg_match('/kurang|stunting|obesitas|sangat|risiko/i', $giziLower)) {
                    $giziBadge = 'bg-rose-50 text-rose-800 border-rose-200';
                }
            @endphp
            <article class="card-panel flex flex-col gap-3">
                <div class="flex items-start justify-between gap-3">
                    <div class="min-w-0">
                        <p class="truncate font-bold text-[#051F20] text-base">{{ $item->warga?->nama ?? '-' }}</p>
                        <p class="text-xs font-mono text-[#55766A]">NIK: {{ $item->warga?->nik ?? '-' }}</p>
                    </div>
                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-bold border {{ $giziBadge }}">
                        {{ $item->status_gizi ?? '-' }}
                    </span>
                </div>

                <p class="text-xs font-semibold text-[#163832]">
                    {{ $item->jadwal?->kegiatan?->judul ?? $item->jadwal?->nama ?? 'Jadwal' }} · 
                    {{ $item->tanggal ? \Carbon\Carbon::parse($item->tanggal)->translatedFormat('d M Y') : '-' }}
                </p>

                <dl class="grid grid-cols-3 gap-2 rounded-xl bg-[#DAF1DE]/40 p-3 text-center border border-[#DAF1DE]">
                    <div>
                        <dt class="text-xs text-[#55766A]">Berat</dt>
                        <dd class="text-sm font-bold tabular-nums text-[#051F20]">{{ $item->berat_badan ? $item->berat_badan . ' kg' : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#55766A]">Tinggi</dt>
                        <dd class="text-sm font-bold tabular-nums text-[#051F20]">{{ $item->tinggi_badan ? $item->tinggi_badan . ' cm' : '-' }}</dd>
                    </div>
                    <div>
                        <dt class="text-xs text-[#55766A]">Tensi</dt>
                        <dd class="text-sm font-bold tabular-nums text-[#051F20]">{{ $item->tekanan_darah ?? '-' }}</dd>
                    </div>
                </dl>

                <div class="mt-1 flex items-center justify-between gap-2 pt-2 border-t border-[#DAF1DE]">
                    <p class="truncate text-xs text-[#55766A]">Pemeriksa: {{ $item->pemeriksa?->name ?? '-' }}</p>
                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('pemeriksaan.show', $item) }}" class="btn-ghost text-xs px-2.5 py-1">Detail</a>
                        <a href="{{ route('pemeriksaan.edit', $item) }}" class="btn-ghost text-xs px-2.5 py-1">Edit</a>
                        <form action="{{ route('pemeriksaan.destroy', $item) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button onclick="return confirm('Hapus data pemeriksaan ini?')" class="btn-danger text-xs px-2.5 py-1">Hapus</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-12 text-center">
                <p class="text-base font-medium text-slate-700">Belum ada data pemeriksaan</p>
                <p class="mt-1 text-sm text-slate-500">Data muncul setelah kader mencatat pemeriksaan pada sebuah jadwal.</p>
            </div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="mt-6">
        {{ $pemeriksaans->links() }}
    </div>
</div>

</x-layouts.panel>