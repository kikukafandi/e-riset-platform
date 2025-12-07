<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Riset Platform - Perizinan Riset dengan Bootstrap</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }
        .hero-section {
            background: linear-gradient(rgba(13, 110, 253, 0.1), rgba(13, 110, 253, 0.1)), url('https://www.humasindonesia.id/images/berita/humas-indonesia-manfaat-riset-bagi-humas-2.jpeg') no-repeat center center;
            background-size: cover; // buat crop image
        }
        .card-feature {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .card-feature:hover {
            transform: translateY(-10px);
            box-shadow: 0 1rem 3rem rgba(0,0,0,.175)!important;
        }
    </style>
</head>
<body data-bs-spy="scroll" data-bs-target="#navbar-main">

    <nav id="navbar-main" class="navbar navbar-expand-lg navbar-light bg-white shadow-sm sticky-top">
        <div class="container">
            <a class="navbar-brand fw-bold text-primary" href="#">
                <i class="fas fa-flask me-2"></i>E-Riset
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#fitur">Fitur</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#alur">Alur Proses</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#testimoni">Testimoni</a>
                    </li>
                    <li class="nav-item ms-lg-3">
                        <a class="btn btn-warning rounded-pill px-4" href="{{ route('login') }}">Ajukan Riset</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <main>
        <section class="hero-section text-center py-5 text-white">
            <div class="container py-5">
                <h1 class="display-4 fw-bold mb-4">Urus Izin Riset Tanpa Ribet</h1>
                <p class="lead mb-5 col-lg-8 mx-auto">Platform digital untuk pengajuan dan pemantauan perizinan riset bagi mahasiswa dan umum. Cepat, transparan, dan terintegrasi.</p>
                <a href="{{ route('login') }}" class="btn btn-primary btn-lg rounded-pill px-5 py-3 fw-bold">Mulai Sekarang <i class="fas fa-arrow-right ms-2"></i></a>
            </div>
        </section>

        <section id="fitur" class="py-5">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Kenapa Memilih E-Riset?</h2>
                    <p class="text-muted">Semua yang Anda butuhkan untuk perizinan riset dalam satu platform.</p>
                </div>
                <div class="row g-4">
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 text-center card-feature">
                            <div class="card-body">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-4 mx-auto">
                                    <i class="fas fa-rocket fa-2x"></i>
                                </div>
                                <h5 class="card-title fw-bold">Proses Cepat</h5>
                                <p class="card-text text-muted">Ajukan proposal dan dapatkan persetujuan dalam waktu singkat melalui alur digital yang efisien.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 text-center card-feature">
                            <div class="card-body">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-4 mx-auto">
                                    <i class="fas fa-eye fa-2x"></i>
                                </div>
                                <h5 class="card-title fw-bold">Transparan & Terpantau</h5>
                                <p class="card-text text-muted">Lacak status pengajuan Anda secara *real-time*. Tidak ada lagi ketidakpastian.</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-4 col-md-6">
                        <div class="card h-100 border-0 shadow-sm p-4 text-center card-feature">
                            <div class="card-body">
                                <div class="icon-circle bg-primary bg-opacity-10 text-primary mb-4 mx-auto">
                                    <i class="fas fa-file-alt fa-2x"></i>
                                </div>
                                <h5 class="card-title fw-bold">Dokumen Terpusat</h5>
                                <p class="card-text text-muted">Semua dokumen, mulai dari proposal hingga surat izin, tersimpan aman di satu tempat.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        
        <section id="alur" class="py-5 bg-light">
            <div class="container py-5">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Hanya 3 Langkah Mudah</h2>
                </div>
                <div class="row g-4 text-center">
                    <div class="col-md-4">
                        <div class="p-3">
                            <h3 class="fw-bold text-primary">01.</h3>
                            <h5 class="fw-bold mt-3">Daftar & Isi Form</h5>
                            <p class="text-muted">Buat akun dan lengkapi formulir pengajuan riset.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <h3 class="fw-bold text-primary">02.</h3>
                            <h5 class="fw-bold mt-3">Unggah Dokumen</h5>
                            <p class="text-muted">Upload proposal dan dokumen pendukung lainnya.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="p-3">
                            <h3 class="fw-bold text-primary">03.</h3>
                            <h5 class="fw-bold mt-3">Pantau & Terima Izin</h5>
                            <p class="text-muted">Lacak prosesnya dan unduh surat izin setelah disetujui.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <section id="testimoni" class="py-5">
            <div class="container py-5">
                 <div class="text-center mb-5">
                    <h2 class="fw-bold">Apa Kata Mereka?</h2>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="card border-0 shadow-lg">
                            <div class="card-body p-5 text-center">
                                <p class="fst-italic text-muted">"Platform E-Riset ini benar-benar mengubah cara saya mengurus izin penelitian. Prosesnya jadi jauh lebih cepat dan saya bisa fokus ke penelitian saya. Sangat direkomendasikan!"</p>
                                <div class="mt-4">
                                    <img src="https://i.pravatar.cc/100?u=a042581f4e29026704d" alt="Testimonial User" class="rounded-circle mx-auto mb-3" width="80" height="80">
                                    <h6 class="fw-bold mb-0">Andini Putri</h6>
                                    <small class="text-muted">Mahasiswa Teknik Informatika</small>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="bg-dark text-white text-center py-4">
        <div class="container">
            <p class="mb-2">&copy; 2025 E-Riset Platform. All Rights Reserved.</p>
            <div>
                <a href="#" class="text-white mx-2"><i class="fab fa-facebook fa-lg"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-twitter fa-lg"></i></a>
                <a href="#" class="text-white mx-2"><i class="fab fa-instagram fa-lg"></i></a>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>