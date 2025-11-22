<div id="layoutSidenav_nav">
    <nav class="sb-sidenav accordion sb-sidenav-dark" id="sidenavAccordion">
        <div class="sb-sidenav-menu">
            <div class="nav">

                {{-- Menu untuk Petugas --}}
                @if (Auth::guard('petugas')->check())
                    <div class="sb-sidenav-menu-heading">Petugas</div>
                    <a class="nav-link" href="{{ route('dashboard.petugas') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>

                    {{-- Role super_user --}}
                    @if (Auth::guard('petugas')->user()->role === 'super_user')
                        <a class="nav-link" href="{{ route('manage.petugas') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-users-cog"></i></div>
                            Kelola Petugas
                        </a>

                        <a class="nav-link" href="{{ route('manage.topik.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-bookmark"></i></div>
                            Kelola Topik Riset
                        </a>

                        <a class="nav-link" href="{{ route('manage.kantor.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-building"></i></div>
                            Kelola Kantor Bea Cukai
                        </a>

                        <a class="nav-link" href="{{ route('statistics.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-chart-bar"></i></div>
                            Dashboard Statistik
                        </a>

                        <a class="nav-link" href="{{ route('research.completion.dashboard') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-tasks"></i></div>
                            Monitor Penyelesaian Riset
                        </a>
                    @endif

                    {{-- Role pelaksana --}}
                    @if (Auth::guard('petugas')->user()->role === 'pelaksana')
                        <a class="nav-link" href="{{ route('dokumen.index') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-file-alt"></i></div>
                            Verifikasi Dokumen
                        </a>
                    @endif

                    {{-- Role eselon iv --}}
                    @if (Auth::guard('petugas')->user()->role === 'eselon_iv')
                        <a class="nav-link" href="{{ route('dokumen.disposisi.iv') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-share-square"></i></div>
                            Disposisi ke Eselon III
                        </a>
                    @endif

                    {{-- Role eselon iii --}}
                    @if (Auth::guard('petugas')->user()->role === 'eselon_iii')
                        <a class="nav-link" href="{{ route('dokumen.disposisi.iii') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-share-square"></i></div>
                            Disposisi ke Eselon II
                        </a>
                    @endif

                    {{-- Role eselon ii --}}
                    @if (Auth::guard('petugas')->user()->role === 'eselon_ii')
                        <a class="nav-link" href="{{ route('dokumen.ttd') }}">
                            <div class="sb-nav-link-icon"><i class="fas fa-signature"></i></div>
                            Tanda Tangan Dokumen
                        </a>
                    @endif
                @endif


                {{-- Menu untuk Mahasiswa / Non-Mahasiswa (User biasa) --}}
                @if (Auth::guard('web')->check())
                    <div class="sb-sidenav-menu-heading">Periset</div>
                    <a class="nav-link" href="{{ route('dashboardPage') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-tachometer-alt"></i></div>
                        Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('dashboardPengajuan') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-upload"></i></div>
                        Ajukan Dokumen Riset
                    </a>
                    <a class="nav-link" href="{{ route('dokumen.status') }}">
                        <div class="sb-nav-link-icon"><i class="fas fa-list"></i></div>
                        Status Pengajuan
                    </a>
                @endif

            </div>
        </div>

        <div class="sb-sidenav-footer">
            <div class="small">Logged in as:</div>
            @if (Auth::guard('web')->check())
                {{ Auth::guard('web')->user()->nama_lengkap }}
            @elseif (Auth::guard('petugas')->check())
                {{ Auth::guard('petugas')->user()->nama }}
            @endif
        </div>
    </nav>
</div>
