@extends('template.SU')

@push('style')
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Data Pengembalian Barang</h1>
    </div>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>ID Kembali</th>
                            <th>Penanggung Jawab</th>
                            <th>Siswa</th>
                            <th>Barang yang Dikembalikan</th>
                            <th>Tanggal Kembali</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pengembalian as $kembali)
                            <tr>
                                <td>{{ $kembali->kembali_id }}</td>
                                <td>{{ $kembali->user->name ?? 'Tidak Ada User' }}</td>
                                <td>{{ $kembali->peminjaman->siswa->nama_siswa }}</td>

                                <td>
                                    <ul style="list-style: none; margin: 0; padding: 0">
                                        @foreach ($kembali->peminjaman->detailPeminjaman as $detail)
                                            <li style="float: left; margin-right: 10px">
                                                &bull; {{ $detail->barang->br_nama }}
                                            </li>
                                        @endforeach
                                    </ul>
                                </td>
                                <td>{{ \Carbon\Carbon::parse($kembali->kembali_tgl)->format('Y-m-d') }}</td>
                                <td>
                                    <span style="font-size: 15px"
                                        class="badge badge-{{ $kembali->kembali_sts == 1 ? 'success' : 'danger' }}">
                                        {{ $kembali->kembali_sts == 1 ? 'Dikembalikan' : 'Belum Dikembalikan' }}
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





@push('style')
@endpush
