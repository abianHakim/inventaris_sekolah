@extends('template.SU')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        {{-- <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i
                class="fas fa-download fa-sm text-white-50"></i> Generate Report</a> --}}
    </div>

    <div class="row justify-content-around">

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Barang tersedia
                            </div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $jumlahBarang }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-box-open fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Barang Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">18</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-truck-loading fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Barang dipinjam</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">
                                {{ $jumlahBarangNonAktif }}
                            </div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-archive fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>



    </div>

    <div class="row">
        <!-- Area Chart -->
        <div class="col-xl-12 col-lg-7">
            <div class="card shadow mb-4">
                <!-- Card Header - Dropdown -->
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Grafik Peminjaman</h6>
                </div>
                <!-- Card Body -->
                <div class="card-body">
                    <div class="chart-area">
                        <canvas id="myAreaChart">

                        </canvas>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var ctx = document.getElementById("myAreaChart").getContext("2d");
            var dataGrafik = @json($dataGrafik);

            // Hapus chart sebelumnya jika ada
            if (window.myChart) {
                window.myChart.destroy();
            }

            // Warna Gradien untuk Grafik
            var gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(54, 162, 235, 0.3)');
            gradient.addColorStop(1, 'rgba(54, 162, 235, 0)');

            // Inisialisasi Chart
            window.myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov",
                        "Des"
                    ],
                    datasets: [{
                        label: 'Jumlah Peminjaman',
                        data: dataGrafik,
                        backgroundColor: gradient, // Warna dengan efek transparan
                        borderColor: 'rgba(54, 162, 235, 1)',
                        borderWidth: 3,
                        pointRadius: 6,
                        pointHoverRadius: 10,
                        pointBackgroundColor: 'rgba(54, 162, 235, 1)',
                        tension: 0.4 // Garis lebih smooth
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    interaction: {
                        mode: 'index',
                        intersect: false
                    },
                    plugins: {
                        tooltip: {
                            enabled: true,
                            backgroundColor: 'rgba(0, 0, 0, 0.7)',
                            titleColor: '#fff',
                            bodyColor: '#fff',
                            bodyFont: {
                                size: 14
                            },
                            padding: 10
                        },
                        legend: {
                            labels: {
                                font: {
                                    size: 14
                                },
                                color: '#333'
                            }
                        }
                    },
                    scales: {
                        x: {
                            ticks: {
                                color: '#333',
                                font: {
                                    size: 13
                                }
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.2)'
                            }
                        },
                        y: {
                            beginAtZero: true,
                            ticks: {
                                color: '#333',
                                font: {
                                    size: 13
                                },
                                callback: function(value) {
                                    return Number.isInteger(value) ? value : ''; // Hanya angka bulat
                                }
                            },
                            grid: {
                                color: 'rgba(200, 200, 200, 0.2)'
                            }
                        }
                    }
                }
            });
        });
    </script>
@endpush
