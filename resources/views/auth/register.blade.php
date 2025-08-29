@extends('auth.layouts.app')
@section('title', 'Register')
@section('content')
<main>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="card shadow-lg border-0 rounded-lg mt-5">
                    <div class="card-header">
                        <h3 class="text-center font-weight-light my-4">Create Account</h3>
                    </div>
                    <div class="card-body">

                        <!-- Tabs kategori -->
                        <ul class="nav nav-tabs mb-3" id="kategoriTab" role="tablist">
                            <li class="nav-item" role="presentation">
                                <button class="nav-link active" id="mahasiswa-tab" data-bs-toggle="tab"
                                    data-bs-target="#mahasiswa" type="button" role="tab" aria-controls="mahasiswa"
                                    aria-selected="true">Mahasiswa</button>
                            </li>
                            <li class="nav-item" role="presentation">
                                <button class="nav-link" id="non-tab" data-bs-toggle="tab"
                                    data-bs-target="#non" type="button" role="tab" aria-controls="non"
                                    aria-selected="false">Non Mahasiswa</button>
                            </li>
                        </ul>

                        <div class="tab-content" id="kategoriTabContent">

                            {{-- ================= FORM MAHASISWA ================= --}}
                            <div class="tab-pane fade show active" id="mahasiswa" role="tabpanel"
                                aria-labelledby="mahasiswa-tab">
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="kategori" value="mahasiswa">

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="inputFirstName" type="text"
                                                    placeholder="Enter your first name" name="firstName" required/>
                                                <label for="inputFirstName">First name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input class="form-control" id="inputLastName" type="text"
                                                    placeholder="Enter your last name" name="lastName" required/>
                                                <label for="inputLastName">Last name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputEmail" type="email"
                                            placeholder="name@example.com" name="email" required/>
                                        <label for="inputEmail">Email address</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputKampus" type="text"
                                            placeholder="Universitas..." name="kampus" required/>
                                        <label for="inputKampus">Kampus</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <select name="jenjang" class="form-select" required>
                                            <option value="" disabled selected>Jenjang</option>
                                            <option value="D1">D1</option>
                                            <option value="D2">D2</option>
                                            <option value="D3">D3</option>
                                            <option value="D4/S1">D4 / S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                        </select>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputNim" type="text" placeholder="NIM"
                                            name="nim" required/>
                                        <label for="inputNim">NIM</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="InputJurusan" type="text" placeholder="Jurusan"
                                            name="jurusan" required/>
                                        <label for="InputJurusan">Jurusan</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputAlamat" type="text" placeholder="Alamat"
                                            name="alamat" required/>
                                        <label for="inputAlamat">Alamat</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" id="inputNik" type="text" placeholder="NIK"
                                            name="nik" required/>
                                        <label for="inputNik">NIK</label>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="inputPassword" type="password"
                                                    placeholder="Create a password" name="password" required/>
                                                <label for="inputPassword">Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" id="inputPasswordConfirm" type="password"
                                                    placeholder="Confirm password" name="confPassword" required/>
                                                <label for="inputPasswordConfirm">Confirm Password</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                            {{-- ================= FORM NON MAHASISWA ================= --}}
                            <div class="tab-pane fade" id="non" role="tabpanel" aria-labelledby="non-tab">
                                <form action="{{ route('register') }}" method="post">
                                    @csrf
                                    <input type="hidden" name="kategori" value="non-mahasiswa">

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" type="text"
                                                    placeholder="Enter your first name" name="firstName" required/>
                                                <label>First name</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating">
                                                <input class="form-control" type="text"
                                                    placeholder="Enter your last name" name="lastName" required/>
                                                <label>Last name</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="email"
                                            placeholder="name@example.com" name="email" required/>
                                        <label>Email address</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" placeholder="Alamat"
                                            name="alamat" required/>
                                        <label>Alamat</label>
                                    </div>

                                    <div class="form-floating mb-3">
                                        <input class="form-control" type="text" placeholder="NIK"
                                            name="nik" required/>
                                        <label>NIK</label>
                                    </div>

                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" type="password"
                                                    placeholder="Create a password" name="password" required/>
                                                <label>Password</label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-floating mb-3 mb-md-0">
                                                <input class="form-control" type="password"
                                                    placeholder="Confirm password" name="confPassword" required/>
                                                <label>Confirm Password</label>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="mt-4 mb-0">
                                        <div class="d-grid">
                                            <button class="btn btn-primary btn-block" type="submit">Create Account</button>
                                        </div>
                                    </div>
                                </form>
                            </div>

                        </div>
                    </div>

                    <div class="card-footer text-center py-3">
                        <div class="small"><a href="{{ route('loginPage') }}">Have an account? Go to login</a></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
