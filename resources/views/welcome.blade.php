<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>e-Riset Direktorat Jenderal Pajak</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#202c5f', // Navy DJP
                        secondary: '#FFD400', // Kuning DJP
                        accent: '#F3F4F6'
                    },
                    fontFamily: {
                        sans: ['Inter', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
        }

        .tab-content {
            display: none;
            animation: fadeIn 0.5s ease-out;
        }

        .tab-content.active {
            display: block;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Hide Scrollbar for Tabs */
        .scrollbar-hide::-webkit-scrollbar {
            display: none;
        }

        .scrollbar-hide {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }

        /* Carousel CSS */
        .carousel-track {
            display: flex;
            transition: transform 0.5s ease-out;
            cursor: grab;
        }

        .carousel-track:active {
            cursor: grabbing;
        }

        .carousel-slide {
            min-width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
            user-select: none;
        }

        .carousel-slide img {
            pointer-events: none;
        }
    </style>
</head>

<body class="bg-gray-50 text-gray-800 flex flex-col min-h-screen">

    <header class="bg-white/95 backdrop-blur-md shadow-sm fixed w-full top-0 z-50 transition-all">
        <div class="max-w-7xl mx-auto flex justify-between items-center px-4 sm:px-6 lg:px-8 py-3">
            <div class="flex items-center gap-2">
                <div class="bg-primary text-secondary font-bold rounded px-2.5 py-1 text-xl leading-none shadow-sm">e
                </div>
                <span class="font-bold text-xl tracking-tight text-primary">riset</span>
            </div>
            <a href="/login"
                class="text-sm font-semibold text-primary border border-primary px-6 py-2 rounded-full hover:bg-primary hover:text-white transition-all duration-300 shadow-sm">
                Login
            </a>
        </div>
    </header>

    <section class="relative pt-24 pb-32 md:pt-32 md:pb-48 bg-primary overflow-hidden">
        <div
            class="absolute top-0 right-0 -mr-20 -mt-20 w-64 h-64 md:w-96 md:h-96 bg-secondary opacity-10 rounded-full blur-3xl">
        </div>
        <div class="absolute bottom-20 left-10 w-40 h-40 md:w-64 md:h-64 bg-white opacity-5 rounded-full blur-3xl">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-20">

            <div class="relative overflow-hidden rounded-2xl group bg-primary">
                <div class="carousel-track" id="heroCarousel">
                    <div class="carousel-slide">
                        <img src="https://eriset.pajak.go.id/image/slider-eriset-1-new.png" alt="Banner 1"
                            class="w-full h-[200px] sm:h-[300px] md:h-[450px] object-contain bg-primary">
                    </div>
                    <div class="carousel-slide">
                        <img src="https://eriset.pajak.go.id/image/slider-eriset-2-new.svg" alt="Banner 2"
                            class="w-full h-[200px] sm:h-[300px] md:h-[450px] object-contain bg-primary">
                    </div>
                    <div class="carousel-slide">
                        <img src="https://eriset.pajak.go.id/image/slider-eriset-2.svg" alt="Banner 3"
                            class="w-full h-[200px] sm:h-[300px] md:h-[450px] object-contain bg-primary">
                    </div>
                </div>

                <button onclick="moveSlide(-1)"
                    class="absolute left-4 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/40 text-white p-2 rounded-full backdrop-blur-sm transition hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7" />
                    </svg>
                </button>
                <button onclick="moveSlide(1)"
                    class="absolute right-4 top-1/2 -translate-y-1/2 bg-black/20 hover:bg-black/40 text-white p-2 rounded-full backdrop-blur-sm transition hidden md:block">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                    </svg>
                </button>

                <div class="absolute bottom-4 left-1/2 -translate-x-1/2 flex gap-2">
                    <button onclick="goToSlide(0)"
                        class="indicator w-8 h-1 rounded-full bg-white/40 hover:bg-white transition-all duration-300"></button>
                    <button onclick="goToSlide(1)"
                        class="indicator w-8 h-1 rounded-full bg-white/40 hover:bg-white transition-all duration-300"></button>
                    <button onclick="goToSlide(2)"
                        class="indicator w-8 h-1 rounded-full bg-white/40 hover:bg-white transition-all duration-300"></button>
                </div>
            </div>

        </div>

        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none z-10">
            <svg class="relative block w-full h-[40px] sm:h-[60px] md:h-[100px]" xmlns="http://www.w3.org/2000/svg"
                viewBox="0 0 1440 320" preserveAspectRatio="none">
                <path fill="#FFD400" fill-opacity="1"
                    d="M0,224L48,213.3C96,203,192,181,288,181.3C384,181,480,203,576,224C672,245,768,267,864,261.3C960,256,1056,224,1152,197.3C1248,171,1344,149,1392,138.7L1440,128L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z">
                </path>
            </svg>
        </div>
    </section>

    <section class="relative -mt-16 md:-mt-24 z-30 pb-12 px-4 sm:px-6 lg:px-8 flex-grow">
        <div
            class="max-w-7xl mx-auto bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden min-h-[500px]">

            <div class="border-b border-gray-200 overflow-x-auto scrollbar-hide bg-white sticky top-0 z-20">
                <div class="flex whitespace-nowrap px-4 md:px-6 pt-2">
                    <button onclick="openTab(event, 'tab-info')"
                        class="tab-btn active border-b-4 border-primary text-primary font-bold px-4 md:px-5 py-3 md:py-4 hover:bg-gray-50 transition-colors text-sm md:text-base outline-none">
                        Riset di Lingkungan DJP
                    </button>
                    <button onclick="openTab(event, 'tab-ketentuan')"
                        class="tab-btn border-b-4 border-transparent text-gray-500 font-medium px-4 md:px-5 py-3 md:py-4 hover:text-primary hover:bg-gray-50 transition-colors text-sm md:text-base outline-none">
                        Ketentuan Izin Riset
                    </button>
                    <button onclick="openTab(event, 'tab-hasil')"
                        class="tab-btn border-b-4 border-transparent text-gray-500 font-medium px-4 md:px-5 py-3 md:py-4 hover:text-primary hover:bg-gray-50 transition-colors text-sm md:text-base outline-none">
                        Daftar Hasil Riset
                    </button>
                    <button onclick="openTab(event, 'tab-faq')"
                        class="tab-btn border-b-4 border-transparent text-gray-500 font-medium px-4 md:px-5 py-3 md:py-4 hover:text-primary hover:bg-gray-50 transition-colors text-sm md:text-base outline-none">
                        FAQ Riset
                    </button>
                    <button onclick="openTab(event, 'tab-kontak')"
                        class="tab-btn border-b-4 border-transparent text-gray-500 font-medium px-4 md:px-5 py-3 md:py-4 hover:text-primary hover:bg-gray-50 transition-colors text-sm md:text-base outline-none">
                        Hubungi Kami
                    </button>
                </div>
            </div>

            <div class="p-6 md:p-10 bg-white">
                <div id="tab-info" class="tab-content active">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12 items-start">
                        <div class="relative group w-full rounded-xl overflow-hidden">
                            <img src="https://eriset.pajak.go.id/image/content-1.svg" alt="Gedung DJP"
                                class="w-full h-auto object-cover transform group-hover:scale-105 transition duration-500">
                        </div>

                        <div class="space-y-6 text-gray-600">
                            <div>
                                <h3 class="text-2xl font-bold text-primary mb-2">DJP dan Riset Perpajakan</h3>
                                <div class="w-16 h-1 bg-secondary rounded-full"></div>
                            </div>
                            <p class="leading-relaxed text-sm md:text-base">
                                Dalam rangka mewujudkan Visi Menjadi Mitra Tepercaya Pembangunan Bangsa untuk Menghimpun
                                Penerimaan Negara melalui Penyelenggaraan Administrasi Perpajakan yang Efisien, Efektif,
                                Berintegritas, dan Berkeadilan dalam rangka mendukung Visi Kementerian Keuangan:
                                "Menjadi Pengelola Keuangan Negara untuk Mewujudkan Perekonomian Indonesia yang
                                Produktif, Kompetitif, Inklusif dan Berkeadilan”, Direktorat Jenderal Pajak (DJP)
                                senantiasa mengembangkan kebijakan di bidang perpajakan. Riset merupakan salah satu
                                dasar acuan yang digunakan dalam pengembangan kebijakan di DJP.
                            </p>
                            <p class="leading-relaxed text-sm md:text-base">
                                Riset adalah kegiatan penelitian sebagaimana dimaksud dalam peraturan perundang-undangan
                                yang mengatur tentang penelitian. Ruang lingkup riset perpajakan meliputi penyusunan
                                Skripsi, Tesis, Disertasi, Karya Ilmiah, Riset untuk tujuan tertentu, dan lain-lain.
                            </p>

                            <div class="bg-blue-50/80 p-5 rounded-xl border border-blue-100">
                                <h4 class="font-bold text-primary mb-3 flex items-center gap-2 text-sm md:text-base">
                                    <svg class="w-5 h-5 text-secondary" fill="currentColor" viewBox="0 0 20 20">
                                        <path
                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" />
                                    </svg>
                                    DJP menghimpun sembilan rumpun tema riset di bidang perpajakan:
                                </h4>
                                <ul class="grid grid-cols-1 sm:grid-cols-2 gap-2 text-sm ml-2">
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Kepatuhan
                                        Perpajakan</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Peraturan
                                        Perpajakan</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Teknologi
                                        Informasi Perpajakan</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>SDM dan
                                        Organisasi DJP</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Edukasi
                                        Perpajakan</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Layanan
                                        Perpajakan</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Penegakan
                                        Hukum Perpajakan</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Proses
                                        Bisnis Perpajakan</li>
                                    <li class="flex items-center gap-2"><span
                                            class="w-1.5 h-1.5 bg-secondary rounded-full flex-shrink-0"></span>Perpajakan
                                        Internasional</li>
                                </ul>
                            </div>

                            <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-100">
                                <h4 class="font-bold text-primary mb-2 text-sm md:text-base">Surat Izin Riset</h4>
                                <p class="text-sm md:text-base text-gray-700">Setiap mahasiswa atau masyarakat atau
                                    badan/lembaga yang akan melakukan penelitian atau riset di lingkungan DJP wajib
                                    memperoleh surat izin riset dari DJP.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-ketentuan" class="tab-content space-y-4">
                    <div class="mb-6">
                        <h3 class="text-xl font-bold text-primary">Ketentuan dan Prosedur Riset</h3>
                        <p class="text-sm text-gray-500">Pahami syarat dan ketentuan sebelum mengajukan permohonan.</p>
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-secondary transition">
                        <button onclick="toggleAccordion('acc-1')"
                            class="w-full flex justify-between items-center bg-gray-50 p-4 font-semibold text-left hover:bg-gray-100 transition">
                            <span class="text-primary text-sm md:text-base">1. Kategori Periset</span>
                            <svg id="icon-acc-1" class="w-5 h-5 text-gray-400 transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="acc-1" class="hidden p-5 text-sm text-gray-600 bg-white border-t">
                            <ul class="space-y-2 ml-4 list-disc marker:text-secondary">
                                <li>Mahasiswa pada semua jenjang pendidikan (D3, S1, S2, S3).</li>
                                <li>Perorangan selain mahasiswa.</li>
                                <li>Kelompok peneliti.</li>
                                <li>Badan atau lembaga riset.</li>
                            </ul>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-secondary transition">
                        <button onclick="toggleAccordion('acc-2')"
                            class="w-full flex justify-between items-center bg-gray-50 p-4 font-semibold text-left hover:bg-gray-100 transition">
                            <span class="text-primary text-sm md:text-base">2. Dokumen Persyaratan</span>
                            <svg id="icon-acc-2" class="w-5 h-5 text-gray-400 transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="acc-2" class="hidden p-5 text-sm text-gray-600 bg-white border-t space-y-4">
                            <div>
                                <strong class="text-gray-800 block mb-2">Dokumen Wajib:</strong>
                                <ul class="list-disc ml-4 space-y-1 marker:text-secondary">
                                    <li>Surat keterangan/pengantar dari perguruan tinggi/lembaga.</li>
                                    <li>Proposal Riset yang jelas dan terperinci.</li>
                                    <li>Surat pernyataan bermeterai (Template tersedia).</li>
                                </ul>
                            </div>
                            <div class="bg-yellow-50 p-3 rounded-md border border-yellow-100">
                                <strong class="text-yellow-800 block mb-1">Khusus Non-Mahasiswa:</strong>
                                <ul class="list-disc ml-4 space-y-1 text-yellow-900/80">
                                    <li>Wajib memiliki NPWP & Lapor SPT Tahunan (2 tahun terakhir).</li>
                                    <li>Bukti lunas tunggakan pajak (SKF).</li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <div class="border border-gray-200 rounded-lg overflow-hidden hover:border-secondary transition">
                        <button onclick="toggleAccordion('acc-3')"
                            class="w-full flex justify-between items-center bg-gray-50 p-4 font-semibold text-left hover:bg-gray-100 transition">
                            <span class="text-primary text-sm md:text-base">3. Unit Pemroses Izin Riset</span>
                            <svg id="icon-acc-3" class="w-5 h-5 text-gray-400 transform transition-transform"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="acc-3" class="hidden p-5 text-sm text-gray-600 bg-white border-t">
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="p-4 rounded-lg border border-blue-100 bg-blue-50/50">
                                    <strong class="text-primary block mb-2">Kantor Pusat (Direktorat P2Humas)</strong>
                                    <ul class="list-disc ml-4 text-xs space-y-1">
                                        <li>Mahasiswa S2 & S3.</li>
                                        <li>Lokasi riset di Kantor Pusat / UPT.</li>
                                        <li>Periset Non-Mahasiswa.</li>
                                    </ul>
                                </div>
                                <div class="p-4 rounded-lg border border-yellow-100 bg-yellow-50/50">
                                    <strong class="text-yellow-800 block mb-2">Kantor Wilayah (Kanwil DJP)</strong>
                                    <ul class="list-disc ml-4 text-xs space-y-1">
                                        <li>Mahasiswa D3, D4, S1.</li>
                                        <li>Lokasi riset di unit vertikal (KPP/Kanwil) selain Pusat.</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-hasil" class="tab-content">
                    <div class="flex flex-col items-center justify-center py-16 text-center">
                        <div class="bg-blue-50 p-6 rounded-full mb-6 animate-bounce">
                            <svg class="w-12 h-12 text-primary" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253">
                                </path>
                            </svg>
                        </div>
                        <h4 class="text-2xl font-bold text-primary mb-3">Daftar Hasil Riset</h4>
                        <p class="text-gray-600 max-w-xl mb-8 leading-relaxed text-sm md:text-base">
                            Hasil penelitian yang dilakukan dengan izin riset DJP diarsipkan oleh Perpustakaan DJP.
                            Silakan datang langsung ke Perpustakaan DJP jika ingin membaca hasil riset. Daftar hasil
                            riset dapat dilihat pada:
                        </p>
                        <a href="https://edukasi.pajak.go.id/kunjung-perpus/riset" target="_blank"
                            class="inline-flex items-center gap-3 px-8 py-4 bg-secondary text-primary font-bold rounded-full hover:bg-yellow-400 transition shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                            <span>Kunjungi Perpustakaan DJP</span>
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <div id="tab-faq" class="tab-content space-y-4">
                    <h3 class="text-xl font-bold text-primary mb-6">Pertanyaan Umum (FAQ)</h3>

                    <div class="space-y-3">
                        <div class="border border-gray-200 rounded-lg">
                            <button onclick="toggleAccordion('faq-1')"
                                class="w-full flex justify-between items-center p-4 font-semibold text-left hover:bg-gray-50 transition">
                                <span class="text-sm md:text-base">Berapa lama proses izin riset?</span>
                                <svg id="icon-faq-1" class="w-5 h-5 text-gray-400 transform transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="faq-1" class="hidden p-4 text-sm text-gray-600 border-t bg-gray-50">
                                Proses bervariasi tergantung kelengkapan berkas dan konfirmasi data dari unit terkait.
                                Estimasi waktu akan diinformasikan melalui notifikasi di dashboard akun Anda.
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg">
                            <button onclick="toggleAccordion('faq-2')"
                                class="w-full flex justify-between items-center p-4 font-semibold text-left hover:bg-gray-50 transition">
                                <span class="text-sm md:text-base">Apakah ada biaya pengajuan?</span>
                                <svg id="icon-faq-2" class="w-5 h-5 text-gray-400 transform transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="faq-2" class="hidden p-4 text-sm text-gray-600 border-t bg-gray-50">
                                <strong>Tidak ada biaya (Gratis).</strong> Seluruh layanan permohonan izin riset di
                                lingkungan DJP tidak dipungut biaya apapun.
                            </div>
                        </div>

                        <div class="border border-gray-200 rounded-lg">
                            <button onclick="toggleAccordion('faq-3')"
                                class="w-full flex justify-between items-center p-4 font-semibold text-left hover:bg-gray-50 transition">
                                <span class="text-sm md:text-base">Bagaimana jika permohonan ditolak?</span>
                                <svg id="icon-faq-3" class="w-5 h-5 text-gray-400 transform transition-transform"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7"></path>
                                </svg>
                            </button>
                            <div id="faq-3" class="hidden p-4 text-sm text-gray-600 border-t bg-gray-50">
                                Anda akan menerima notifikasi email beserta alasan penolakan. Anda diperbolehkan
                                mengajukan permohonan ulang setelah melengkapi persyaratan atau menyesuaikan topik
                                riset.
                            </div>
                        </div>
                    </div>
                </div>

                <div id="tab-kontak" class="tab-content">
                    <div class="flex flex-col items-center justify-center py-12 text-center">
                        <div
                            class="w-20 h-20 bg-blue-50 rounded-full flex items-center justify-center mb-6 text-primary">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-primary mb-2">Hubungi Kami</h3>
                        <p class="text-gray-500 mb-6">Direktorat Penyuluhan, Pelayanan, dan Hubungan Masyarakat</p>

                        <div class="grid gap-4 w-full max-w-md">
                            <div
                                class="flex items-center gap-4 p-4 border rounded-lg hover:border-primary hover:bg-blue-50 transition bg-white shadow-sm">
                                <div class="bg-primary/10 p-2 rounded-full text-primary">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs text-gray-500 uppercase font-bold">Email</p>
                                    <p class="text-primary font-medium">riset@pajak.go.id</p>
                                </div>
                            </div>

                            <div
                                class="flex items-center gap-4 p-4 border rounded-lg hover:border-primary hover:bg-blue-50 transition bg-white shadow-sm">
                                <div class="bg-primary/10 p-2 rounded-full text-primary">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <p class="text-xs text-gray-500 uppercase font-bold">Alamat Kantor</p>
                                    <p class="text-primary font-medium text-sm">Jl. Jenderal Gatot Subroto No. 40-42,
                                        Jakarta 12190</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <footer class="bg-primary text-white text-center text-sm py-8 border-t border-white/10">
        <div class="max-w-7xl mx-auto px-6">
            <p class="font-medium">© 2025 Direktorat Jenderal Pajak. Hak Cipta Dilindungi Undang-Undang.</p>
        </div>
    </footer>

    <script>
        // --- TAB LOGIC ---
        function openTab(evt, tabName) {
            var i, tabcontent, tablinks;
            tabcontent = document.getElementsByClassName("tab-content");
            for (i = 0; i < tabcontent.length; i++) {
                tabcontent[i].classList.remove("active");
            }

            tablinks = document.getElementsByClassName("tab-btn");
            for (i = 0; i < tablinks.length; i++) {
                tablinks[i].classList.remove("border-primary", "text-primary", "font-bold", "active");
                tablinks[i].classList.add("border-transparent", "text-gray-500", "font-medium");
            }

            document.getElementById(tabName).classList.add("active");
            evt.currentTarget.classList.remove("border-transparent", "text-gray-500", "font-medium");
            evt.currentTarget.classList.add("border-primary", "text-primary", "font-bold", "active");
        }

        // --- ACCORDION LOGIC ---
        function toggleAccordion(id) {
            var content = document.getElementById(id);
            var icon = document.getElementById('icon-' + id);

            if (content.classList.contains('hidden')) {
                content.classList.remove('hidden');
                icon.classList.add('rotate-180');
            } else {
                content.classList.add('hidden');
                icon.classList.remove('rotate-180');
            }
        }

        // --- CAROUSEL LOGIC ---
        const track = document.getElementById('heroCarousel');
        const slides = Array.from(track.children);
        const indicators = document.querySelectorAll('.indicator');
        let currentSlide = 0;
        const slideCount = slides.length;

        // Variabel untuk Swipe
        let touchStartX = 0;
        let touchEndX = 0;

        function updateSlidePosition() {
            track.style.transform = `translateX(-${currentSlide * 100}%)`;

            indicators.forEach((ind, index) => {
                if (index === currentSlide) {
                    ind.classList.remove('bg-white/40');
                    ind.classList.add('bg-secondary');
                } else {
                    ind.classList.add('bg-white/40');
                    ind.classList.remove('bg-secondary');
                }
            });
        }

        function moveSlide(direction) {
            currentSlide = (currentSlide + direction + slideCount) % slideCount;
            updateSlidePosition();
            resetAutoSlide();
        }

        function goToSlide(index) {
            currentSlide = index;
            updateSlidePosition();
            resetAutoSlide();
        }

        // --- SWIPE LOGIC ---
        track.addEventListener('touchstart', (e) => {
            touchStartX = e.changedTouches[0].screenX;
            resetAutoSlide(); // Pause auto slide saat user menyentuh
        });

        track.addEventListener('touchend', (e) => {
            touchEndX = e.changedTouches[0].screenX;
            handleSwipe();
        });

        // Mouse Events untuk Desktop (Optional: Click and Drag)
        track.addEventListener('mousedown', (e) => {
            touchStartX = e.screenX;
            resetAutoSlide();
        });

        track.addEventListener('mouseup', (e) => {
            touchEndX = e.screenX;
            handleSwipe();
        });

        function handleSwipe() {
            const threshold = 50; // Jarak minimal swipe agar dianggap geser
            if (touchStartX - touchEndX > threshold) {
                // Swipe Kiri (Next)
                moveSlide(1);
            } else if (touchEndX - touchStartX > threshold) {
                // Swipe Kanan (Prev)
                moveSlide(-1);
            }
        }

        // --- AUTO SLIDE ---
        let slideInterval = setInterval(() => {
            currentSlide = (currentSlide + 1) % slideCount;
            updateSlidePosition();
        }, 5000);

        function resetAutoSlide() {
            clearInterval(slideInterval);
            slideInterval = setInterval(() => {
                currentSlide = (currentSlide + 1) % slideCount;
                updateSlidePosition();
            }, 5000);
        }

        // Initialize first state
        updateSlidePosition();
    </script>
</body>

</html>
