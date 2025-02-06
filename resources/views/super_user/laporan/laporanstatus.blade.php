@extends('template.SU')

@push('style')
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Laporan Status Barang</h1>
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
                            <th>Kode Barang</th>
                            <th>Nama Barang</th>
                            <th>Jenis Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Kondisi Barang</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($barang as $brg)
                            <tr>
                                <td>{{ $brg->br_kode }}</td>
                                <td>{{ $brg->br_nama }}</td>
                                <td>{{ $brg->jenisBarang->jns_brg_nama ?? 'Jenis Tidak Tersedia' }}</td>
                                <td>{{ \Carbon\Carbon::parse($brg->br_tgl_terima)->format('Y-m-d') }}</td>
                                <td style="font-size: 20px">
                                    @php
                                        $kondisi = [
                                            'Dihapus dari Sistem',
                                            'Kondisi Baik',
                                            'Rusak (Bisa Diperbaiki)',
                                            'Rusak (Tidak Bisa Digunakan)',
                                        ];
                                        $warna = ['', 'success', 'warning', 'danger'];
                                    @endphp

                                    @if ($brg->br_con != 0)
                                        <span
                                            class="badge badge-{{ $warna[$brg->br_con] }}">{{ $kondisi[$brg->br_con] }}</span>
                                    @else
                                        {{ $kondisi[0] }}
                                    @endif
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
