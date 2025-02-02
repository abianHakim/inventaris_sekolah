@extends('template.SU')

@push('style')
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Pengembalian Barang</h1>
    </div>

    <div class="card shadow">
        <div class="card-header">
            <h6 class="m-0 font-weight-bold text-primary">Daftar Pengembalian Barang</h6>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID Pengembalian</th>
                        <th>ID Peminjaman</th>
                        <th>Nama User</th>
                        <th>Tanggal Pengembalian</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($pengembalian as $data)
                        <tr>
                            <td>{{ $data->kembali_id }}</td>
                            <td>{{ $data->pb_id }}</td>
                            <td>{{ $data->user->user_name ?? 'Tidak Diketahui' }}</td>
                            <td>{{ $data->kembali_tgl }}</td>
                            <td>
                                @if ($data->kembali_sts == 1)
                                    <span class="badge badge-success">Sudah Dikembalikan</span>
                                @else
                                    <span class="badge badge-danger">Belum Dikembalikan</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection





@push('style')
@endpush
