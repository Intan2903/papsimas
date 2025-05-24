@extends('app.main')
@section('title', 'Laporan')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h5>Laporan</h5>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <div class="row gy-2">
                            <div class="col-12 col-md-6">
                                <form method="GET" action="{{ route('laporan.export') }}" class="d-inline">
                                    <input type="hidden" name="bulan" value="{{ request('bulan') }}">
                                    <input type="hidden" name="tahun" value="{{ request('tahun') }}">
                                    <button type="submit" class="btn btn-primary">Download Laporan</button>
                                </form>
                            </div>
                            <div class="col-12 col-md-6 d-flex gap-2 justify-content-end">
                                <form method="GET" action="{{ route('laporan') }}" class="d-flex">
                                    <select name="bulan" class="form-select me-2" required>
                                        <option value="">Pilih Bulan</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}"
                                                {{ request('bulan') == $i ? 'selected' : '' }}>
                                                {{ Carbon\Carbon::create()->month($i)->format('F') }}
                                            </option>
                                        @endfor
                                    </select>

                                    <select name="tahun" class="form-select me-2" required>
                                        <option value="">Pilih Tahun</option>
                                        @foreach ($availableYears as $year)
                                            <option value="{{ $year->year }}"
                                                {{ request('tahun') == $year->year ? 'selected' : '' }}>
                                                {{ $year->year }}
                                            </option>
                                        @endforeach
                                    </select>

                                    <button type="submit" class="btn btn-success">Filter</button>
                                </form>
                                <a class="btn btn-light" href="{{ route('laporan') }}">Clear</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive table border-0 shadow-none" id="dataTable-1" role="grid"
                            aria-describedby="dataTable_info">
                            <table class="table my-0" id="dataTable">
                                <thead>
                                    <tr>
                                        <th class="text-capitalize">No</th>
                                        <th class="text-capitalize">Tanggal</th>
                                        <th class="text-capitalize">Nama Pelanggan</th>
                                        <th class="text-capitalize">Jumlah Tagihan</th>
                                        <th class="text-capitalize">Tanggal Bayar</th>
                                        <th class="text-capitalize">Metode Pembayaran</th>
                                        <th class="text-capitalize">Bukti Pembayaran</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihans as $index => $tagihan)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>{{ $tagihan->created_at->format('d/m/Y') }}</td>
                                            <td>{{ $tagihan->pelanggan->nama_lengkap }}</td>
                                            <td>Rp.
                                                {{ number_format($tagihan->jumlah_tagihan, 0, ',', '.') }}
                                            </td>
                                            <td>{{ $tagihan->updated_at->format('d/m/Y') }}</td>
                                            <td>{{ $tagihan->metode_pembayaran }}</td>
                                            <td>
                                                @if ($tagihan->bukti_pembayaran)
                                                    <a href="{{ asset('storage/' . $tagihan->bukti_pembayaran) }}"
                                                        class="btn btn-primary btn-sm" target="_blank">Lihat Bukti</a>
                                                @else
                                                    -
                                                @endif
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
