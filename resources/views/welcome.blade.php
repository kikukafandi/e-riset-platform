<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Platform E-Riset DJBC</title>

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+3:wght@400;500;600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        navy: '#0F2A44',
                        gold: '#D4AF37',
                        slate: {
                            950: '#0A1A2C'
                        }
                    },
                    fontFamily: {
                        sans: ['"Source Sans 3"', 'ui-sans-serif', 'system-ui']
                    }
                }
            }
        };
    </script>

    <style>
        body {
            font-family: 'Source Sans 3', sans-serif;
        }
    </style>
</head>
<body class="bg-slate-50 text-slate-900">
    @php
        $metrics = $metrics ?? [
            'active_requests' => 0,
            'average_sla_days' => null,
            'institutions_served' => 0,
            'archived_docs' => 0,
        ];
    @endphp
    <header class="sticky top-0 z-30">
        <nav id="main-nav" class="transition-all duration-300">
            <div class="mx-auto flex max-w-6xl items-center justify-between px-4 py-4 lg:px-6">
                <div class="flex items-center gap-2">
                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy text-white font-semibold">DJ</div>
                    <div>
                        <p class="text-sm font-semibold text-gold tracking-wide">DIREKTORAT JENDERAL</p>
                        <p class="text-base font-bold text-navy leading-tight">Bea dan Cukai</p>
                    </div>
                </div>
                <div class="hidden items-center gap-8 text-sm font-semibold text-slate-800 lg:flex">
                    <a href="#beranda" class="hover:text-navy">Beranda</a>
                    <a href="#tentang" class="hover:text-navy">Tentang Platform</a>
                    <a href="#alur" class="hover:text-navy">Alur Permohonan</a>
                    <a href="{{ route('login') }}" class="rounded-full bg-navy px-4 py-2 text-white hover:bg-slate-950">Ajukan Permohonan</a>
                </div>
                <button id="menu-toggle" class="inline-flex items-center rounded-md border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-800 lg:hidden" aria-label="Toggle menu">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 6h16M4 12h16M4 18h16" /></svg>
                </button>
            </div>
            <div id="mobile-menu" class="hidden border-t border-slate-200 bg-white lg:hidden">
                <div class="mx-auto flex max-w-6xl flex-col gap-3 px-4 py-3 text-sm font-semibold text-slate-800">
                    <a href="#beranda" class="hover:text-navy">Beranda</a>
                    <a href="#tentang" class="hover:text-navy">Tentang Platform</a>
                    <a href="#alur" class="hover:text-navy">Alur Permohonan</a>
                    <a href="{{ route('login') }}" class="rounded-full bg-navy px-4 py-2 text-white text-center hover:bg-slate-950">Ajukan Permohonan</a>
                </div>
            </div>
        </nav>
    </header>

    <main>
        <section id="beranda" class="relative overflow-hidden bg-gradient-to-br from-navy via-slate-900 to-slate-950 text-white">
            <div class="absolute inset-0 bg-[radial-gradient(circle_at_20%_20%,rgba(212,175,55,0.10),transparent_35%)]"></div>
            <div class="relative mx-auto flex max-w-6xl flex-col gap-10 px-4 py-20 lg:flex-row lg:items-center lg:px-6 lg:py-24">
                <div class="space-y-6 lg:w-3/5">
                    <p class="text-sm font-semibold uppercase tracking-[0.3em] text-gold">Platform Resmi DJBC</p>
                    <h1 class="text-3xl font-bold leading-tight sm:text-4xl lg:text-5xl">Platform E-Riset Direktorat Jenderal Bea dan Cukai</h1>
                    <p class="max-w-2xl text-lg text-slate-200">Sistem digital untuk pengajuan dan pengelolaan permohonan riset serta permintaan data secara terintegrasi, transparan, dan akuntabel.</p>
                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                        <a href="{{ route('login') }}" class="rounded-full bg-gold px-6 py-3 text-base font-semibold text-slate-900 shadow-lg shadow-amber-200/30 hover:bg-[#c49c2f]">Ajukan Permohonan Riset</a>
                    </div>
                </div>
                <div class="lg:w-2/5">
                    <div class="rounded-2xl border border-white/10 bg-white/5 p-6 shadow-2xl backdrop-blur">
                        <div class="flex items-center justify-between border-b border-white/10 pb-4">
                            <div>
                                <p class="text-xs uppercase tracking-widest text-gold">Ringkasan</p>
                                <p class="text-lg font-semibold">Pengelolaan Permohonan Riset</p>
                            </div>
                            <span class="rounded-full bg-white/10 px-3 py-1 text-xs font-semibold text-white">Realtime</span>
                        </div>
                        <div class="mt-4 grid grid-cols-2 gap-4 text-slate-100">
                            <div class="rounded-lg bg-white/5 p-4">
                                <p class="text-sm text-slate-200">Permohonan Aktif</p>
                                <p class="text-2xl font-bold text-gold">{{ number_format($metrics['active_requests'] ?? 0) }}</p>
                            </div>
                            <div class="rounded-lg bg-white/5 p-4">
                                <p class="text-sm text-slate-200">Rata-rata SLA</p>
                                <p class="text-2xl font-bold text-white">
                                    @if(!is_null($metrics['average_sla_days']))
                                        {{ round($metrics['average_sla_days'], 1) }} hari
                                    @else
                                        N/A
                                    @endif
                                </p>
                            </div>
                            <div class="rounded-lg bg-white/5 p-4">
                                <p class="text-sm text-slate-200">Institusi Terlayani</p>
                                <p class="text-2xl font-bold text-white">{{ number_format($metrics['institutions_served'] ?? 0) }}</p>
                            </div>
                            <div class="rounded-lg bg-white/5 p-4">
                                <p class="text-sm text-slate-200">Dokumen Terarsip</p>
                                <p class="text-2xl font-bold text-gold">{{ number_format($metrics['archived_docs'] ?? 0) }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="tentang" class="mx-auto max-w-6xl px-4 py-16 lg:px-6">
            <div class="grid gap-10 lg:grid-cols-3 lg:items-center">
                <div class="lg:col-span-1">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-navy">Tentang Platform</p>
                    <h2 class="mt-4 text-2xl font-bold text-slate-900 lg:text-3xl">Sistem resmi untuk pengajuan riset yang kredibel dan terintegrasi</h2>
                    <p class="mt-4 text-base text-slate-700">Platform E-Riset DJBC memfasilitasi pengajuan permohonan riset dan permintaan data oleh mahasiswa maupun peneliti eksternal, sekaligus mendukung pengelolaan internal oleh petugas DJBC secara transparan dan efisien.</p>
                </div>
                <div class="lg:col-span-2 grid gap-6 md:grid-cols-2">
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3 text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3.75 5.25h16.5M3.75 9.75h16.5M3.75 14.25h9.75M3.75 18.75h9.75" /></svg>
                            <h3 class="text-lg font-semibold">Digitalisasi Pengajuan</h3>
                        </div>
                        <p class="mt-3 text-sm text-slate-600">Pengajuan, verifikasi, hingga penerbitan surat keputusan dilakukan penuh secara digital dengan jejak audit yang jelas.</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3 text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.75a3 3 0 100 6 3 3 0 000-6z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19.5 12a7.5 7.5 0 11-15 0 7.5 7.5 0 0115 0z" /></svg>
                            <h3 class="text-lg font-semibold">Transparansi Proses</h3>
                        </div>
                        <p class="mt-3 text-sm text-slate-600">Status permohonan dapat dipantau oleh pemohon dan petugas, memastikan keterbukaan setiap tahap.</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3 text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 6.75h15M4.5 12h15M4.5 17.25H12" /></svg>
                            <h3 class="text-lg font-semibold">Efisiensi Verifikasi</h3>
                        </div>
                        <p class="mt-3 text-sm text-slate-600">Alur verifikasi berlapis dengan notifikasi terarah mempersingkat waktu proses persetujuan.</p>
                    </div>
                    <div class="rounded-xl border border-slate-200 bg-white p-6 shadow-sm">
                        <div class="flex items-center gap-3 text-navy">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.75v4.5m0 0v4.5m0-4.5h4.5m-4.5 0H7.5" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 5.25h15a.75.75 0 01.75.75v12a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-12a.75.75 0 01.75-.75z" /></svg>
                            <h3 class="text-lg font-semibold">Dokumen Terpusat</h3>
                        </div>
                        <p class="mt-3 text-sm text-slate-600">Proposal, kuisioner, hingga surat keputusan tersimpan aman dan mudah ditelusuri.</p>
                    </div>
                </div>
            </div>
        </section>

        <section id="alur" class="bg-white py-16">
            <div class="mx-auto max-w-6xl px-4 lg:px-6">
                <div class="text-center">
                    <p class="text-sm font-semibold uppercase tracking-[0.25em] text-navy">Alur Permohonan Riset</p>
                    <h2 class="mt-3 text-3xl font-bold text-slate-900">Langkah Resmi dan Terstruktur</h2>
                    <p class="mt-3 text-base text-slate-600">Memastikan setiap permohonan diproses dengan standar layanan DJBC.</p>
                </div>
                <div class="mt-10 grid gap-6 md:grid-cols-2 lg:grid-cols-4">
                    <div class="relative rounded-xl border border-slate-200 bg-slate-50 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy text-white">1</div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 6.75h15m-15 4.5h15m-15 4.5h9.75" /></svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Pemohon mengajukan permohonan</h3>
                        <p class="mt-2 text-sm text-slate-600">Registrasi akun dan isi formulir permohonan riset sesuai ketentuan.</p>
                    </div>
                    <div class="relative rounded-xl border border-slate-200 bg-slate-50 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy text-white">2</div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12h3.75M9 15h3.75M9 9h6.75M9 6h6.75M4.5 12h.008v.008H4.5V12zM4.5 15h.008v.008H4.5V15zM4.5 9h.008v.008H4.5V9zM4.5 6h.008v.008H4.5V6z" /></svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Unggah dokumen</h3>
                        <p class="mt-2 text-sm text-slate-600">Proposal, kuisioner, surat rekomendasi, dan dokumen pendukung lainnya.</p>
                    </div>
                    <div class="relative rounded-xl border border-slate-200 bg-slate-50 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy text-white">3</div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.75l7.5 10.5h-15L12 6.75z" /></svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Verifikasi petugas DJBC</h3>
                        <p class="mt-2 text-sm text-slate-600">Pemeriksaan kelengkapan dokumen, kesesuaian tema riset, dan kepatuhan.</p>
                    </div>
                    <div class="relative rounded-xl border border-slate-200 bg-slate-50 p-6">
                        <div class="flex items-center justify-between">
                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-navy text-white">4</div>
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-navy" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12.75l2.25 2.25L15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        </div>
                        <h3 class="mt-4 text-lg font-semibold text-slate-900">Persetujuan atau penolakan</h3>
                        <p class="mt-2 text-sm text-slate-600">Hasil disampaikan secara resmi dan dapat diunduh dalam bentuk surat keputusan.</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="mx-auto max-w-6xl px-4 py-16 lg:px-6">
            <div class="text-center">
                <p class="text-sm font-semibold uppercase tracking-[0.25em] text-navy">Jenis Pengguna</p>
                <h2 class="mt-3 text-3xl font-bold text-slate-900">Peran Pemohon dan Petugas</h2>
                <p class="mt-3 text-base text-slate-600">Didesain untuk kebutuhan mahasiswa, peneliti, dan petugas DJBC.</p>
            </div>
            <div class="mt-10 grid gap-6 md:grid-cols-2">
                <div class="rounded-xl border border-slate-200 bg-white p-7 shadow-sm">
                    <div class="flex items-center gap-3 text-navy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 12.75c1.864 0 3.375-1.511 3.375-3.375S13.864 6 12 6 8.625 7.511 8.625 9.375 10.136 12.75 12 12.75z" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M6.75 20.25a5.25 5.25 0 0110.5 0" /></svg>
                        <h3 class="text-lg font-semibold">Pemohon (Mahasiswa & Peneliti)</h3>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">Mengajukan permohonan, mengunggah dokumen, memantau status, serta menerima surat keputusan secara daring.</p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        <li class="flex items-start gap-2"><span class="mt-1 inline-block h-2 w-2 rounded-full bg-gold"></span>Dashboard status permohonan</li>
                        <li class="flex items-start gap-2"><span class="mt-1 inline-block h-2 w-2 rounded-full bg-gold"></span>Notifikasi tahap verifikasi</li>
                        <li class="flex items-start gap-2"><span class="mt-1 inline-block h-2 w-2 rounded-full bg-gold"></span>Unduh surat keputusan resmi</li>
                    </ul>
                </div>
                <div class="rounded-xl border border-slate-200 bg-white p-7 shadow-sm">
                    <div class="flex items-center gap-3 text-navy">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.75v3.75m0 0v3.75m0-3.75h3.75M12 10.5H8.25" /><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4.5 5.25h15a.75.75 0 01.75.75v12a.75.75 0 01-.75.75h-15a.75.75 0 01-.75-.75v-12a.75.75 0 01.75-.75z" /></svg>
                        <h3 class="text-lg font-semibold">Petugas DJBC</h3>
                    </div>
                    <p class="mt-3 text-sm text-slate-600">Melakukan verifikasi, memberikan catatan, menerbitkan persetujuan atau penolakan dengan standar pelayanan DJBC.</p>
                    <ul class="mt-4 space-y-2 text-sm text-slate-700">
                        <li class="flex items-start gap-2"><span class="mt-1 inline-block h-2 w-2 rounded-full bg-gold"></span>Manajemen antrian permohonan</li>
                        <li class="flex items-start gap-2"><span class="mt-1 inline-block h-2 w-2 rounded-full bg-gold"></span>Checklist kelengkapan dokumen</li>
                        <li class="flex items-start gap-2"><span class="mt-1 inline-block h-2 w-2 rounded-full bg-gold"></span>Output surat keputusan terstandar</li>
                    </ul>
                </div>
            </div>
        </section>

        <section id="cta" class="bg-navy py-16 text-white">
            <div class="mx-auto flex max-w-6xl flex-col items-center gap-6 px-4 text-center lg:px-6">
                {{-- <p class="text-sm font-semibold uppercase tracking-[0.25em] text-gold">Call To Action</p> --}}
                <h2 class="text-3xl font-bold lg:text-4xl">Ajukan Permohonan Riset Anda Secara Resmi dan Terintegrasi</h2>
                <p class="max-w-3xl text-base text-slate-200">Gunakan platform resmi DJBC untuk memastikan proses permohonan riset berjalan sesuai ketentuan, cepat, dan terdokumentasi dengan baik.</p>
                <div class="flex flex-col gap-3 sm:flex-row sm:items-center">
                    <a href="{{ route('login') }}" class="rounded-full bg-gold px-6 py-3 text-base font-semibold text-slate-900 shadow-lg shadow-amber-200/30 hover:bg-[#c49c2f]">Ajukan Sekarang</a>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-slate-200 bg-white py-8">
        <div class="mx-auto flex max-w-6xl flex-col gap-4 px-4 text-sm text-slate-700 lg:flex-row lg:items-center lg:justify-between lg:px-6">
            <div>
                <p class="font-semibold text-navy">Direktorat Jenderal Bea dan Cukai</p>
                <p class="text-slate-600">Platform E-Riset DJBC &copy; 2025</p>
            </div>
            <div class="flex gap-4 text-slate-600">
                <span>Jl. Jalan ke pasar malam </span>
                <span class="hidden lg:inline">|</span>
                <span>Kontak: informasi@beacukai.go.id</span>
            </div>
        </div>
    </footer>

    <script>
        const nav = document.getElementById('main-nav');
        const menuToggle = document.getElementById('menu-toggle');
        const mobileMenu = document.getElementById('mobile-menu');

        const handleNavStyle = () => {
            if (window.scrollY > 10) {
                nav.classList.add('bg-white/95', 'shadow-md', 'backdrop-blur');
            } else {
                nav.classList.remove('bg-white/95', 'shadow-md', 'backdrop-blur');
            }
        };

        handleNavStyle();
        window.addEventListener('scroll', handleNavStyle);

        menuToggle.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });
    </script>
</body>
</html>