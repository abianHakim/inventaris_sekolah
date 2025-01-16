@extends('template.SU')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" style="color: black">Daftar Barang</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>kode</th>
                            <th>Jenis Barang</th>
                            <th>User id</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Tanggal Entry</th>
                            <th>Status</th>
                            <th>Aksi</th>

                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($barangInventaris as $barang)
                            <tr>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->jenisbarang->jns_brg_nama ?? '-' }} ({{ $barang->jns_brg_kode }})</td>
                                <td>{{ $barang->user_id }}</td>
                                <td>{{ $barang->br_nama }}</td>
                                <td>{{ $barang->br_tgl_terima }}</td>
                                <td>{{ $barang->br_tgl_entry }}</td>
                                <td>{{ $barang->br_status }}</td>
                                <td>
                                    {{-- <a href="{{ route('barangInventaris.edit', $barang->br_kode) }}" --}}
                                    <a href="#" class="btn btn-warning btn-circle">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    {{-- <form action="{{ route('barangInventaris.destroy', $barang->br_kode) }}" method="POST" --}}
                                    <form action="#" method="POST" class="d-inline">
                                        @csrf
                                        @method('delete')
                                        <button type="submit" class="btn btn-danger btn-circle">
                                            <i class="fas fa-trash"></i>
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
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "lengthMenu": [10, 25, 50, 100],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });
    </script>
@endpush
