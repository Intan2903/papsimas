@extends('app.main')
@section('title', 'Pengguna')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Tambah Pengguna</h5>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('users.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label w-100">Nama Lengkap
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="nama_lengkap">
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label w-100">Telepon
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="telepon">
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label w-100">Alamat
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="alamat">
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label w-100">RT/RW
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="rt_rw">
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="col-form-label w-100">Password
                                        <input class="form-control form-control shadow-none rounded-3" type="password"
                                            name="password">
                                    </label>
                                </div>
                                <div class="col-12 col-lg-6">
                                    <label class="form-label w-100">Role</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="admin" name="role"
                                                value="admin">
                                            <label class="form-check-label" for="admin"> Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="petugas" name="role"
                                                value="petugas">
                                            <label class="form-check-label" for="petugas"> Petugas</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" class="form-check-input" id="pelanggan" name="role"
                                                value="pelanggan">
                                            <label class="form-check-label" for="pelanggan"> Pelanggan</label>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="text-end"><button class="btn btn-primary" type="submit">Simpan</button></div>
            </div>
        </div>
        </form>
    </div>
@endsection
