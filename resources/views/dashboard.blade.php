@extends('app.main')
@section('title', 'Dashboard')
@section('content')
    <div class="container mt-4">
        <div class="row mb-2">
            <div class="col">
                <div>
                    <h3>Hi, <span class="ms-2">{{ auth()->user()->nama_lengkap }}</span></h3>
                </div>
            </div>
        </div>
        <div class="row mb-2">
            <div class="col">
                <h6 class="mb-0 fw-semibold">Ringkasan</h6>
            </div>
        </div>
        <div class="row gx-2 gy-2 gx-md-3 gy-md-3">
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-primary bg-opacity-10 bg-gradient border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5 class="fs-6 fw-semibold">Total Pengguna</h5>
                        <p class="fs-5 mb-0">{{ $totalUsers }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-success bg-opacity-10 bg-gradient border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5 class="fs-6 fw-semibold">Pendapatan Bulan Ini</h5>
                        <p class="fs-5 mb-0">{{ number_format($totalRevenueThisMonth, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-danger bg-opacity-10 border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5 class="fs-6 fw-semibold">Tagihan Belum Lunas Bulan Ini</h5>
                        <p class="fs-5 mb-0">{{ $unpaidBillsThisMonth }}</p>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-md-6 col-xl-3">
                <div class="card bg-warning bg-opacity-10 bg-gradient border-0 rounded-3 h-100">
                    <div class="card-body">
                        <h5 class="fs-6 fw-semibold">Total Pendapatan</h5>
                        <p class="fs-5 mb-0">{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Grafik Pendapatan per Bulan -->
        <div class="row mt-4">
            <div class="col">
                <div class="card">
                    <div class="card-header">
                        <h5>Grafik Pendapatan per Bulan</h5>
                    </div>
                    <div class="card-body p-3">
                        <canvas id="revenueChart" style="max-width: 100%; height: auto;"></canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        var ctx = document.getElementById('revenueChart').getContext('2d');
        var revenueChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: @json($revenuePerMonth->pluck('month')), // Bulan-bulan
                datasets: [{
                    label: 'Pendapatan',
                    data: @json($revenuePerMonth->pluck('revenue')), // Pendapatan per bulan
                    borderColor: '#007bff',
                    backgroundColor: 'rgba(0, 123, 255, 0.2)',
                    borderWidth: 2,
                    fill: true,
                    tension: 0.4,
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1000000,
                        },
                        grid: {
                            color: 'rgba(0,0,0,0.1)',
                        }
                    },
                    x: {
                        grid: {
                            color: 'rgba(0,0,0,0.1)',
                        }
                    }
                },
                plugins: {
                    legend: {
                        position: 'top',
                        labels: {
                            font: {
                                weight: 'bold',
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 123, 255, 0.7)',
                        titleFont: {
                            weight: 'bold',
                        },
                        bodyFont: {
                            weight: 'normal',
                        }
                    }
                }
            }
        });
    </script>
@endsection
