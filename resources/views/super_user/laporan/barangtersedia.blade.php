@extends('template.SU')

@push('style')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet">

    <style>
        .dt-buttons .btn {
            margin: 5px;
            font-size: 14px;
            border-radius: 5px;
            color: white !important;
        }

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


        .table thead {
            background-color: #007bff;
            color: white;
        }

        .badge {
            font-size: 14px;
            padding: 5px 10px;
        }

        .filter-container {
            display: flex;
            justify-content: space-between;
            margin-bottom: 15px;
        }

        #global-search {
            border-radius: 5px;
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

            .table td:nth-child(4) {
                white-space: normal;
                word-wrap: break-word;
                max-width: 200px;
            }
        }
    </style>
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Barang Tersedia</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel</h6>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-4">
                    <label for="filter-kategori">📌 Filter Kategori:</label>
                    <select id="filter-kategori" class="form-control">
                        <option value="">Semua Kategori</option>
                        @foreach ($barang->unique('jns_brg_kode') as $b)
                            <option value="{{ $b->jenisBarang->jns_brg_nama ?? '-' }}">
                                {{ $b->jenisBarang->jns_brg_nama ?? '-' }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-4">
                    <label for="filter-tanggal-awal">📅 Dari Tanggal:</label>
                    <input type="date" id="filter-tanggal-awal" class="form-control">
                </div>
                <div class="col-md-4">
                    <label for="filter-tanggal-akhir">📅 Sampai Tanggal:</label>
                    <input type="date" id="filter-tanggal-akhir" class="form-control">
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    {{-- <table> --}}
                    <thead>
                        <tr>
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- ({{ $barang->jns_brg_kode }}) --}}
                        @foreach ($barang as $b)
                            <tr>
                                <td>{{ $b->br_kode }}</td>
                                <td>{{ $b->br_nama }}</td>
                                <td>{{ $b->jenisbarang->jns_brg_nama ?? '-' }} </td>
                                <td>{{ $b->br_tgl_terima }}</td>
                                <td>
                                    <span style="font-size: 15px"
                                        class="badge badge-{{ $b->br_status == 1 ? 'success' : 'danger' }}">
                                        {{ $b->status_label }}
                                    </span>
                                </td>

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
            if ($.fn.DataTable.isDataTable("#dataTable")) {
                $("#dataTable").DataTable().destroy();
            }

            var table = $('#dataTable').DataTable({
                "responsive": true,
                "autoWidth": false,
                "pageLength": 10,
                "dom": '<"row"<"col-md-7"B><"col-md-5"f>>rtip',
                "buttons": [{
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'btn btn-success',
                        title: 'Laporan Status Barang',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'btn btn-danger',
                        title: 'Laporan Status Barang',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Print',
                        className: 'btn btn-info',
                        title: 'Laporan Status Barang',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> CSV',
                        className: 'btn btn-primary',
                        title: 'Laporan Status Barang',
                        exportOptions: {
                            columns: ':visible'
                        }
                    },
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copy',
                        className: 'btn btn-secondary',
                        title: 'Laporan Status Barang',
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


            $('#global-search').on('keyup', function() {
                table.search(this.value).draw();
            });

            $('#filter-tanggal-awal, #filter-tanggal-akhir').on('change', function() {
                var tanggalAwal = $('#filter-tanggal-awal').val();
                var tanggalAkhir = $('#filter-tanggal-akhir').val();

                if (tanggalAwal && tanggalAkhir) {
                    table.draw();
                }
            });

            $('#filter-kategori').on('change', function() {
                var kategori = $(this).val();
                if (kategori) {
                    table.column(2).search(kategori).draw();
                } else {
                    table.column(2).search("").draw();
                }
            });

            $.fn.dataTable.ext.search.push(function(settings, data, dataIndex) {
                var tanggalAwal = $('#filter-tanggal-awal').val();
                var tanggalAkhir = $('#filter-tanggal-akhir').val();
                var tanggalData = data[3] || "";

                if (tanggalAwal && tanggalAkhir) {
                    return (tanggalData >= tanggalAwal && tanggalData <= tanggalAkhir);
                }
                return true;
            });
        });
    </script>
@endpush
