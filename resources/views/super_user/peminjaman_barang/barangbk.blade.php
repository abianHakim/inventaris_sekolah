@extends('template.SU')

@push('style')
@endpush

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800" style="color: black">Barang Belum kembali</h1>
        </div>
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Daftar Peminjaman</h6>
            </div>
            <div class="card-body">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Id Peminjaman</th>
                            <th>Barang</th>
                            <th>Nama Siswa</th>
                            <th>Tanggal Peminjaman</th>
                            <th>Tanggal Harus Kembali</th>
                            <th>Status</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $p)
                            <tr>
                                <td>{{ $p->pb_id }}</td>
                                <td>
                                    <ul>
                                        <ul style="list-style: none; margin: 0; padding: 0">
                                            @foreach ($p->detailPeminjaman as $detail)
                                                <li style="float: left; margin-right: 10px">
                                                    &bull; {{ $detail->barang->br_nama }}</li>
                                            @endforeach
                                        </ul>
                                    </ul>
                                </td>
                                <td>{{ $p->siswa->nama_siswa }}</td>
                                <td>{{ $p->pb_tgl->format('d-m-Y') }}</td>
                                <td>{{ $p->pb_harus_kembali_tgl->format('d-m-Y') }}</td>
                                <td>
                                    <span class="badge badge-danger">
                                        Belum Kembali
                                    </span>
                                </td>
                            </tr>
                        @endforeach
                        {{-- ({{ $detail->br_kode }}) --}}
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection





@push('style')
@endpush
