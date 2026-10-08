
<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Daftar · Posyandu</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="flex min-h-screen items-center justify-center bg-slate-50 px-4 py-8 text-slate-800 antialiased">

    <div
        class="w-full max-w-sm"
        x-data="registerForm()"
    >

        {{-- =========================
             HEADER
        ========================== --}}
        <div class="mb-6 text-center">

            <a href="{{ route('home') }}">
                <span
                    class="mx-auto mb-3 flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-600 text-2xl font-bold text-white"
                >
                    P
                </span>
            </a>

            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Daftar Akun Warga
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                NIK harus sudah didaftarkan oleh kader Posyandu.
            </p>

        </div>


        {{-- =========================
             FORM REGISTER
        ========================== --}}
        <form
            @submit.prevent="submit()"
            class="space-y-4 rounded-2xl border border-slate-200 bg-white p-6 shadow-sm"
        >

            {{-- Error umum --}}
            <div
                x-show="error"
                x-cloak
                class="rounded-lg bg-rose-50 px-3 py-2 text-sm text-rose-700"
                x-text="error"
            ></div>


            {{-- Nama --}}
            <div>

                <label
                    for="name"
                    class="block text-sm font-medium text-slate-700"
                >
                    Nama
                </label>

                <input
                    id="name"
                    type="text"
                    x-model="f.name"
                    required
                    autocomplete="name"
                    class="mt-1 block w-full rounded-lg border border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                >

                <p
                    class="mt-1 text-xs text-rose-600"
                    x-show="errors.name"
                    x-text="errors.name?.[0]"
                ></p>

            </div>


            {{-- NIK --}}
            <div>

                <label
                    for="nik"
                    class="block text-sm font-medium text-slate-700"
                >
                    NIK (16 digit)
                </label>

                <input
                    id="nik"
                    type="text"
                    x-model="f.nik"
                    required
                    maxlength="16"
                    minlength="16"
                    inputmode="numeric"
                    autocomplete="off"
                    class="mt-1 block w-full rounded-lg border border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                >

                <p
                    class="mt-1 text-xs text-rose-600"
                    x-show="errors.nik"
                    x-text="errors.nik?.[0]"
                ></p>

            </div>


            {{-- Email --}}
            <div>

                <label
                    for="email"
                    class="block text-sm font-medium text-slate-700"
                >
                    Email
                </label>

                <input
                    id="email"
                    type="email"
                    x-model="f.email"
                    required
                    autocomplete="email"
                    class="mt-1 block w-full rounded-lg border border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                >

                <p
                    class="mt-1 text-xs text-rose-600"
                    x-show="errors.email"
                    x-text="errors.email?.[0]"
                ></p>

            </div>


            {{-- Password --}}
            <div>

                <label
                    for="password"
                    class="block text-sm font-medium text-slate-700"
                >
                    Password
                </label>

                <input
                    id="password"
                    type="password"
                    x-model="f.password"
                    required
                    minlength="8"
                    autocomplete="new-password"
                    class="mt-1 block w-full rounded-lg border border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                >

                <p
                    class="mt-1 text-xs text-rose-600"
                    x-show="errors.password"
                    x-text="errors.password?.[0]"
                ></p>

            </div>


            {{-- Konfirmasi Password --}}
            <div>

                <label
                    for="password_confirmation"
                    class="block text-sm font-medium text-slate-700"
                >
                    Ulangi password
                </label>

                <input
                    id="password_confirmation"
                    type="password"
                    x-model="f.password_confirmation"
                    required
                    minlength="8"
                    autocomplete="new-password"
                    class="mt-1 block w-full rounded-lg border border-slate-300 text-sm shadow-sm focus:border-emerald-500 focus:ring-emerald-500"
                >

                <p
                    class="mt-1 text-xs text-rose-600"
                    x-show="errors.password_confirmation"
                    x-text="errors.password_confirmation?.[0]"
                ></p>

            </div>


            {{-- Tombol Daftar --}}
            <button
                type="submit"
                :disabled="loading"
                class="w-full rounded-lg bg-emerald-600 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700 disabled:cursor-not-allowed disabled:opacity-60"
            >

                <span
                    x-text="loading ? 'Memproses...' : 'Daftar'"
                ></span>

            </button>


            {{-- Login --}}
            <p class="text-center text-sm text-slate-500">

                Sudah punya akun?

                <a
                    href="{{ route('login') }}"
                    class="font-medium text-emerald-700 hover:underline"
                >
                    Masuk
                </a>

            </p>

        </form>

    </div>


    {{-- =========================
         REGISTER SCRIPT
    ========================== --}}
    <script>
        function registerForm() {

            return {

                f: {
                    name: '',
                    nik: '',
                    email: '',
                    password: '',
                    password_confirmation: ''
                },

                loading: false,
                error: '',
                errors: {},


                async submit() {

                    this.loading = true;
                    this.error = '';
                    this.errors = {};

                    try {

                        const csrfToken =
                            document.querySelector(
                                'meta[name="csrf-token"]'
                            )?.content ?? '';


                        const res = await fetch(
                            '/api/auth/register',
                            {
                                method: 'POST',

                                headers: {
                                    'Accept': 'application/json',
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': csrfToken,
                                    'X-Requested-With': 'XMLHttpRequest'
                                },

                                credentials: 'same-origin',

                                body: JSON.stringify(this.f)
                            }
                        );


                        const json =
                            await res.json().catch(() => ({}));


                        console.log(
                            'Status register:',
                            res.status
                        );

                        console.log(
                            'Response register:',
                            json
                        );


                        {{-- =========================
                             VALIDASI RESPONSE
                        ========================== --}}
                        if (!res.ok) {

                            if (res.status === 422) {

                                this.errors =
                                    json.errors ?? {};

                                this.error =
                                    json.message ??
                                    'Data registrasi tidak valid.';

                            } else {

                                this.error =
                                    json.message ??
                                    'Terjadi kesalahan pada server.';

                            }

                            return;
                        }


                        {{-- =========================
                             REGISTER BERHASIL
                        ========================== --}}

                        /*
                         * Jangan menyimpan token.
                         * Jangan menjalankan syncSession().
                         *
                         * Setelah akun berhasil dibuat,
                         * user diarahkan ke halaman Login.
                         */

                        console.log(
                            'Registrasi berhasil.'
                        );


                        window.location.href =
                            "{{ route('login') }}";

                    } catch (e) {

                        console.error(
                            'Error register:',
                            e
                        );

                        this.error =
                            'Tidak dapat terhubung ke server. Silakan coba lagi.';

                    } finally {

                        this.loading = false;

                    }

                }

            };

        }
    </script>

</body>
</html>

