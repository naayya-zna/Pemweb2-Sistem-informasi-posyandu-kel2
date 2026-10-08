
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? 'Beranda' }} · Posyandu</title>

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap"
        rel="stylesheet"
    >

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }

        body {
            font-family: 'Plus Jakarta Sans', system-ui, sans-serif;
        }
    </style>
</head>

@php
    /*
    |--------------------------------------------------------------------------
    | Menu Navigasi
    |--------------------------------------------------------------------------
    */

    $allMenu = [
        [
            'label' => 'Data Warga',
            'url' => route('warga.index'),
            'active' => request()->routeIs('warga.*'),
            'roles' => ['admin', 'kader'],
        ],

        [
            'label' => 'Kegiatan',
            'url' => route('kegiatan.index'),
            'active' => request()->routeIs('kegiatan.*'),
            'roles' => ['admin', 'kader', 'warga'],
        ],

        [
            'label' => 'Jadwal',
            'url' => route('jadwal.index'),
            'active' => request()->routeIs('jadwal.*'),
            'roles' => ['admin', 'kader', 'warga'],
        ],

        [
            'label' => 'Pemeriksaan',
            'url' => route('pemeriksaan.index'),
            'active' => request()->routeIs('pemeriksaan.*'),
            'roles' => ['admin', 'kader'],
        ],

        [
            'label' => 'Riwayat Pemeriksaan',
            'url' => route('riwayat.pemeriksaan'),
            'active' => request()->routeIs('riwayat.*'),
            'roles' => ['warga'],
        ],
    ];

    $linkBase =
        'whitespace-nowrap rounded-xl px-4 py-2 text-sm font-semibold transition-all duration-150';

    $linkActive =
        'bg-[#DAF1DE] text-[#051F20] shadow-xs border border-[#8EB69B]/40 font-bold';

    $linkIdle =
        'text-[#163832] hover:bg-[#DAF1DE]/50 hover:text-[#051F20]';

    /*
    |--------------------------------------------------------------------------
    | User Login dari Laravel Session
    |--------------------------------------------------------------------------
    */

    $currentUser = auth()->user();

    $currentUserData = $currentUser
        ? [
            'id' => $currentUser->id,
            'name' => $currentUser->name,
            'role' => strtolower($currentUser->role ?? 'warga'),
        ]
        : null;
@endphp
<body class="min-h-screen bg-[#DAF1DE]/25 text-[#051F20] antialiased">

<header
    x-data="{
        user: @js($currentUserData),
        allMenu: @js($allMenu),
        menuOpen: false,

        get menu() {
            if (!this.user) {
                return [];
            }

            const role = String(this.user.role || 'warga').toLowerCase();

            return this.allMenu.filter(menu =>
                Array.isArray(menu.roles) &&
                menu.roles.includes(role)
            );
        }
    }"

    @keydown.escape.window="menuOpen = false"

    class="sticky top-0 z-30 border-b border-[#DAF1DE] bg-white/95 backdrop-blur-md shadow-xs"
