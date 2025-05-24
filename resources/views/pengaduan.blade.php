@extends('app.main')
@section('title', 'Pengaduan')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Pengaduan</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        @if (session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive table border-0 shadow-none" id="dataTable-1" role="grid"
                            aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize">No</th>
                                        <th class="text-capitalize">Tanggal</th>
                                        <th class="text-capitalize">Nama Pengadu</th>
                                        <th class="text-capitalize">Isi</th>
                                        <th class="text-capitalize">Balasan</th>
                                        <th class="text-capitalize">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($pengaduan as $index => $item)
                                        <tr>
                                            <td>{{ $pengaduan->firstItem() + $index }}</td>
                                            <td>{{ $item->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $item->pengguna->nama_lengkap }}</td>
                                            <td>{{ Str::limit($item->isi, 50) }}</td>
                                            <td>
                                                @empty($item->balasan)
                                                    <span class="badge bg-light">Belum ada balasan</span>
                                                @else
                                                    {{ Str::limit($item->balasan, 50) }}
                                                @endempty
                                            </td>
                                            <td>
                                                <a class="btn btn-primary" role="button"
                                                    href="{{ route('pengaduan.show', $item->id) }}">Detail</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav class="d-flex justify-content-end">
                            <ul class="pagination">
                                <li class="page-item {{ $pengaduan->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $pengaduan->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>

                                @if ($pengaduan->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $pengaduan->url(1) }}">1</a>
                                    </li>
                                    @if ($pengaduan->currentPage() > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif

                                @for ($i = max(1, $pengaduan->currentPage() - 2); $i <= min($pengaduan->lastPage(), $pengaduan->currentPage() + 2); $i++)
                                    <li class="page-item {{ $i == $pengaduan->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $pengaduan->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor

                                @if ($pengaduan->currentPage() < $pengaduan->lastPage() - 2)
                                    @if ($pengaduan->currentPage() < $pengaduan->lastPage() - 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link"
                                            href="{{ $pengaduan->url($pengaduan->lastPage()) }}">{{ $pengaduan->lastPage() }}</a>
                                    </li>
                                @endif

                                <li class="page-item {{ $pengaduan->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $pengaduan->nextPageUrl() }}" aria-label="Next">
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
