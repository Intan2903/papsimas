@extends('app.main')
@section('title', 'Pengguna')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Edit Pengguna</h5>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('users.update', $user->id) }}">
                            @csrf
                            @method('PUT')
                            <div class="row gy-3">
                                <!-- Bagian Role -->
                                <div class="col-12">
                                    <label class="form-label w-100">Role</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input type="radio" id="roleAdmin" class="form-check-input" name="role"
                                                value="admin" {{ $user->role == 'admin' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="roleAdmin">Admin</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" id="rolePetugas" class="form-check-input" name="role"
                                                value="petugas" {{ $user->role == 'petugas' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rolePetugas">Petugas</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" id="rolePelanggan" class="form-check-input" name="role"
                                                value="pelanggan" {{ $user->role == 'pelanggan' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="rolePelanggan">Pelanggan</label>
                                        </div>
                                    </div>
                                </div>

                                <!-- Bagian Status -->
                                <div class="col-12">
                                    <label class="form-label w-100">Status</label>
                                    <div class="d-flex gap-3">
                                        <div class="form-check">
                                            <input type="radio" id="statusAktif" class="form-check-input" name="status"
                                                value="aktif" {{ $user->status == 'aktif' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusAktif">Aktif</label>
                                        </div>
                                        <div class="form-check">
                                            <input type="radio" id="statusNonaktif" class="form-check-input"
                                                name="status" value="nonaktif"
                                                {{ $user->status == 'nonaktif' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="statusNonaktif">Nonaktif</label>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col">
                                    <div class="text-end">
                                        <button class="btn btn-primary" type="submit">Simpan</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                @endsection
