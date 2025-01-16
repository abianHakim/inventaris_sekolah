@extends('template.SU')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Penerimaan Barang</h1>
    </div>

    <div class="card">
        <div class="card-header">
            <h5>Form Input Barang</h5>
        </div>
        <div class="card-body">
            <form action="" method="POST">
                @csrf
                <div class="form-group">
                    <input type="hidden" name="br_kode" id="br_kode" value="">
                </div>
                <div class="form-group">
                    <label for="jns_brg_kode">Jenis Barang</label>
                    <select name="jns_brg_kode" id="jns_brg_kode" class="form-control">
                        <option value="">-- Pilih Jenis Barang --</option>
                        @foreach ($jenisBarang as $jenis)
                            <option value="{{ $jenis->jns_brg_kode }}">{{ $jenis->jns_brg_kode }} -
                                {{ $jenis->jns_brg_nama }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="user_id">User</label>
                    <input type="text" name="user_id" id="user_id" class="form-control"
                        value="{{ auth()->user()->user_name }}" readonly>
                </div>
                <div class="form-group">
                    <label for="br_nama">Nama Barang</label>
                    <input type="text" name="br_nama" id="br_nama" class="form-control" maxlength="50">
                </div>
                <div class="form-group">
                    <label for="br_tgl_terima">Tanggal Terima</label>
                    <input type="date" name="br_tgl_terima" id="br_tgl_terima" class="form-control"
                        max="{{ date('Y-m-d') }}">
                </div>
                <div class="form-group">
                    <label for="br_status">Status Barang</label>
                    <input type="text" name="br_status" id="br_status" class="form-control" maxlength="2">
                </div>
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
@endsection
