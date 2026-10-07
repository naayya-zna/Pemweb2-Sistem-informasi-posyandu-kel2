```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ $title ?? 'Beranda' }} · Posyandu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 text-slate-800 antialiased">

<<<<<<< HEAD
    <header
        x-data="{
            user: null,

            async logout() {
                try {
                    await api('/auth/logout', {
                        method: 'POST'
                    });
                } catch (e) {}

                auth.clear();
                window.location.href = '/login';
            }
        }"
        x-init="getMe().then(u => user = u).catch(() => {})"
        class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur"
    >

        <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">

            {{-- Logo --}}
            <a href="/" class="flex items-center gap-2 shrink-0">

                <span
                    class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 text-lg font-bold text-white"
                >
                    P
                </span>

                <span class="hidden text-base font-semibold text-slate-900 sm:block">
                    Posyandu
                </span>

            </a>


            {{-- Navbar --}}
            <nav class="flex flex-1 items-center gap-1 overflow-x-auto">

                {{-- Warga --}}
                <a
                    href="{{ route('warga.index') }}"
                    class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium
                    {{ request()->routeIs('warga.*')
                        ? 'bg-emerald-50 text-emerald-700'
                        : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Warga
                </a>


                {{-- Kegiatan --}}
                <a
                    href="{{ route('kegiatan.index') }}"
                    class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium
                    {{ request()->routeIs('kegiatan.*')
                        ? 'bg-emerald-50 text-emerald-700'
                        : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Kegiatan
                </a>


                {{-- Jadwal --}}
                <a
                    href="{{ route('jadwal.index') }}"
                    class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium
                    {{ request()->routeIs('jadwal.*')
                        ? 'bg-emerald-50 text-emerald-700'
                        : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Jadwal
                </a>


                {{-- Pemeriksaan --}}
                <a
                    href="{{ route('pemeriksaan.index') }}"
                    class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium
                    {{ request()->routeIs('pemeriksaan.*')
                        ? 'bg-emerald-50 text-emerald-700'
                        : 'text-slate-600 hover:bg-slate-100' }}"
                >
                    Pemeriksaan
                </a>

            </nav>


            {{-- User --}}
            <div
                x-show="user"
                x-cloak
                class="flex shrink-0 items-center gap-3"
            >

                {{-- Nama dan Role --}}
                <div class="hidden text-right sm:block">

                    <p
                        class="text-sm font-medium leading-tight text-slate-900"
                        x-text="user?.name"
                    ></p>

                    <p
                        class="text-xs capitalize text-slate-500"
                        x-text="user?.role"
                    ></p>

                </div>


                {{-- Avatar --}}
                <span
                    class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700"
                    x-text="(user?.name || '?').charAt(0).toUpperCase()"
                ></span>


                {{-- Logout --}}
                <button
                    @click="logout()"
                    class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-600 transition hover:bg-slate-100"
                >
                    Keluar
                </button>

            </div>

        </div>

    </header>


    {{-- Konten Halaman --}}
    <main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

        {{ $slot }}

    </main>


    {{-- Toast Notification --}}
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

        <template
            x-for="t in items"
            :key="t.id"
        >

            <div
                x-transition

                class="pointer-events-auto w-full max-w-sm rounded-xl px-4 py-3 text-sm font-medium shadow-lg ring-1"

                :class="
                    t.type === 'error'
                        ? 'bg-rose-50 text-rose-800 ring-rose-200'
                        : 'bg-emerald-50 text-emerald-800 ring-emerald-200'
                "

                x-text="t.message"
            ></div>

        </template>

    </div>

</body>
</html>
```
=======
<header
    x-data="{
        user: null,
        async logout() {
            try { 
                await api('/auth/logout', { method: 'POST' }); 
            } catch (e) {}

            auth.clear();
            window.location.href = '/login';
        }
    }"

    x-init="getMe().then(u => user = u).catch(() => {})"

    class="sticky top-0 z-30 border-b border-slate-200 bg-white/90 backdrop-blur"
>

    <div class="mx-auto flex max-w-7xl items-center gap-4 px-4 py-3 sm:px-6 lg:px-8">


        {{-- Logo --}}
        <a href="/" class="flex items-center gap-2">

            <span class="flex h-9 w-9 items-center justify-center rounded-xl bg-emerald-600 text-lg font-bold text-white">
                P
            </span>

            <span class="hidden text-base font-semibold text-slate-900 sm:block">
                Posyandu
            </span>

        </a>



        {{-- Menu --}}
        <nav class="flex flex-1 items-center gap-1 overflow-x-auto">


            {{-- Jadwal --}}
            <a href="{{ route('jadwal.index') }}"
               class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium
               {{ request()->routeIs('jadwal.*')
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'text-slate-600 hover:bg-slate-100' }}">

                Jadwal

            </a>



            {{-- Kegiatan --}}
            <a href="{{ route('kegiatan.index') }}"
               class="whitespace-nowrap rounded-lg px-3 py-1.5 text-sm font-medium
               {{ request()->routeIs('kegiatan.*')
                    ? 'bg-emerald-50 text-emerald-700'
                    : 'text-slate-600 hover:bg-slate-100' }}">

                Kegiatan

            </a>



        </nav>




        {{-- User --}}
        <div x-show="user" x-cloak class="flex items-center gap-3">


            <div class="hidden text-right sm:block">

                <p class="text-sm font-medium leading-tight text-slate-900"
                   x-text="user?.name">
                </p>


                <p class="text-xs capitalize text-slate-500"
                   x-text="user?.role">
                </p>

            </div>



            <span
                class="flex h-9 w-9 items-center justify-center rounded-full bg-emerald-100 text-sm font-semibold text-emerald-700"

                x-text="(user?.name || '?').charAt(0).toUpperCase()">
            </span>



            <button
                @click="logout()"

                class="rounded-lg border border-slate-200 px-3 py-1.5 text-sm text-slate-600 transition hover:bg-slate-100">

                Keluar

            </button>


        </div>


    </div>


</header>




{{-- Content --}}
<main class="mx-auto max-w-7xl px-4 py-8 sm:px-6 lg:px-8">

    {{ $slot }}

</main>





{{-- Toast --}}
<div x-data="{ items: [], n: 0 }"

     @toast.window="
        const id = ++n;
        items.push({ id, ...$event.detail });
        setTimeout(() => items = items.filter(i => i.id !== id), 4000);
     "

     class="pointer-events-none fixed inset-x-4 top-4 z-50 flex flex-col items-end gap-2">


    <template x-for="t in items" :key="t.id">


        <div x-transition

             class="pointer-events-auto w-full max-w-sm rounded-xl px-4 py-3 text-sm font-medium shadow-lg ring-1"

             :class="t.type === 'error'
                ? 'bg-rose-50 text-rose-800 ring-rose-200'
                : 'bg-emerald-50 text-emerald-800 ring-emerald-200'"

             x-text="t.message">

        </div>


    </template>


</div>


</body>
</html>
>>>>>>> upstream/main
