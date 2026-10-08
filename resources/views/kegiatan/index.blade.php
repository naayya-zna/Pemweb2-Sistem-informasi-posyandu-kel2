<x-layouts.panel title="Kegiatan">
<div
    x-data="{ user: null }"
    x-init="getMe().then(u => user = u).catch(e => console.log('ME ERROR', e))"
>
    @php
        $btn = 'inline-flex items-center justify-center rounded-lg px-3 py-1.5 text-xs font-medium transition';
    @endphp

    @if (session('success'))
        <div class="mb-6 flex items-center justify-between rounded-xl border border-[#8EB69B] bg-[#DAF1DE] px-4 py-3 text-sm font-semibold text-[#051F20] shadow-2xs">
            <span>{{ session('success') }}</span>
            <button onclick="this.parentElement.remove()" class="text-[#163832] hover:text-[#051F20]">&times;</button>
        </div>
    @endif

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
        <div>
            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#051F20]">
                Data Kegiatan
            </h1>
            <p class="mt-1 text-sm text-[#3C5A52]">
                Kelola daftar dan program kegiatan Posyandu.
            </p>
        </div>

        <div x-show="user?.role === 'admin'" x-cloak>
            <a href="{{ route('kegiatan.create') }}" class="btn-primary">
                <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/>
                </svg>
                Tambah Kegiatan
            </a>
        </div>
    </div>

    <div class="mb-6 grid grid-cols-2 gap-3.5 lg:grid-cols-3">
        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-[#0B2B26]"></span>
                <p class="text-xs font-semibold text-[#55766A]">Total Kegiatan</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">
                {{ $stats['total'] ?? 0 }}
            </p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-emerald-500"></span>
                <p class="text-xs font-semibold text-[#55766A]">Aktif</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">
                {{ $stats['aktif'] ?? 0 }}
            </p>
        </div>

        <div class="rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-2xs transition hover:shadow-sm">
            <div class="flex items-center gap-2">
                <span class="h-2.5 w-2.5 rounded-full bg-slate-400"></span>
                <p class="text-xs font-semibold text-[#55766A]">Nonaktif</p>
            </div>
            <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]">
                {{ $stats['nonaktif'] ?? 0 }}
            </p>
        </div>
    </div>

    <div class="mb-6 rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-sm">
        <form method="GET" action="{{ route('kegiatan.index') }}" class="space-y-3.5">
            <div class="flex flex-col gap-3 sm:flex-row">
                <div class="relative flex-1">
                    <input
                        type="text"
                        name="q"
                        value="{{ request('q') }}"
                        placeholder="Cari kegiatan atau jenis..."
                        class="input-field pl-10"
                    >
                    <svg class="pointer-events-none absolute left-3.5 top-3 h-4 w-4 text-[#7FA08C]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

                <button type="submit" class="btn-primary shrink-0 sm:w-auto">
                    Cari
                </button>
            </div>

            <div class="flex items-center gap-2 overflow-x-auto pb-1 pt-1">
                <a
                    href="{{ route('kegiatan.index', request()->except('status')) }}"
                    class="chip-filter {{ !request('status') ? 'chip-active' : 'chip-idle' }}"
                >
                    Semua Status
                </a>

                <a
                    href="{{ route('kegiatan.index', array_merge(request()->except('status'), ['status' => 'aktif'])) }}"
                    class="chip-filter {{ request('status') == 'aktif' ? 'chip-active' : 'chip-idle' }}"
                >
                    Aktif
                </a>

                <a
                    href="{{ route('kegiatan.index', array_merge(request()->except('status'), ['status' => 'nonaktif'])) }}"
                    class="chip-filter {{ request('status') == 'nonaktif' ? 'chip-active' : 'chip-idle' }}"
                >
                    Nonaktif
                </a>

                @if(request('q') || request('status'))
                    <a
                        href="{{ route('kegiatan.index') }}"
                        class="ml-auto whitespace-nowrap text-sm font-semibold text-[#163832] underline hover:text-[#051F20]"
                    >
                        Reset
                    </a>
                @endif
            </div>
        </form>
    </div>

    <div class="block overflow-hidden rounded-2xl border border-[#DAF1DE] bg-white shadow-sm">
        <div class="overflow-x-auto">
            <table class="min-w-full text-sm">
                <thead class="bg-[#DAF1DE]/50 text-left text-xs font-bold uppercase tracking-wider text-[#051F20]">
                    <tr>
                        <th class="px-5 py-4">Judul Kegiatan</th>
                        <th class="px-5 py-4">Jenis</th>
                        <th class="px-5 py-4">Target Peserta</th>
                        <th class="px-5 py-4">Status</th>
                        <th class="px-5 py-4 text-right">Aksi</th>
                    </tr>
                </thead>

                <tbody class="divide-y divide-slate-100">
                @forelse($kegiatans as $kegiatan)
                    <tr class="transition hover:bg-[#DAF1DE]/20">
                        <td class="px-5 py-4">
                            <p class="font-bold text-[#051F20] text-base">
                                {{ $kegiatan->judul }}
                            </p>
                            <p class="mt-0.5 text-xs text-[#55766A] line-clamp-1">
                                {{ $kegiatan->deskripsi ?? '-' }}
                            </p>
                        </td>

                        <td class="px-5 py-4 font-semibold text-[#163832]">
                            {{ ucfirst($kegiatan->jenis) }}
                        </td>

                        <td class="px-5 py-4 text-[#163832]">
                            {{ $kegiatan->target_peserta ?? '-' }}
                        </td>

                        <td class="px-5 py-4">
                            @if($kegiatan->status == 'aktif')
                                <span class="badge-mint">Aktif</span>
                            @else
                                <span class="badge-gray">Nonaktif</span>
                            @endif
                        </td>

                        <td class="px-5 py-4 text-right whitespace-nowrap">
                            <div class="flex items-center justify-end gap-1.5">
                                <a href="{{ route('kegiatan.show', $kegiatan) }}" class="btn-ghost">
                                    Detail
                                </a>

                                <div x-show="user?.role === 'admin'" x-cloak class="flex items-center gap-1.5">
                                    <a href="{{ route('kegiatan.edit', $kegiatan) }}" class="btn-ghost">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('kegiatan.destroy', $kegiatan) }}"
                                        method="POST"
                                        class="inline"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            onclick="return confirm('Hapus kegiatan ini?')"
                                            class="btn-danger"
                                        >
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-5 py-12 text-center font-medium text-[#55766A]">
                            Belum ada kegiatan.
                        </td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="grid grid-cols-1 gap-4 md:hidden">
        @forelse($kegiatans as $kegiatan)
            <div class="card-panel flex flex-col gap-3">
                <div class="flex items-start justify-between gap-2">
                    <div>
                        <h3 class="font-bold text-[#051F20] text-base">
                            {{ $kegiatan->judul }}
                        </h3>
                        <p class="mt-0.5 text-xs font-semibold text-[#55766A]">
                            Jenis: {{ ucfirst($kegiatan->jenis) }}
                        </p>
                    </div>

                    @if($kegiatan->status == 'aktif')
                        <span class="badge-mint shrink-0">Aktif</span>
                    @else
                        <span class="badge-gray shrink-0">Nonaktif</span>
                    @endif
                </div>

                @if($kegiatan->deskripsi)
                    <p class="rounded-xl border border-[#DAF1DE] bg-[#DAF1DE]/30 p-2.5 text-xs text-[#163832] line-clamp-2">
                        {{ $kegiatan->deskripsi }}
                    </p>
                @endif

                <div class="text-xs text-[#55766A]">
                    Target:
                    <span class="font-semibold text-[#051F20]">
                        {{ $kegiatan->target_peserta ?? '-' }}
                    </span>
                </div>

                <div class="flex items-center justify-end gap-2 border-t border-[#DAF1DE] pt-1">
                    <a
                        href="{{ route('kegiatan.show', $kegiatan) }}"
                        class="btn-ghost flex-1 justify-center text-center"
                    >
                        Detail
                    </a>

                    <div
                        x-show="user?.role === 'admin'"
                        x-cloak
                        class="flex flex-1 items-center gap-2"
                    >
                        <a
                            href="{{ route('kegiatan.edit', $kegiatan) }}"
                            class="btn-ghost flex-1 justify-center text-center"
                        >
                            Edit
                        </a>

                        <form
                            action="{{ route('kegiatan.destroy', $kegiatan) }}"
                            method="POST"
                            class="inline flex-1"
                        >
                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                onclick="return confirm('Hapus kegiatan ini?')"
                                class="btn-danger w-full justify-center"
                            >
                                Hapus
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="card-panel p-8 text-center text-[#55766A]">
                Belum ada kegiatan.
            </div>
        @endforelse
    </div>

    <div class="mt-6">
        {{ $kegiatans->links() }}
    </div>
</div>
</x-layouts.panel>