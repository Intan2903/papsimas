@extends('app.main')
@section('title', 'Edit Pengumuman')
@section('content')
    <div class="container mt-4">
        <h5>Edit Pengumuman</h5>
        <form action="{{ route('pengumuman.update', $pengumuman->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="row">
                <div class="col-12">
                    <label class="form-label w-100">Judul
                        <input class="form-control form-control shadow-none rounded-3" type="text"
                               name="judul" value="{{ old('judul', $pengumuman->judul) }}" required>
                    </label>
                    @error('judul')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    <label class="form-label w-100 mt-2">Isi Pengumuman
                        <textarea class="form-control" name="isi" required>{{ old('isi', $pengumuman->isi) }}</textarea>
                    </label>
                    @error('isi')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <button class="btn btn-primary mt-3" type="submit">Simpan</button>
                </div>
            </div>
        </form>
    </div>
@endsection
