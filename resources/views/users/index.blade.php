@extends('app.main')
@section('title', 'Pengguna')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Pengguna</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row gy-2">
                            <div class="col-12 col-md-6">
                                <a class="btn btn-primary" role="button" href="{{ route('users.create') }}">Tambah Pengguna</a>
                            </div>
                            <div class="col-12 col-md-6">
                                <form action="{{ route('users.index') }}" method="GET">
                                    <div class="input-group">
                                        <input class="form-control" type="text" name="search" value="{{ $search }}" placeholder="Cari pengguna...">
                                        <button class="btn btn-primary" type="submit">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="1em" height="1em" viewBox="0 0 20 20" fill="none">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M8 4C5.79086 4 4 5.79086 4 8C4 10.2091 5.79086 12 8 12C10.2091 12 12 10.2091 12 8C12 5.79086 10.2091 4 8 4ZM2 8C2 4.68629 4.68629 2 8 2C11.3137 2 14 4.68629 14 8C14 9.29583 13.5892 10.4957 12.8907 11.4765L17.7071 16.2929C18.0976 16.6834 18.0976 17.3166 17.7071 17.7071C17.3166 18.0976 16.6834 18.0976 16.2929 17.7071L11.4765 12.8907C10.4957 13.5892 9.29583 14 8 14C4.68629 14 2 11.3137 2 8Z" fill="currentColor"></path>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table border-0 shadow-none" id="dataTable-1" role="grid" aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize">No</th>
                                        <th class="text-capitalize">Nama</th>
                                        <th class="text-capitalize">Telepon</th>
                                        <th class="text-capitalize">Alamat</th>
                                        <th class="text-capitalize">RT/RW</th>
                                        <th class="text-capitalize">Status</th>
                                        <th class="text-capitalize">Role</th>
                                        <th class="text-capitalize">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $index => $user)
                                        <tr>
                                            <td>{{ $users->firstItem() + $index }}</td>
                                            <td>{{ $user->nama_lengkap }}</td>
                                            <td>{{ $user->telepon }}</td>
                                            <td>{{ $user->alamat }}</td>
                                            <td>{{ $user->rt_rw }}</td>
                                            <td>
                                                <span class="text-capitalize badge 
                                                    @if ($user->status == 'aktif') bg-primary
                                                    @elseif($user->status == 'nonaktif') bg-danger @endif">
                                                    {{ $user->status }}
                                                </span>
                                            </td>
                                            <td>
                                                <span class="text-capitalize badge 
                                                    @if ($user->role == 'admin') bg-primary
                                                    @elseif($user->role == 'petugas') bg-warning
                                                    @elseif($user->role == 'pelanggan') bg-dark @endif">
                                                    {{ $user->role }}
                                                </span>
                                            </td>
                                            <td>
                                                <div class="d-flex gap-1">
                                                    <a class="btn btn-primary btn-sm" href="{{ route('users.edit', $user->id) }}">Edit</a>
                                                    <form action="{{ route('users.destroy', $user->id) }}" method="POST" style="display:inline;">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="btn btn-danger btn-sm" type="submit">Hapus</button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <nav class="d-flex justify-content-end">
                            <ul class="pagination">
                                <!-- Tombol Previous -->
                                <li class="page-item {{ $users->onFirstPage() ? 'disabled' : '' }}">
                                    <a class="page-link" href="{{ $users->previousPageUrl() }}" aria-label="Previous">
                                        <span aria-hidden="true">«</span>
                                    </a>
                                </li>
                        
                                @if ($users->currentPage() > 3)
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->url(1) }}">1</a>
                                    </li>
                                    @if ($users->currentPage() > 4)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                @endif
                        
                                @for ($i = max(1, $users->currentPage() - 2); $i <= min($users->lastPage(), $users->currentPage() + 2); $i++)
                                    <li class="page-item {{ $i == $users->currentPage() ? 'active' : '' }}">
                                        <a class="page-link" href="{{ $users->url($i) }}">{{ $i }}</a>
                                    </li>
                                @endfor
                        
                                @if ($users->currentPage() < $users->lastPage() - 2)
                                    @if ($users->currentPage() < $users->lastPage() - 3)
                                        <li class="page-item disabled"><span class="page-link">...</span></li>
                                    @endif
                                    <li class="page-item">
                                        <a class="page-link" href="{{ $users->url($users->lastPage()) }}">{{ $users->lastPage() }}</a>
                                    </li>
                                @endif
                        
                                <li class="page-item {{ $users->hasMorePages() ? '' : 'disabled' }}">
                                    <a class="page-link" href="{{ $users->nextPageUrl() }}" aria-label="Next">
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
