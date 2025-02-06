@extends('template.SU')

@push('style')
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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>kode</th>
                            <th>Jenis Barang</th>
                            <th>Nama Barang</th>
                            <th>Status</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- ({{ $barang->jns_brg_kode }}) --}}
                        @foreach ($barang as $b)
                            <tr>
                                <td>{{ $b->br_kode }}</td>
                                <td>{{ $b->jenisbarang->jns_brg_nama ?? '-' }} </td>
                                <td>{{ $b->br_nama }}</td>
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





@push('style')
@endpush
