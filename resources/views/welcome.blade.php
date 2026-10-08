<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Posyandu Digital</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body { font-family: 'Plus Jakarta Sans', ui-sans-serif, system-ui, sans-serif; }
        [x-cloak] { display: none !important; }
        @media (prefers-reduced-motion: reduce) { html { scroll-behavior: auto; } }
    </style>
</head>
{{-- Palet: ink #051F20 · deep #0B2B26 · forest #163832 · moss #235347 · sage #8EB69B · mist #DAF1DE --}}
<body class="overflow-x-hidden bg-[#DAF1DE] text-[#051F20] antialiased">

{{-- Navbar --}}
<header x-data="{ open: false }" class="sticky top-0 z-30 bg-[#DAF1DE]/90 backdrop-blur">
    <div class="mx-auto flex max-w-6xl items-center gap-6 px-4 py-3 sm:px-6">
        <a href="#" class="flex items-center gap-2 font-bold text-[#0B2B26]">
            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#235347] text-white">P</span>
            Posyandu Digital
        </a>
        <nav class="ml-auto hidden items-center gap-6 text-sm font-medium text-[#163832] md:flex">
            <a href="#layanan" class="hover:text-[#235347]">Layanan</a>
            <a href="#alur" class="hover:text-[#235347]">Alur</a>
            <a href="#peran" class="hover:text-[#235347]">Manfaat</a>
            <a href="#jadwal" class="hover:text-[#235347]">Jadwal</a>
            <a href="#faq" class="hover:text-[#235347]">FAQ</a>
        </nav>
        <div class="ml-auto flex items-center gap-2 md:ml-0">
            <a href="{{ route('login') }}" class="hidden rounded-lg px-3 py-2 text-sm font-semibold text-[#163832] hover:bg-[#8EB69B]/30 sm:block">Masuk</a>
            <a href="{{ route('register') }}" class="rounded-lg bg-[#163832] px-4 py-2 text-sm font-semibold text-[#DAF1DE] hover:bg-[#0B2B26]">Daftar</a>
            <button @click="open = !open" class="rounded-lg p-2 text-[#163832] md:hidden" aria-label="Menu">
                <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" d="M4 7h16M4 12h16M4 17h16"/></svg>
            </button>
        </div>
    </div>
    <nav x-show="open" x-cloak @click="open = false" class="border-t border-[#8EB69B]/50 px-4 pb-3 text-sm font-medium text-[#163832] md:hidden">
        <a href="#layanan" class="block py-2">Layanan</a>
        <a href="#alur" class="block py-2">Alur</a>
        <a href="#peran" class="block py-2">Manfaat</a>
        <a href="#jadwal" class="block py-2">Jadwal</a>
        <a href="#faq" class="block py-2">FAQ</a>
        <a href="{{ route('login') }}" class="block py-2 sm:hidden">Masuk</a>
    </nav>
</header>

{{-- Hero --}}
<section 
    class="relative overflow-hidden bg-[#0B2B26] text-[#DAF1DE]"
    style="
        background-image:
            linear-gradient(
                to right,
                #0B2B26 0%,
                rgba(11, 43, 38, 0.97) 15%,
                rgba(11, 43, 38, 0.85) 30%,
                rgba(11, 43, 38, 0.55) 50%,
                rgba(11, 43, 38, 0.20) 70%,
                rgba(11, 43, 38, 0) 100%
            ),
            url('{{ asset('images/gambarposyandu.jpg') }}');
        background-size: cover;
        background-position: center;
    "
>
    <div class="mx-auto grid max-w-6xl items-center gap-10 px-4 py-12 sm:px-6 lg:grid-cols-2 lg:gap-14 lg:py-20">

        <div>
            <h1 class="text-3xl font-bold leading-snug sm:text-4xl lg:text-5xl lg:leading-tight">Kesehatan warga tercatat rapi, jadwal Posyandu mudah dicari.</h1>
            <p class="mt-5 max-w-md text-[#8EB69B]">Kader mencatat pemeriksaan dalam satu sistem. Warga mendaftar kegiatan dan melihat riwayat kesehatannya sendiri dari ponsel.</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('register') }}" class="flex-1 rounded-xl bg-[#8EB69B] px-6 py-3 text-center text-sm font-bold sm:flex-none text-[#051F20] hover:bg-[#DAF1DE]">Daftar sebagai warga</a>
                <a href="#jadwal" class="flex-1 rounded-xl border border-[#8EB69B]/60 px-6 py-3 text-center text-sm font-semibold sm:flex-none hover:bg-[#163832]">Lihat jadwal</a>
            </div>
        </div>

        {{-- Kartu jadwal terdekat (data nyata) --}}
        <div class="rounded-3xl bg-[#163832] p-5 shadow-2xl sm:p-6 ring-1 ring-[#235347]">
            <p class="text-sm font-semibold text-[#8EB69B]">Jadwal terdekat</p>
            @php $next = $jadwals->first(); @endphp
            @if ($next)
                <h2 class="mt-2 text-2xl font-bold">{{ $next->kegiatan->judul }}</h2>
                <dl class="mt-5 space-y-3 text-sm">
                    <div class="flex flex-col gap-1 border-b border-[#235347] pb-3 sm:flex-row sm:justify-between sm:gap-4"><dt class="text-[#8EB69B]">Tanggal</dt><dd class="font-semibold sm:text-right">{{ $next->tanggal->locale('id')->translatedFormat('l, d F Y') }}</dd></div>
                    <div class="flex flex-col gap-1 border-b border-[#235347] pb-3 sm:flex-row sm:justify-between sm:gap-4"><dt class="text-[#8EB69B]">Waktu</dt><dd class="font-semibold sm:text-right">{{ substr($next->jam_mulai, 0, 5) }} - {{ substr($next->jam_selesai, 0, 5) }} WIB</dd></div>
                    <div class="flex flex-col gap-1 sm:flex-row sm:justify-between sm:gap-4"><dt class="text-[#8EB69B]">Lokasi</dt><dd class="font-semibold sm:text-right">{{ $next->lokasi }}</dd></div>
                </dl>
                <a href="{{ route('login') }}" class="mt-6 block rounded-xl bg-[#DAF1DE] py-3 text-center text-sm font-bold text-[#0B2B26] hover:bg-[#8EB69B]">Masuk untuk mendaftar</a>
            @else
                <h2 class="mt-2 text-xl font-bold">Belum ada jadwal</h2>
                <p class="mt-2 text-sm text-[#8EB69B]">Jadwal kegiatan akan tampil di sini begitu kader menambahkannya.</p>
            @endif
        </div>
    </div>
</section>

{{-- Statistik (angka dari database) --}}
<section class="border-b border-[#8EB69B]/50">
    <dl class="mx-auto grid max-w-6xl grid-cols-3 gap-4 px-4 py-8 text-center sm:px-6">
        <div><dd class="text-2xl font-extrabold text-[#235347] sm:text-3xl">{{ $stat['warga'] }}</dd><dt class="text-sm text-[#163832]">Warga terdata</dt></div>
        <div><dd class="text-2xl font-extrabold text-[#235347] sm:text-3xl">{{ $stat['kegiatan'] }}</dd><dt class="text-sm text-[#163832]">Kegiatan aktif</dt></div>
        <div><dd class="text-2xl font-extrabold text-[#235347] sm:text-3xl">{{ $stat['jadwal'] }}</dd><dt class="text-sm text-[#163832]">Jadwal mendatang</dt></div>
    </dl>
</section>

{{-- Layanan --}}
<section id="layanan" class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
    <h2 class="text-2xl font-bold text-[#0B2B26] sm:text-3xl">Layanan yang tersedia</h2>
    <p class="mt-2 max-w-xl text-[#163832]">Setiap kegiatan punya jadwal, kuota, dan catatan pemeriksaan sendiri.</p>
    <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
        @foreach ([
            ['Penimbangan balita', 'Berat dan tinggi badan dicatat tiap bulan, lengkap dengan status gizi.', 'M12 3v18M5 8h14M7 8l-3 6a3 3 0 006 0L7 8zm10 0l-3 6a3 3 0 006 0l-3-6z'],
            ['Imunisasi', 'Jadwal imunisasi dasar untuk bayi dan balita agar tidak terlewat.', 'M19 5l-4 4m-2-2l4 4M7 17l-3 3m2-6l8-8 4 4-8 8-4-4z'],
            ['Pemeriksaan ibu hamil', 'Pemantauan berat badan, tekanan darah, dan lingkar lengan.', 'M12 21s-7-4.5-7-10a4 4 0 017-2.6A4 4 0 0119 11c0 5.5-7 10-7 10z'],
            ['Kesehatan lansia', 'Cek tekanan darah dan gula darah, termasuk senam bersama.', 'M3 12h4l3-7 4 14 3-7h4'],
        ] as [$judul, $isi, $icon])
            <article class="rounded-2xl border border-[#8EB69B] bg-white/50 p-5">
                <span class="flex h-11 w-11 items-center justify-center rounded-xl bg-[#235347] text-[#DAF1DE]">
                    <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.6"><path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}"/></svg>
                </span>
                <h3 class="mt-4 font-bold text-[#0B2B26]">{{ $judul }}</h3>
                <p class="mt-1 text-sm text-[#163832]">{{ $isi }}</p>
            </article>
        @endforeach
    </div>
</section>

{{-- Alur --}}
<section id="alur" class="bg-[#163832] text-[#DAF1DE]">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <h2 class="text-2xl font-bold sm:text-3xl">Empat langkah, tanpa antre di buku catatan</h2>
        <ol class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
            @foreach ([
                ['Didata kader', 'Kader mendaftarkan data warga dengan NIK.'],
                ['Buat akun', 'Warga mendaftar memakai NIK yang sudah terdata.'],
                ['Pilih jadwal', 'Warga mendaftar ke kegiatan selama kuota masih ada.'],
                ['Diperiksa', 'Kader mencatat hasil, warga melihat riwayatnya.'],
            ] as $i => [$judul, $isi])
                <li>
                    <span class="flex h-10 w-10 items-center justify-center rounded-full bg-[#8EB69B] font-bold text-[#051F20]">{{ $i + 1 }}</span>
                    <h3 class="mt-4 font-bold">{{ $judul }}</h3>
                    <p class="mt-1 text-sm text-[#8EB69B]">{{ $isi }}</p>
                </li>
            @endforeach
        </ol>
    </div>
</section>

{{-- Manfaat per peran --}}
<section id="peran" class="mx-auto max-w-6xl px-4 py-12 sm:px-6 sm:py-16">
    <h2 class="text-2xl font-bold text-[#0B2B26] sm:text-3xl">Dibuat untuk tiga peran</h2>
    <div class="mt-8 grid gap-4 md:grid-cols-3">
        @foreach ([
            ['Warga', ['Lihat jadwal dan sisa kuota', 'Daftar dan batalkan kegiatan sendiri', 'Pantau riwayat pemeriksaan pribadi']],
            ['Kader', ['Kelola data warga dan kegiatan', 'Mulai dan selesaikan jadwal', 'Catat hasil pemeriksaan']],
            ['Admin', ['Akses penuh seluruh fitur', 'Kelola akun kader', 'Pantau seluruh data Posyandu']],
        ] as [$peran, $poin])
            <article class="rounded-2xl bg-[#0B2B26] p-6 text-[#DAF1DE]">
                <h3 class="text-lg font-bold">{{ $peran }}</h3>
                <ul class="mt-3 space-y-2 text-sm text-[#8EB69B]">
                    @foreach ($poin as $p)<li class="flex gap-2"><span class="text-[#DAF1DE]">✓</span>{{ $p }}</li>@endforeach
                </ul>
            </article>
        @endforeach
    </div>
</section>

{{-- Jadwal mendatang --}}
<section id="jadwal" class="bg-[#8EB69B]/30">
    <div class="mx-auto max-w-6xl px-4 py-16 sm:px-6">
        <h2 class="text-2xl font-bold text-[#0B2B26] sm:text-3xl">Jadwal mendatang</h2>
        <div class="mt-8 grid gap-4 md:grid-cols-3">
            @forelse ($jadwals as $j)
                <article class="flex gap-4 rounded-2xl bg-white/70 p-5">
                    <div class="h-16 w-16 shrink-0 rounded-xl bg-[#235347] py-2 text-center text-[#DAF1DE]">
                        <div class="text-2xl font-extrabold leading-none">{{ $j->tanggal->format('d') }}</div>
                        <div class="mt-1 text-xs">{{ $j->tanggal->locale('id')->translatedFormat('M') }}</div>
                    </div>
                    <div class="min-w-0">
                        <h3 class="truncate font-bold text-[#0B2B26]">{{ $j->kegiatan->judul }}</h3>
                        <p class="text-sm text-[#163832]">{{ substr($j->jam_mulai, 0, 5) }} - {{ substr($j->jam_selesai, 0, 5) }} WIB</p>
                        <p class="truncate text-sm text-[#163832]">{{ $j->lokasi }}</p>
                    </div>
                </article>
            @empty
                <p class="md:col-span-3 rounded-2xl border border-dashed border-[#235347] p-8 text-center text-[#163832]">Belum ada jadwal mendatang. Cek lagi nanti.</p>
            @endforelse
        </div>
    </div>
</section>

{{-- FAQ --}}
<section id="faq" class="mx-auto max-w-3xl px-4 py-16 sm:px-6" x-data="{ open: 0 }">
    <h2 class="text-2xl font-bold text-[#0B2B26] sm:text-3xl">Pertanyaan umum</h2>
    <div class="mt-8 divide-y divide-[#8EB69B] rounded-2xl border border-[#8EB69B] bg-white/50">
        @foreach ([
            ['Kenapa NIK saya tidak bisa dipakai mendaftar?', 'NIK harus lebih dulu didata oleh kader Posyandu. Hubungi kader di lingkungan Anda.'],
            ['Bisakah saya membatalkan pendaftaran?', 'Bisa, selama kegiatan belum dimulai. Kursi Anda otomatis dilepas untuk warga lain.'],
            ['Siapa yang bisa melihat riwayat kesehatan saya?', 'Anda sendiri dan kader Posyandu. Warga lain tidak bisa melihatnya.'],
        ] as $i => [$tanya, $jawab])
            <div>
                <button @click="open = open === {{ $i }} ? null : {{ $i }}" class="flex w-full items-center justify-between gap-4 px-5 py-4 text-left font-semibold text-[#0B2B26]">
                    {{ $tanya }}
                    <span class="text-xl text-[#235347]" x-text="open === {{ $i }} ? '−' : '+'"></span>
                </button>
                <p x-show="open === {{ $i }}" x-cloak class="px-5 pb-4 text-sm text-[#163832]">{{ $jawab }}</p>
            </div>
        @endforeach
    </div>
</section>

{{-- CTA --}}
<section class="px-4 pb-16 sm:px-6">
    <div class="mx-auto flex max-w-6xl flex-col items-center justify-between gap-4 rounded-3xl bg-[#235347] px-8 py-8 text-center text-[#DAF1DE] md:flex-row md:text-left">
        <h2 class="text-2xl font-bold">Siap memantau kesehatan keluarga?</h2>
        <a href="{{ route('register') }}" class="rounded-xl bg-[#DAF1DE] px-6 py-3 text-sm font-bold text-[#0B2B26] hover:bg-[#8EB69B]">Buat akun warga</a>
    </div>
</section>

{{-- Footer --}}
<footer class="bg-[#051F20] text-[#8EB69B]">
    <div class="mx-auto flex max-w-6xl flex-col justify-between gap-6 px-4 py-10 text-sm sm:px-6 md:flex-row">
        <div>
            <p class="font-bold text-[#DAF1DE]">Posyandu Digital</p>
            <p class="mt-1 max-w-xs">Sistem informasi pencatatan kegiatan dan pemeriksaan Posyandu.</p>
        </div>
        <div class="space-y-1">
            <a href="#layanan" class="block hover:text-[#DAF1DE]">Layanan</a>
            <a href="#jadwal" class="block hover:text-[#DAF1DE]">Jadwal</a>
            <a href="{{ route('login') }}" class="block hover:text-[#DAF1DE]">Masuk</a>
        </div>
        <p class="md:text-right">Proyek Praktikum Pemrograman Web II<br>&copy; {{ date('Y') }}</p>
    </div>
</footer>

</body>
</html>