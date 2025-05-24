@extends('app.main')

@section('title', 'Tagihan')

@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Tagihan</h5>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('pembayaran.update') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <label class="col-form-label w-100">Akun Pembayaran</label>
                                    <input type="text" name="nama_bank" class="form-control mb-2 shadow-none rounded-3"
                                        value="{{ old('nama_bank', $akunPembayaran->nama_bank ?? '') }}" />
                                    <input type="text" name="nama_pemilik"
                                        class="form-control mb-2 shadow-none rounded-3"
                                        value="{{ old('nama_pemilik', $akunPembayaran->nama_pemilik ?? '') }}" />
                                    <input type="text" name="nomor_rekening"
                                        class="form-control mb-2 shadow-none rounded-3"
                                        value="{{ old('nomor_rekening', $akunPembayaran->nomor_rekening ?? '') }}" />
                                </div>
                            </div>
                            <div class="row">
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Perbarui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-3">
            <div class="col">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('tagihan.updateJumlah') }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="row">
                                <div class="col-12">
                                    <label class="col-form-label w-100">Jumlah Tagihan</label>
                                    <input type="text" name="jumlah_tagihan"
                                        class="form-control form-control shadow-none rounded-3"
                                        value="{{ old('jumlah_tagihan', $jumlahTagihan->jumlah_tagihan ?? '') }}" />
                                </div>
                            </div>
                            <div class="row mt-2">
                                <div class="col">
                                    <button class="btn btn-primary" type="submit">Perbarui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Card kedua: Menampilkan detail tagihan berdasarkan grup -->
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row gy-2">
                            <div class="col-12 col-md-6">
                                <span>Detail Tagihan</span>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table border-0 shadow-none" id="dataTable-1" role="grid">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize">No</th>
                                        <th class="text-capitalize">Nama Pelanggan</th>
                                        <th class="text-capitalize">Jumlah Tagihan</th>
                                        <th class="text-capitalize">Status Pembayaran</th>
                                        <th class="text-capitalize">Metode Pembayaran</th>
                                        <th class="text-capitalize">Bukti Pembayaran</th>
                                        <th class="text-capitalize">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($dataTagihan as $index => $item)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $item->pelanggan->nama_lengkap }}</td>
                                            <td>Rp. {{ number_format($item->jumlah_tagihan, 0, ',', '.') }}</td>
                                            <td>{{ ucfirst($item->status) }}</td>
                                            <td>
                                                @if (ucfirst($item->metode_pembayaran))
                                                {{ ucfirst($item->metode_pembayaran) }}
                                                @else
                                                    <span>-</span>
                                                @endif
                                            <td>
                                                @if ($item->bukti_pembayaran)
                                                    <a href="{{ asset('storage/' . $item->bukti_pembayaran) }}"
                                                        class="btn btn-sm btn-primary" target="_blank">Lihat Bukti</a>
                                                @else
                                                    <span>-</span>
                                                @endif
                                            </td>
                                            <td>
                                                <form action="{{ route('tagihan.konfirmasi', $item->id) }}" method="POST">
                                                    @csrf
                                                    <button type="submit" class="btn btn-sm btn-success" 
                                                        onclick="return confirm('Apakah Anda yakin ingin mengonfirmasi pembayaran ini?')">
                                                        Konfirmasi Pembayaran
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
