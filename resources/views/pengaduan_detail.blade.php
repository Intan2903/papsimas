@extends('app.main')

@section('title', 'Detail Pengaduan')

@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Pengaduan Detail</h5>
                </div>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <p class="fw-bold">Pengirim:&nbsp;<span
                                class="fw-normal">{{ $pengaduan->pengguna->nama_lengkap }}</span></p>
                        <p class="mb-0">{{ $pengaduan->isi }}</p>

                        <form action="{{ route('pengaduan.updateBalasan', $pengaduan->id) }}" method="POST">
                            @csrf
                            @method('PUT')

                            <div class="row">
                                <div class="col-12">
                                    <hr>
                                    <label class="form-label w-100">Beri Balasan<br>
                                        <textarea class="form-control" name="balasan" required>{{ $pengaduan->balasan }}</textarea>
                                    </label>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Kirim</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
