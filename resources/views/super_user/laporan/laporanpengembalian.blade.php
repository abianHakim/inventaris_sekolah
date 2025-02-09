@extends('template.SU')

@push('style')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet">

    <style>
        .btn-success {
            background-color: #28a745 !important;
            border-color: #28a745 !important;
        }

        .btn-danger {
            background-color: #dc3545 !important;
            border-color: #dc3545 !important;
        }

        .btn-info {
            background-color: #17a2b8 !important;
            border-color: #17a2b8 !important;
        }

        .btn-primary {
            background-color: #007bff !important;
            border-color: #007bff !important;
        }

        .btn-secondary {
            background-color: #6c757d !important;
            border-color: #6c757d !important;
        }

        .btn-warning {
            background-color: #ffc107 !important;
            border-color: #ffc107 !important;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .dt-buttons .btn {
            margin: 5px;
            font-size: 14px;
            border-radius: 5px;
            color: white !important;
        }


        .table thead {
            background-color: #007bff;
            color: white;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }


        /* tabel */
        td {
            white-space: normal !important;
            word-wrap: break-word !important;
        }

        .table {
            table-layout: auto;
            width: 100%;
            word-wrap: break-word;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
            padding: 8px;
            white-space: normal;
        }

        .table td:nth-child(2),
        .table td:nth-child(3),
        .table td:nth-child(4),
        .table td:nth-child(5) {
            text-align: left !important;
        }

        @media print {
            .table {
                width: 100%;
                table-layout: auto;
            }

            .table th,
            .table td {
                font-size: 12px;
                white-space: normal;
                word-wrap: break-word;
            }

            .table td:nth-child(2),
            .table td:nth-child(3),
            .table td:nth-child(4),
            .table td:nth-child(5) {
                text-align: left !important;
            }
        }
    </style>
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Laporan Pengembalian Barang</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label for="filter-tanggal-awal">📅 Dari Tanggal:</label>
                    <input type="date" id="filter-tanggal-awal" class="form-control">
                </div>
                <div class="col-md-6">
                    <label for="filter-tanggal-akhir">📅 Sampai Tanggal:</label>
                    <input type="date" id="filter-tanggal-akhir" class="form-control">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th style="width: 13%;">ID Kembali</th>
                            <th style="width: 20%;">Penanggung Jawab</th>
                            <th style="width: 20%;">Siswa</th>
                            <th style="width: 25%;">Barang Dikembalikan</th>
                            <th style="width: 15%;">Tanggal Kembali</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $kembali)
                            <tr>
                                <td>{{ $kembali->kembali_id }}</td>
                                <td>{{ $kembali->user->user_name ?? 'Tidak Ada User' }}</td>
                                <td>{{ $kembali->peminjaman->siswa->nama_siswa }}</td>
                                <td style="text-align: left;">
                                    @php
                                        $barangList = $kembali->peminjaman->detailPeminjaman
                                            ->filter(fn($detail) => !empty($detail->barang->br_nama))
                                            ->map(fn($detail) => trim('• ' . e($detail->barang->br_nama)))
                                            ->implode(' ');
                                    @endphp
                                    {{ $barangList }}
                                </td>
                                <td>{{ \Carbon\Carbon::parse($kembali->kembali_tgl)->format('Y-m-d') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- DataTables Buttons -->
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.2.0/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.print.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.1.0/js/buttons.colVis.min.js"></script>


    <script>
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('#dataTable')) {
                $('#dataTable').DataTable().destroy();
            }
            var table = $('#dataTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "dom": '<"row"<"col-md-7"B><"col-md-5"f>>rtip',
                "buttons": [

                    {
                        extend: 'excelHtml5',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success',
                        title: 'Laporan Pengembalian Barang',
                        exportOptions: {
                            columns: ':visible',
                            format: {
                                body: function(data, row, column, node) {
                                    if (column === 3) {
                                        return data.replace(/\n/g, ", ");
                                    }
                                    if (column === 4) {
                                        return "'" +
                                            data;
                                    }
                                    return data;
                                }
                            }
                        },
                        customize: function(xlsx) {
                            var sheet = xlsx.xl.worksheets['sheet1.xml'];
                            var cols = $('col', sheet);

                            $('row', sheet).each(function() {
                                $('c', this).each(function(index) {
                                    var cellValue = $(this).text();
                                    var currentWidth = cols.eq(index).attr(
                                        'width') || 10;
                                    var newWidth = Math.max(currentWidth, cellValue
                                        .length * 1);
                                    cols.eq(index).attr('width', newWidth);
                                });
                            });

                            $('row c[r^="E"]', sheet).removeAttr('s');
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        title: 'Laporan Pengembalian Barang',
                        exportOptions: {
                            columns: ':visible',
                            orthogonal: 'export'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-info',
                        title: 'Laporan Pengembalian Barang',
                        exportOptions: {
                            columns: ':visible',
                            orthogonal: 'export'
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-primary',
                        title: 'Laporan Pengembalian Barang',
                        exportOptions: {
                            columns: ':visible',
                            orthogonal: 'export'
                        }
                    },
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-secondary',
                        title: 'Laporan Pengembalian Barang',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'colvis',
                        text: '<i class="fas fa-columns"></i> Kolom',
                        className: 'btn btn-warning'
                    }
                ]
            });

            $('#filter-tanggal-awal, #filter-tanggal-akhir').on('change', function() {
                table.draw();
            });

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var tanggalAwal = $('#filter-tanggal-awal').val();
                var tanggalAkhir = $('#filter-tanggal-akhir').val();
                var tanggalData = data[4] || "";

                if (tanggalAwal && tanggalAkhir) {
                    return (tanggalData >= tanggalAwal && tanggalData <= tanggalAkhir);
                }
                return true;
            });
        });
    </script>
@endpush
