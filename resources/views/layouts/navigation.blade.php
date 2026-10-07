<nav style="background: white; border-bottom: 1px solid #ddd;">

    <div style="
        max-width: 1200px;
        margin: auto;
        padding: 0 20px;
        height: 65px;
        display: flex;
        align-items: center;
        justify-content: space-between;
    ">

        <!-- Logo -->
        <div style="display: flex; align-items: center; gap: 30px;">

            <a href="{{ route('dashboard') }}" style="text-decoration: none;">
                <x-application-logo
                    style="height: 36px; width: auto;"
                    class="block h-9 w-auto fill-current text-gray-800"
                />
            </a>

            <!-- Menu -->
            <div style="
                display: flex;
                align-items: center;
                gap: 10px;
            ">

                <a href="{{ route('warga.index') }}"
                   style="
                       text-decoration: none;
                       color: #333;
                       padding: 10px 15px;
                       border-radius: 6px;
                   ">
                    Warga
                </a>

                <a href="{{ route('kegiatan.index') }}"
                   style="
                       text-decoration: none;
                       color: #333;
                       padding: 10px 15px;
                       border-radius: 6px;
                   ">
                    Kegiatan
                </a>

                <a href="{{ route('jadwal.index') }}"
                   style="
                       text-decoration: none;
                       color: #333;
                       padding: 10px 15px;
                       border-radius: 6px;
                   ">
                    Jadwal
                </a>

                <a href="{{ route('pemeriksaan.index') }}"
                   style="
                       text-decoration: none;
                       color: #333;
                       padding: 10px 15px;
                       border-radius: 6px;
                   ">
                    Pemeriksaan
                </a>

            </div>

        </div>


        <!-- User -->
        <div style="
            display: flex;
            align-items: center;
            gap: 15px;
        ">

            <span style="color: #555;">
                {{ Auth::user()?->name ?? 'Guest' }}
            </span>

            @auth
                <form method="POST" action="{{ route('logout') }}">
                    @csrf

                    <button type="submit"
                            style="
                                border: none;
                                background: none;
                                cursor: pointer;
                                color: #555;
                            ">
                        Logout
                    </button>
                </form>
            @endauth

        </div>

    </div>

</nav>