>

    <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">

        <!-- Mobile Menu Toggle -->
        <button
            type="button"
            @click="menuOpen = !menuOpen"
            :aria-expanded="menuOpen"
            aria-label="Buka menu"
            class="-ml-1 rounded-xl p-2 text-[#163832] hover:bg-[#DAF1DE]/60 focus:outline-none focus-visible:ring-2 focus-visible:ring-[#235347] md:hidden"
        >
            <!-- Hamburger -->
            <svg
                x-show="!menuOpen"
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M4 6h16M4 12h16M4 18h16"
                />
            </svg>

            <!-- Close -->
            <svg
                x-show="menuOpen"
                x-cloak
                class="h-6 w-6"
                fill="none"
                viewBox="0 0 24 24"
                stroke="currentColor"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M6 18L18 6M6 6l12 12"
                />
            </svg>
        </button>


        <!-- Brand -->
        <a
            href="{{ route('home') }}"
            class="flex shrink-0 items-center gap-2.5 group"
        >
            <span
                class="flex h-9 w-9 items-center justify-center rounded-xl bg-[#0B2B26] text-lg font-bold text-[#DAF1DE] shadow-xs transition-transform group-hover:scale-105"
            >
                P
            </span>

            <span class="text-base font-extrabold tracking-tight text-[#051F20]">
                Posyandu
            </span>
        </a>


        <!-- Desktop Navigation -->
        <nav class="hidden flex-1 items-center gap-1.5 md:flex ml-4">

            <template x-for="(m, i) in menu" :key="i">

                <a
                    :href="m.url"
                    :class="m.active
                        ? '{{ $linkActive }}'
                        : '{{ $linkIdle }}'"
                    class="{{ $linkBase }}"
                    x-text="m.label"
                ></a>

            </template>

        </nav>


        <!-- Spacer Mobile -->
        <div class="flex-1 md:hidden"></div>


        <!-- User Profile -->
        <div
            x-show="user"
            x-cloak
            class="flex shrink-0 items-center gap-3"
        >

            <!-- Name & Role -->
            <div class="hidden text-right sm:block leading-tight">

                <p
                    class="text-sm font-bold text-[#051F20]"
                    x-text="user?.name"
                ></p>

                <p
                    class="text-xs font-semibold capitalize text-[#7FA08C]"
                    x-text="user?.role || 'User'"
                ></p>

            </div>


            <!-- Avatar -->
            <span
                class="flex h-9 w-9 items-center justify-center rounded-full border border-[#8EB69B]/40 bg-[#DAF1DE] text-sm font-bold text-[#0B2B26]"
                x-text="(user?.name || '?').charAt(0).toUpperCase()"
            ></span>


            <!-- Logout -->
            <form
                method="POST"
                action="{{ route('logout') }}"
                class="m-0"
            >
                @csrf

                <button
                    type="submit"
                    class="rounded-xl border border-[#BCDCC6] bg-white px-3.5 py-1.5 text-xs font-semibold text-[#163832] shadow-2xs transition hover:bg-[#DAF1DE]/60 hover:text-[#051F20]"
                >
                    Keluar
                </button>
            </form>

        </div>


        <!-- Login -->
        <div
            x-show="!user"
            x-cloak
            class="flex items-center gap-2"
        >
            <a
                href="{{ route('login') }}"
                class="rounded-xl px-3.5 py-1.5 text-xs font-semibold text-[#163832] hover:bg-[#DAF1DE]/50"
            >
                Masuk
            </a>
        </div>

    </div>


    <!-- Mobile Navigation -->
    <nav
        x-show="menuOpen"
        x-cloak

        x-transition:enter="transition ease-out duration-200"
        x-transition:enter-start="opacity-0 -translate-y-2"
        x-transition:enter-end="opacity-100 translate-y-0"

        x-transition:leave="transition ease-in duration-150"
        x-transition:leave-start="opacity-100 translate-y-0"
        x-transition:leave-end="opacity-0 -translate-y-2"

        class="border-t border-[#DAF1DE] bg-white px-4 py-3 shadow-md md:hidden"
    >

        <div class="mx-auto flex max-w-7xl flex-col gap-1.5">

            <template x-for="(m, i) in menu" :key="i">

                <a
                    :href="m.url"
                    :class="m.active
                        ? '{{ $linkActive }}'
                        : '{{ $linkIdle }}'"
                    class="{{ $linkBase }} py-2.5"
                    x-text="m.label"
                ></a>

            </template>

        </div>

    </nav>

</header>


<!-- Main Content -->
<main class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8">

    {{ $slot }}

</main>


<!-- Toast Notification -->
<div
    x-data="{ items: [], n: 0 }"

    @toast.window="
        const id = ++n;

        items.push({
            id,
            ...$event.detail
        });

        setTimeout(
            () => items = items.filter(i => i.id !== id),
            4000
        );
    "

    class="pointer-events-none fixed inset-x-4 top-4 z-50 flex flex-col items-end gap-2"
>

    <template x-for="t in items" :key="t.id">

        <div
            x-transition
            class="pointer-events-auto w-full max-w-sm rounded-xl px-4 py-3 text-sm font-semibold shadow-lg ring-1"

            :class="
                t.type === 'error'
                    ? 'bg-rose-50 text-rose-800 ring-rose-200'
                    : 'bg-[#DAF1DE] text-[#051F20] ring-[#8EB69B]'
            "

            x-text="t.message"
        ></div>

    </template>

</div>

</body>
</html>
