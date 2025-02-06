@extends('template.SU')

@push('style')
    <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800" style="color: black">Daftar Peminjaman</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success" id="alert-success" style="display: none;">
                {{ session('success') }}
            </div>
        @elseif(session('error'))
            <div class="alert alert-danger" id="alert-error" style="display: none;">
                {{ session('error') }}
            </div>
        @endif

        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID Peminjaman</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tenggat Pengembalian</th>
                            <th>Barang Dipinjam</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman->sortByDesc(fn($p) => $p->pb_stat == 1) as $p)
                            <tr>
                                <td>{{ $p->pb_id }}</td>
                                <td>{{ $p->siswa->nama_siswa }}</td>
                                <td>{{ $p->pb_tgl->format('d-m-Y') }}</td>
                                <td>{{ $p->pb_harus_kembali_tgl->format('d-m-Y') }}</td>
                                <td>
                                    <ul style="list-style: none; margin: 0; padding: 0">
                                        @foreach ($p->detailPeminjaman as $detail)
                                            <li style="float: left; margin-right: 10px">
                                                &bull; {{ $detail->barang->br_nama }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>
                                    <span class="badge badge-{{ $p->pb_stat == 1 ? 'success' : 'danger' }}">
                                        {{ $p->pb_stat == 1 ? 'Dipinjam' : 'Dikembalikan' }}
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('success') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        @elseif (session('error'))
            Swal.fire({
                title: 'Error!',
                text: '{{ session('error') }}',
                icon: 'error',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true
            });
        @endif
    </script>
@endpush
