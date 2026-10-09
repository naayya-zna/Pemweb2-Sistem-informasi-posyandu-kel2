<x-layouts.panel title="Jadwal">

@php

    $btn = 'inline-flex items-center justify-center gap-1.5 rounded-xl px-3 py-1.5 text-xs font-semibold transition focus:outline-none focus-visible:ring-2 focus-visible:ring-[#235347] disabled:opacity-50';

    $primary = 'btn-primary';

    $ghost = 'btn-secondary text-xs py-1.5 px-3';

    $input = 'input-field';

    $label = 'input-label';

@endphp



<div x-data="jadwalPage()" x-init="init()">



    {{-- Header --}}

    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

        <div>

            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-[#051F20]">Jadwal Kegiatan</h1>

            <p class="mt-1 text-sm text-[#3C5A52]">Jadwal pelaksanaan kegiatan Posyandu beserta pendaftaran pesertanya.</p>

        </div>

        <button x-show="isStaff" x-cloak @click="openCreate()"

                class="btn-primary">

            <svg class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15"/></svg>

            Tambah Jadwal

        </button>

    </div>



    {{-- Ringkasan --}}

    <div class="mb-6 grid grid-cols-2 gap-3.5 lg:grid-cols-4">

        <template x-for="s in stats" :key="s.label">

            <button type="button" @click="filters.status = s.status; load(1)"

                    class="rounded-2xl border bg-white p-4 text-left shadow-2xs transition hover:shadow-sm focus:outline-none focus-visible:ring-2 focus-visible:ring-[#235347]"

                    :class="filters.status === s.status ? 'border-[#8EB69B] ring-2 ring-[#DAF1DE]' : 'border-[#DAF1DE]'">

                <div class="flex items-center gap-2">

                    <span class="h-2.5 w-2.5 rounded-full" :class="s.dot"></span>

                    <p class="text-xs font-semibold text-[#55766A]" x-text="s.label"></p>

                </div>

                <p class="mt-1.5 text-2xl sm:text-3xl font-extrabold tabular-nums text-[#051F20]" x-text="s.value"></p>

            </button>

        </template>

    </div>



    {{-- Filter --}}

    <div class="mb-6 space-y-3.5 rounded-2xl border border-[#DAF1DE] bg-white p-4 shadow-sm">

        <div class="grid gap-3 md:grid-cols-12">

            <input type="search" x-model="filters.search" @input.debounce.400ms="load(1)"

                   placeholder="Cari kegiatan atau lokasi..."

                   class="input-field md:col-span-6">

            <input type="date" x-model="filters.dari" @change="load(1)" title="Dari tanggal"

                   class="input-field md:col-span-3">

            <input type="date" x-model="filters.sampai" @change="load(1)" title="Sampai tanggal"

                   class="input-field md:col-span-3">

        </div>

        <div class="flex items-center gap-2 overflow-x-auto pb-1">

            <template x-for="chip in chips" :key="chip[0]">

                <button @click="filters.status = chip[0]; load(1)"

                        class="chip-filter"

                        :class="filters.status === chip[0] ? 'chip-active' : 'chip-idle'"

                        x-text="chip[1]"></button>

            </template>

            <button x-show="filters.search || filters.dari || filters.sampai || filters.status"

                    @click="resetFilter()" class="ml-auto whitespace-nowrap text-sm text-[#163832] font-semibold underline hover:text-[#051F20]">

                Reset

            </button>

        </div>

    </div>



    {{-- Daftar --}}

    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-3">



        {{-- Skeleton --}}

        <template x-for="n in (loading && !items.length ? 6 : 0)" :key="'s'+n">

            <div class="animate-pulse space-y-4 rounded-2xl border border-[#DAF1DE] bg-white p-5">

                <div class="flex gap-4">

                    <div class="h-16 w-16 rounded-xl bg-[#DAF1DE]/40"></div>

                    <div class="flex-1 space-y-2 pt-1">

                        <div class="h-3 w-1/3 rounded bg-[#DAF1DE]/40"></div>

                        <div class="h-4 w-3/4 rounded bg-[#DAF1DE]/40"></div>

                    </div>

                </div>

                <div class="h-3 w-1/2 rounded bg-[#DAF1DE]/40"></div>

                <div class="h-3 w-2/3 rounded bg-[#DAF1DE]/40"></div>

            </div>

        </template>



        <template x-for="item in items" :key="item.id">

            <article class="flex flex-col rounded-2xl border border-[#DAF1DE] bg-white shadow-sm transition hover:shadow-md"

                     :class="item.status === 'batal' ? 'opacity-70' : ''">



                <div class="flex gap-4 p-5">

                    <div class="w-16 shrink-0 rounded-xl border border-[#BCDCC6] bg-[#DAF1DE]/60 py-2.5 text-center shadow-2xs">

                        <div class="text-2xl font-extrabold leading-none text-[#0B2B26]" x-text="day(item)"></div>

                        <div class="mt-1 text-xs font-bold uppercase tracking-wide text-[#235347]" x-text="mon(item)"></div>

                    </div>

                    <div class="min-w-0 flex-1">

                        <span class="inline-flex items-center rounded-full px-3 py-0.5 text-xs font-bold ring-1 ring-inset"

                              :class="badge(item.status)" x-text="item.status_label"></span>

                        <h3 class="mt-1.5 truncate text-base font-bold text-[#051F20]"

                            :title="item.kegiatan?.judul" x-text="item.kegiatan?.judul"></h3>

                        <p class="text-xs font-medium text-[#55766A]" x-text="tanggalID(item)"></p>

                    </div>

                </div>



                <div class="space-y-2 px-5 pb-4 text-sm text-slate-600">

                    <div class="flex items-center gap-2">

                        <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>

                        <span x-text="item.jam_mulai + ' - ' + item.jam_selesai + ' WIB'"></span>

                    </div>

                    <div class="flex items-center gap-2">

                        <svg class="h-4 w-4 shrink-0 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>

                        <span class="truncate" x-text="item.lokasi"></span>

                    </div>

                </div>



                {{-- Kuota --}}

                <div class="px-5 pb-4">

                    <template x-if="item.kuota">

                        <div>

                            <div class="mb-1 flex justify-between text-xs text-slate-500">

                                <span>Kuota peserta</span>

                                <span class="font-medium" x-text="item.terisi + ' / ' + item.kuota"></span>

                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                                <div class="h-full rounded-full transition-all"

                                     :class="pct(item) >= 100 ? 'bg-rose-500' : 'bg-emerald-500'"

                                     :style="`width:${pct(item)}%`"></div>

                            </div>

                        </div>

                    </template>

                    <template x-if="!item.kuota">

                        <p class="text-xs text-slate-500"><span class="font-medium" x-text="item.terisi"></span> peserta terdaftar · tanpa batas kuota</p>

                    </template>

                </div>



                {{-- Aksi --}}

                <div class="mt-auto border-t border-slate-100 px-5 py-3">



                    <template x-if="isStaff">

                        <div class="flex flex-wrap items-center gap-2">

                            <button x-show="item.status === 'akan_datang'" @click="aksi(item, 'mulai')" class="{{ $primary }}">Mulai</button>

                            <button x-show="item.status === 'berlangsung'" @click="aksi(item, 'selesai')" class="{{ $primary }}">Selesaikan</button>

                            <button @click="openDetail(item)" class="{{ $ghost }}">Peserta</button>

                            <button x-show="item.status === 'akan_datang'" @click="openEdit(item)" class="{{ $ghost }}">Edit</button>

                            <div class="ml-auto flex gap-1">

                                <button x-show="['akan_datang','berlangsung'].includes(item.status)" @click="aksi(item, 'batal')"

                                        class="{{ $btn }} text-amber-700 hover:bg-amber-50">Batalkan</button>

                                <button @click="hapus(item)" class="{{ $btn }} text-rose-600 hover:bg-rose-50">Hapus</button>

                            </div>

                        </div>

                    </template>



                    <template x-if="isWarga">

                        <div class="flex items-center gap-2">

                            <button @click="openDetail(item)" class="{{ $ghost }}">Detail</button>

                            <div class="ml-auto flex items-center gap-2">

                                <button x-show="item.status === 'akan_datang' && !item.sudah_daftar && item.sisa_kuota !== 0"

                                        @click="daftar(item)" class="{{ $primary }}">Daftar</button>

                                <span x-show="item.status === 'akan_datang' && !item.sudah_daftar && item.sisa_kuota === 0"

                                      class="text-xs font-medium text-rose-600">Kuota penuh</span>

                                <button x-show="item.status === 'akan_datang' && item.sudah_daftar"

                                        @click="batalDaftar(item)"

                                        class="{{ $btn }} border border-rose-200 text-rose-600 hover:bg-rose-50">Batalkan</button>

                                <span x-show="item.status !== 'akan_datang' && item.sudah_daftar"

                                      class="text-xs font-medium text-emerald-700">✓ Terdaftar</span>

                            </div>

                        </div>

                    </template>

                </div>

            </article>

        </template>

    </div>



    {{-- Kosong --}}

    <div x-show="!loading && !items.length" x-cloak

         class="rounded-2xl border border-dashed border-slate-300 bg-white px-6 py-16 text-center">

        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-full bg-emerald-50 text-emerald-600">

            <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 012.25-2.25h13.5A2.25 2.25 0 0121 7.5v11.25m-18 0A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75m-18 0v-7.5A2.25 2.25 0 015.25 9h13.5A2.25 2.25 0 0121 11.25v7.5"/></svg>

        </div>

        <p class="mt-4 text-base font-medium text-slate-700">Belum ada jadwal</p>

        <p class="mt-1 text-sm text-slate-500">Coba ubah filter pencarian, atau tambahkan jadwal baru.</p>

        <button x-show="isStaff" x-cloak @click="openCreate()" class="{{ $primary }} mt-5 px-4 py-2 text-sm">Tambah jadwal</button>

    </div>



    {{-- Pagination --}}

    <div x-show="meta && meta.last_page > 1" x-cloak

         class="mt-6 flex flex-col items-center justify-between gap-3 sm:flex-row">

        <p class="text-sm text-slate-500">

            Menampilkan <span x-text="meta?.from"></span>-<span x-text="meta?.to"></span>

            dari <span x-text="meta?.total"></span> jadwal

        </p>

        <div class="flex items-center gap-2">

            <button @click="load(meta.current_page - 1)" :disabled="meta?.current_page <= 1" class="{{ $ghost }} px-4">Sebelumnya</button>

            <span class="px-2 text-sm text-slate-600" x-text="meta?.current_page + ' / ' + meta?.last_page"></span>

            <button @click="load(meta.current_page + 1)" :disabled="meta?.current_page >= meta?.last_page" class="{{ $ghost }} px-4">Berikutnya</button>

        </div>

    </div>



    {{-- Modal Form --}}

    <div x-show="form.open" x-cloak class="fixed inset-0 z-40 flex items-end justify-center sm:items-center" @keydown.escape.window="form.open = false">

        <div class="absolute inset-0 bg-slate-900/50" @click="form.open = false" x-transition.opacity></div>

        <div x-show="form.open" x-transition

             class="relative max-h-[90vh] w-full overflow-y-auto rounded-t-2xl bg-white p-6 shadow-xl sm:max-w-lg sm:rounded-2xl">

            <div class="mb-5 flex items-center justify-between">

                <h2 class="text-lg font-semibold text-slate-900" x-text="form.id ? 'Edit Jadwal' : 'Tambah Jadwal'"></h2>

                <button @click="form.open = false" aria-label="Tutup" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100">

                    <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>

                </button>

            </div>



            <div class="space-y-4">

                <div>

                    <label class="{{ $label }}">Kegiatan</label>

                    <select x-model="form.data.kegiatan_id" class="{{ $input }}">

                        <option value="">-- Pilih kegiatan --</option>

                        <template x-for="k in kegiatans" :key="k.id">

                            <option :value="k.id" x-text="k.judul"></option>

                        </template>

                    </select>

                    <p class="mt-1 text-xs text-rose-600" x-show="form.errors.kegiatan_id" x-text="form.errors.kegiatan_id?.[0]"></p>

                </div>



                <div>

                    <label class="{{ $label }}">Tanggal</label>

                    <input type="date" x-model="form.data.tanggal" class="{{ $input }}">

                    <p class="mt-1 text-xs text-rose-600" x-show="form.errors.tanggal" x-text="form.errors.tanggal?.[0]"></p>

                </div>



                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>

                        <label class="{{ $label }}">Jam mulai</label>

                        <input type="time" x-model="form.data.jam_mulai" class="{{ $input }}">

                        <p class="mt-1 text-xs text-rose-600" x-show="form.errors.jam_mulai" x-text="form.errors.jam_mulai?.[0]"></p>

                    </div>

                    <div>

                        <label class="{{ $label }}">Jam selesai</label>

                        <input type="time" x-model="form.data.jam_selesai" class="{{ $input }}">

                        <p class="mt-1 text-xs text-rose-600" x-show="form.errors.jam_selesai" x-text="form.errors.jam_selesai?.[0]"></p>

                    </div>

                </div>



                <div>

                    <label class="{{ $label }}">Lokasi</label>

                    <input type="text" x-model="form.data.lokasi" placeholder="Contoh: Balai Desa" class="{{ $input }}">

                    <p class="mt-1 text-xs text-rose-600" x-show="form.errors.lokasi" x-text="form.errors.lokasi?.[0]"></p>

                </div>



                <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                    <div>

                        <label class="{{ $label }}">Petugas <span class="font-normal text-slate-400">(opsional)</span></label>

                        <input type="text" x-model="form.data.petugas" class="{{ $input }}">

                        <p class="mt-1 text-xs text-rose-600" x-show="form.errors.petugas" x-text="form.errors.petugas?.[0]"></p>

                    </div>

                    <div>

                        <label class="{{ $label }}">Kuota <span class="font-normal text-slate-400">(opsional)</span></label>

                        <input type="number" min="1" x-model="form.data.kuota" placeholder="Tanpa batas" class="{{ $input }}">

                        <p class="mt-1 text-xs text-rose-600" x-show="form.errors.kuota" x-text="form.errors.kuota?.[0]"></p>

                    </div>

                </div>

            </div>



            <div class="mt-6 flex justify-end gap-2">

                <button @click="form.open = false" class="{{ $ghost }} px-4 py-2 text-sm">Batal</button>

                <button @click="save()" :disabled="form.saving" class="{{ $primary }} px-5 py-2 text-sm">

                    <span x-text="form.saving ? 'Menyimpan...' : 'Simpan'"></span>

                </button>

            </div>

        </div>

    </div>



    {{-- Modal Detail --}}

    <div x-show="detail.open" x-cloak class="fixed inset-0 z-40 flex items-end justify-center sm:items-center" @keydown.escape.window="detail.open = false">

        <div class="absolute inset-0 bg-slate-900/50" @click="detail.open = false" x-transition.opacity></div>

        <div x-show="detail.open" x-transition

             class="relative max-h-[90vh] w-full overflow-y-auto rounded-t-2xl bg-white p-6 shadow-xl sm:max-w-lg sm:rounded-2xl">

            <template x-if="detail.item">

                <div>

                    <div class="mb-4 flex items-start justify-between gap-3">

                        <div>

                            <span class="inline-flex rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset"

                                  :class="badge(detail.item.status)" x-text="detail.item.status_label"></span>

                            <h2 class="mt-1.5 text-lg font-semibold text-slate-900" x-text="detail.item.kegiatan?.judul"></h2>

                        </div>

                        <button @click="detail.open = false" aria-label="Tutup" class="rounded-lg p-1 text-slate-400 hover:bg-slate-100">

                            <svg class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/></svg>

                        </button>

                    </div>



                    <dl class="grid grid-cols-3 gap-y-2 text-sm">

                        <dt class="text-slate-500">Tanggal</dt><dd class="col-span-2" x-text="tanggalID(detail.item)"></dd>

                        <dt class="text-slate-500">Waktu</dt><dd class="col-span-2" x-text="detail.item.jam_mulai + ' - ' + detail.item.jam_selesai + ' WIB'"></dd>

                        <dt class="text-slate-500">Lokasi</dt><dd class="col-span-2" x-text="detail.item.lokasi"></dd>

                        <dt class="text-slate-500">Petugas</dt><dd class="col-span-2" x-text="detail.item.petugas || '-'"></dd>

                        <dt class="text-slate-500">Peserta</dt>

                        <dd class="col-span-2" x-text="detail.item.terisi + (detail.item.kuota ? ' dari ' + detail.item.kuota : '') + ' orang'"></dd>

                    </dl>



                    <div x-show="isStaff" class="mt-5">

                        <h3 class="mb-2 text-sm font-semibold text-slate-900">Daftar Peserta</h3>

                        <p x-show="detail.loading" class="text-sm text-slate-500">Memuat...</p>

                        <p x-show="!detail.loading && !detail.peserta.length" class="rounded-lg bg-slate-50 p-4 text-center text-sm text-slate-500">Belum ada warga yang mendaftar.</p>

                        <ul class="divide-y divide-slate-100">

                            <template x-for="p in detail.peserta" :key="p.id">

                                <li class="flex items-center justify-between gap-3 py-2.5">

                                    <div class="min-w-0">

                                        <p class="truncate text-sm font-medium text-slate-900" x-text="p.warga?.nama"></p>

                                        <p class="text-xs capitalize text-slate-500" x-text="p.warga?.nik + ' · ' + (p.warga?.kategori || '').replace('_',' ')"></p>

                                    </div>

                                    <span class="shrink-0 rounded-full px-2.5 py-0.5 text-xs font-semibold ring-1 ring-inset"

                                          :class="pendaftaranBadge(p.status)" x-text="p.status_label"></span>

                                </li>

                            </template>

                        </ul>

                    </div>

                </div>

            </template>

        </div>

    </div>



    {{-- Modal Konfirmasi --}}

    <div x-show="confirmBox.open" x-cloak class="fixed inset-0 z-40 flex items-center justify-center p-4">

        <div class="absolute inset-0 bg-slate-900/50" @click="confirmBox.open = false" x-transition.opacity></div>

        <div x-show="confirmBox.open" x-transition class="relative w-full max-w-sm rounded-2xl bg-white p-6 shadow-xl">

            <h2 class="text-lg font-semibold text-slate-900" x-text="confirmBox.title"></h2>

            <p class="mt-2 text-sm text-slate-600" x-text="confirmBox.text"></p>

            <div class="mt-6 flex justify-end gap-2">

                <button @click="confirmBox.open = false" class="{{ $ghost }} px-4 py-2 text-sm">Tidak</button>

                <button @click="runConfirm()" :disabled="confirmBox.busy"

                        class="{{ $btn }} px-4 py-2 text-sm text-white"

                        :class="confirmBox.danger ? 'bg-rose-600 hover:bg-rose-700' : 'bg-emerald-600 hover:bg-emerald-700'"

                        x-text="confirmBox.busy ? 'Memproses...' : confirmBox.label"></button>

            </div>

        </div>

    </div>

</div>



@verbatim

<script>

function jadwalPage() {

    return {

        user: null,

        items: [],

        meta: null,

        statsCounts: null,

        loading: true,

        kegiatans: [],

        filters: { search: '', status: '', dari: '', sampai: '', page: 1 },

        chips: [['', 'Semua'], ['akan_datang', 'Akan Datang'], ['berlangsung', 'Berlangsung'], ['selesai', 'Selesai'], ['batal', 'Batal']],

        form: { open: false, saving: false, id: null, data: {}, errors: {} },

        detail: { open: false, item: null, peserta: [], loading: false },

        confirmBox: { open: false, title: '', text: '', label: '', danger: false, busy: false, action: null },



        get isStaff() { return !!this.user && ['admin', 'kader'].includes(this.user.role); },

        get isWarga() { return this.user?.role === 'warga'; },



        // Statistik berasal dari seluruh data, bukan daftar yang terfilter.
        get stats() {
            const c = s => this.statsCounts?.[s] ?? 0;
            return [
                { label: 'Total jadwal', status: '', value: c('total'), color: 'text-slate-900', dot: 'bg-slate-400' },
                { label: 'Akan datang', status: 'akan_datang', value: c('akan_datang'), color: 'text-sky-600', dot: 'bg-sky-500' },
                { label: 'Berlangsung', status: 'berlangsung', value: c('berlangsung'), color: 'text-emerald-600', dot: 'bg-emerald-500' },
                { label: 'Selesai', status: 'selesai', value: c('selesai'), color: 'text-slate-500', dot: 'bg-slate-300' },
            ];
        },

        async init() {

            try {

                this.user = await getMe();

            } catch (e) {

                // getMe() only throws on non-401 errors; 401 returns null

                this.user = null;

            }



            // Redirect ke login hanya jika user benar-benar null (token tidak ada / tidak valid)

            if (!this.user) {

                window.location.href = '/login';

                return;

            }



            try {

                if (this.isStaff) {

                    const r = await api('/jadwal/opsi');

                    this.kegiatans = r.data.kegiatans;

                }

            } catch (e) { this.err(e); }

            await this.load(1);

        },



        async load(page = 1) {

            this.loading = true;

            this.filters.page = page;

            try {

                const r = await api('/jadwal', { params: { ...this.filters, per_page: 9 } });
                this.items = r.data;
                this.meta = r.meta;

                // Counts dikirim API secara terpisah dari hasil filter.
                if (r.counts) {
                    this.statsCounts = r.counts;
                }
            } catch (e) { this.err(e); }

            finally { this.loading = false; }

        },



        resetFilter() {

            this.filters = { search: '', status: '', dari: '', sampai: '', page: 1 };

            this.load(1);

        },



        err(e) { toast(e.message || 'Terjadi kesalahan.', 'error'); },



        // ---------- tampilan ----------

        day(i) { return new Date(i.tanggal + 'T00:00:00').getDate(); },

        mon(i) { return new Date(i.tanggal + 'T00:00:00').toLocaleDateString('id-ID', { month: 'short' }); },

        tanggalID(i) {

            return new Date(i.tanggal + 'T00:00:00').toLocaleDateString('id-ID', {

                weekday: 'long', day: 'numeric', month: 'long', year: 'numeric',

            });

        },

        pct(i) { return i.kuota ? Math.min(100, Math.round((i.terisi / i.kuota) * 100)) : 0; },

        badge(s) {

            return {

                akan_datang: 'bg-sky-50 text-sky-700 ring-sky-200',

                berlangsung: 'bg-emerald-50 text-emerald-700 ring-emerald-200',

                selesai: 'bg-slate-100 text-slate-600 ring-slate-200',

                batal: 'bg-rose-50 text-rose-700 ring-rose-200',

            }[s] || 'bg-slate-100 text-slate-600 ring-slate-200';

        },

        pendaftaranBadge(s) {

            return {

                terdaftar: 'bg-sky-50 text-sky-700 ring-sky-200',

                hadir: 'bg-emerald-50 text-emerald-700 ring-emerald-200',

                tidak_hadir: 'bg-amber-50 text-amber-700 ring-amber-200',

                batal: 'bg-rose-50 text-rose-700 ring-rose-200',

            }[s] || 'bg-slate-100 text-slate-600 ring-slate-200';

        },



        // ---------- form ----------

        blank() {

            return { kegiatan_id: '', tanggal: '', jam_mulai: '', jam_selesai: '', lokasi: '', petugas: '', kuota: '' };

        },

        openCreate() {

            this.form = { open: true, saving: false, id: null, data: this.blank(), errors: {} };

        },

        openEdit(i) {

            this.form = {

                open: true, saving: false, id: i.id, errors: {},

                data: {

                    kegiatan_id: i.kegiatan?.id ?? '', tanggal: i.tanggal,

                    jam_mulai: i.jam_mulai, jam_selesai: i.jam_selesai,

                    lokasi: i.lokasi, petugas: i.petugas ?? '', kuota: i.kuota ?? '',

                },

            };

        },

        async save() {

            this.form.saving = true;

            this.form.errors = {};

            const d = this.form.data;

            const payload = {

                ...d,

                petugas: d.petugas || null,

                kuota: d.kuota === '' || d.kuota === null ? null : Number(d.kuota),

            };

            try {

                const r = await api(this.form.id ? `/jadwal/${this.form.id}` : '/jadwal', {

                    method: this.form.id ? 'PUT' : 'POST', body: payload,

                });

                toast(r.message);

                this.form.open = false;

                await this.load(this.form.id ? this.filters.page : 1);

            } catch (e) {

                if (e.status === 422) this.form.errors = e.errors ?? {};

                else this.err(e);

            } finally { this.form.saving = false; }

        },



        // ---------- detail ----------

        async openDetail(i) {

            this.detail = { open: true, item: i, peserta: [], loading: this.isStaff };

            if (!this.isStaff) return;

            try {

                const r = await api(`/jadwal/${i.id}/pendaftaran`, { params: { per_page: 100 } });

                this.detail.peserta = r.data;

            } catch (e) { this.err(e); }

            finally { this.detail.loading = false; }

        },



        // ---------- konfirmasi ----------

        ask({ title, text, label, danger = false, action }) {

            this.confirmBox = { open: true, title, text, label, danger, busy: false, action };

        },

        async runConfirm() {

            this.confirmBox.busy = true;

            try { await this.confirmBox.action(); }

            catch (e) { this.err(e); }

            finally { this.confirmBox.busy = false; this.confirmBox.open = false; }

        },



        // ---------- aksi kader ----------

        aksi(i, jenis) {

            const teks = {

                mulai: ['Mulai jadwal?', 'Pendaftaran akan ditutup dan pemeriksaan bisa dicatat.', 'Ya, mulai', false],

                selesai: ['Selesaikan jadwal?', 'Peserta yang belum diperiksa akan ditandai tidak hadir.', 'Ya, selesaikan', false],

                batal: ['Batalkan jadwal?', 'Seluruh pendaftaran yang masih aktif ikut dibatalkan.', 'Ya, batalkan', true],

            }[jenis];

            this.ask({

                title: teks[0], text: teks[1], label: teks[2], danger: teks[3],

                action: async () => {

                    const r = await api(`/jadwal/${i.id}/${jenis}`, { method: 'POST' });

                    toast(r.message);

                    await this.load(this.filters.page);

                },

            });

        },

        hapus(i) {

            this.ask({

                title: 'Hapus jadwal?', danger: true, label: 'Ya, hapus',

                text: 'Jadwal yang sudah punya peserta atau pemeriksaan tidak bisa dihapus.',

                action: async () => {

                    const r = await api(`/jadwal/${i.id}`, { method: 'DELETE' });

                    toast(r.message);

                    await this.load(this.items.length === 1 ? Math.max(1, this.filters.page - 1) : this.filters.page);

                },

            });

        },



        // ---------- aksi warga ----------

        daftar(i) {

            this.ask({

                title: 'Daftar kegiatan ini?', label: 'Ya, daftar',

                text: `${i.kegiatan?.judul} pada ${this.tanggalID(i)}.`,

                action: async () => {

                    const r = await api(`/jadwal/${i.id}/pendaftaran`, { method: 'POST' });

                    toast(r.message);

                    await this.load(this.filters.page);

                },

            });

        },

        batalDaftar(i) {

            this.ask({

                title: 'Batalkan pendaftaran?', danger: true, label: 'Ya, batalkan',

                text: 'Kursi Anda akan dilepas untuk warga lain.',

                action: async () => {

                    const r = await api(`/jadwal/${i.id}/pendaftaran`, { method: 'DELETE' });

                    toast(r.message);

                    await this.load(this.filters.page);

                },

            });

        },

    };

}

</script>

@endverbatim

</x-layouts.panel>