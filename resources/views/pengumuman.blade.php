@extends('app.main')
@section('title', 'Pengumuman')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <h5>Tambah Pengumuman</h5>
            </div>
        </div>
        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pengumuman.store') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label w-100">Judul
                                        <input class="form-control form-control shadow-none rounded-3" type="text"
                                            name="judul" value="{{ old('judul') }}" required>
                                    </label>
                                    @error('judul')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                    <label class="form-label w-100 mt-2">Isi Pengumuman
                                        <textarea class="form-control" name="isi" required>{{ old('isi') }}</textarea>
                                    </label>
                                    @error('isi')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary mt-3" type="submit">Tambah</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-2">
            <div class="col">
                <h5>Riwayat Pengumuman</h5>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive table border-0 shadow-none" id="dataTable-1">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize">No</th>
                                        <th class="text-capitalize">Tanggal</th>
                                        <th class="text-capitalize">Judul</th>
                                        <th class="text-capitalize">Isi Pengumuman</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengumuman as $index => $item)
                                        <tr>
                                            <td>{{ $pengumuman->firstItem() + $index }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $item->judul }}</td>
                                            <td>{{ Str::limit($item->isi, 50) }}</td>
                                            <td>
                                                <a href="{{ route('pengumuman.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>
                                                
                                                <form action="{{ route('pengumuman.destroy', $item->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah Anda yakin ingin menghapus pengumuman ini?')">Hapus</button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav class="d-flex justify-content-end">
                            <ul class="pagination">
                                <li class="page-item {{ $pengumuman->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $pengumuman->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>

                                @if ($pengumuman->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pengumuman->url(1) }}">1</a>
                                    </li>
                                    @if ($pengumuman->currentPage() > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                @for ($i = max(1, $pengumuman->currentPage() - 2); $i <= min($pengumuman->lastPage(), $pengumuman->currentPage() + 2); $i++)
                                    <li class="page-item {{ $i == $pengumuman->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $pengumuman->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($pengumuman->currentPage() < $pengumuman->lastPage() - 2)
                                    @if ($pengumuman->currentPage() < $pengumuman->lastPage() - 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $pengumuman->url($pengumuman->lastPage()) }}">{{ $pengumuman->lastPage() }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $pengumuman->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $pengumuman->nextPageUrl() }}" aria-label="Next">
                                        <span aria-hidden="true">»</span>
                                    </a>
                                </li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
