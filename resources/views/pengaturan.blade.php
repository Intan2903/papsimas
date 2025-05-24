@extends('app.main')
@section('title', 'Pengaturan')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Profil</h5>
                </div>
            </div>
        </div>
        <div class="card border-0 rounded-3 bg-light">
            <div class="card-body p-2 p-md-3 px-lg-4">
                <div class="row">
                    <div class="col">
                        <form action="{{ route('updateProfile') }}" method="POST" id="profile-form">
                            @csrf
                            <div class="row">
                                <div class="col-xl-6 col-xxl-6">
                                    <label class="col-form-label w-100">Phone
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="telepon" value="{{ Auth::user()->telepon }}" required disabled
                                            id="telepon">
                                    </label>
                                </div>
                                <div class="col-xl-6 col-xxl-6">
                                    <label class="col-form-label w-100">Alamat
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="alamat" value="{{ Auth::user()->alamat }}" required disabled
                                            id="alamat">
                                    </label>
                                </div>
                                <div class="col-xl-6 col-xxl-6">
                                    <label class="col-form-label w-100">RT/RW
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="rt_rw" value="{{ Auth::user()->rt_rw }}" required disabled
                                            id="rt_rw">
                                    </label>
                                </div>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-2" id="profile-buttons">
                                <button class="btn btn-danger rounded-3" type="button" id="cancel-profile"
                                    style="display:none;">Batal</button>
                                <button class="btn btn-primary rounded-3" type="submit" id="save-profile"
                                    style="display:none;">Simpan</button>
                                <button class="btn btn-primary rounded-3" type="button" id="edit-profile">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col">
                <div>
                    <h5>Ubah Password</h5>
                </div>
            </div>
        </div>
        <div class="card border-0 rounded-3 bg-light">
            <div class="card-body p-2 p-md-3 px-lg-4">
                <div class="row">
                    <div class="col-xxl-12">
                        <form action="{{ route('updatePassword') }}" method="POST" id="password-form">
                            @csrf
                            <div class="d-md-flex gap-3 w-100">
                                <label class="form-label w-100">Password Saat Ini
                                    <input class="form-control form-control shadow-none rounded-3" type="password"
                                        name="current_password" required disabled id="current-password">
                                </label>
                                <label class="form-label w-100">Password Baru
                                    <input class="form-control form-control shadow-none rounded-3" type="password"
                                        name="new_password" required disabled id="new-password">
                                </label>
                            </div>
                            <div class="d-flex justify-content-end gap-2 mt-2" id="password-buttons">
                                <button class="btn btn-danger rounded-3" type="button" id="cancel-password"
                                    style="display:none;">Batal</button>
                                <button class="btn btn-primary rounded-3" type="submit" id="save-password"
                                    style="display:none;">Ubah</button>
                                <button class="btn btn-primary rounded-3" type="button" id="edit-password">Edit</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3">
            <div class="col">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="btn btn-danger rounded-3" type="submit">Logout</button>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.getElementById('edit-profile').addEventListener('click', function() {
            document.querySelectorAll('#profile-form input').forEach(input => input.disabled = false);
            document.getElementById('profile-buttons').querySelector('#edit-profile').style.display = 'none';
            document.getElementById('profile-buttons').querySelector('#cancel-profile').style.display =
                'inline-block';
            document.getElementById('profile-buttons').querySelector('#save-profile').style.display =
                'inline-block';
        });

        document.getElementById('cancel-profile').addEventListener('click', function() {
            document.querySelectorAll('#profile-form input').forEach(input => input.disabled = true);
            document.getElementById('profile-buttons').querySelector('#edit-profile').style.display =
                'inline-block';
            document.getElementById('profile-buttons').querySelector('#cancel-profile').style.display = 'none';
            document.getElementById('profile-buttons').querySelector('#save-profile').style.display = 'none';
        });

        document.getElementById('edit-password').addEventListener('click', function() {
            document.querySelectorAll('#password-form input').forEach(input => input.disabled = false);
            document.getElementById('password-buttons').querySelector('#edit-password').style.display = 'none';
            document.getElementById('password-buttons').querySelector('#cancel-password').style.display =
                'inline-block';
            document.getElementById('password-buttons').querySelector('#save-password').style.display =
                'inline-block';
        });

        document.getElementById('cancel-password').addEventListener('click', function() {
            document.querySelectorAll('#password-form input').forEach(input => input.disabled = true);
            document.getElementById('password-buttons').querySelector('#edit-password').style.display =
                'inline-block';
            document.getElementById('password-buttons').querySelector('#cancel-password').style.display = 'none';
            document.getElementById('password-buttons').querySelector('#save-password').style.display = 'none';
        });
    </script>
@endsection
