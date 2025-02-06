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
            <form action="{{ route('pbarang.store') }}" method="POST" id="barangForm">
                @csrf
                <!-- Input Kode Barang (Hidden) -->
                <input type="hidden" name="br_kode" id="br_kode" value="{{ $kodeBarang ?? '' }}">

                <!-- User -->
                <div class="form-group">
                    <label for="user_id">User</label>
                    <input type="hidden" name="user_id" id="user_id" value="{{ auth()->user()->user_id }}">
                    <input type="text" class="form-control" value="{{ auth()->user()->user_name }}" readonly>
                </div>

                <!-- Nama Barang -->
                <div class="form-group">
                    <label for="br_nama">Nama Barang</label>
                    <input type="text" name="br_nama" id="br_nama" class="form-control" value="{{ old('br_nama') }}"
                        maxlength="50" required>
                    <div class="invalid-feedback">Nama barang harus diisi.</div>
                </div>

                <!-- Jenis Barang -->
                <div class="form-group">
                    <label for="jns_brg_kode">Jenis Barang</label>
                    <select name="jns_brg_kode" id="jns_brg_kode" class="form-control" required>
                        <option value="" disabled selected> Pilih Jenis Barang </option>
                        @foreach ($jenisBarang as $jenis)
                            <option value="{{ $jenis->jns_brg_kode }}"
                                {{ old('jns_brg_kode') == $jenis->jns_brg_kode ? 'selected' : '' }}>
                                {{ $jenis->jns_brg_kode }} - {{ $jenis->jns_brg_nama }}
                            </option>
                        @endforeach
                    </select>
                    <div class="invalid-feedback">Pilih jenis barang yang tersedia.</div>
                </div>

                <!-- Tanggal Terima -->
                <div class="form-group">
                    <label for="br_tgl_terima">Tanggal Terima</label>
                    <input type="date" name="br_tgl_terima" id="br_tgl_terima" class="form-control"
                        value="{{ old('br_tgl_terima') }}" required>
                    <div class="invalid-feedback">Tanggal terima harus diisi.</div>
                </div>

                <!-- Status Barang -->
                <div class="form-group">
                    <label for="br_status">Status Barang</label>
                    <select name="br_status" id="br_status" class="form-control" required>
                        <option value="" disabled selected> Pilih Status Barang </option>
                        <option value="1" {{ old('br_status') === '1' ? 'selected' : '' }}>Tersedia</option>
                        <option value="0" {{ old('br_status') === '0' ? 'selected' : '' }}>Tidak Tersedia</option>
                    </select>
                    <div class="invalid-feedback">Status barang harus dipilih.</div>
                </div>

                <!-- Kondisi Barang -->
                <div class="form-group">
                    <label for="br_con">Kondisi Barang</label>
                    <select name="br_con" id="br_con" class="form-control" required>
                        <option value="1" {{ old('br_con') === '1' ? 'selected' : '' }}>Kondisi Baik</option>
                        <option value="2" {{ old('br_con') === '2' ? 'selected' : '' }}>Rusak (Bisa Diperbaiki)
                        </option>
                        <option value="3" {{ old('br_con') === '3' ? 'selected' : '' }}>Rusak (Tidak Bisa Digunakan)
                        </option>
                        <option value="0" {{ old('br_con') === '0' ? 'selected' : '' }}>Dihapus dari Sistem</option>
                    </select>
                    <div class="invalid-feedback">Pilih kondisi barang.</div>
                </div>


                <!-- Tombol Submit -->
                <button type="submit" class="btn btn-primary">Kirim</button>
            </form>
        </div>
    </div>
@endsection


@push('script')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('barangForm');

            form.addEventListener('submit', function(event) {
                let isValid = true;

                // Validasi default HTML5
                if (!form.checkValidity()) {
                    isValid = false;
                }

                // Validasi tambahan untuk dropdown
                const jenisBarang = document.getElementById('jns_brg_kode');
                const statusBarang = document.getElementById('br_status');

                if (!jenisBarang.value) {
                    jenisBarang.classList.add('is-invalid');
                    isValid = false;
                } else {
                    jenisBarang.classList.remove('is-invalid');
                }

                if (!statusBarang.value) {
                    statusBarang.classList.add('is-invalid');
                    isValid = false;
                } else {
                    statusBarang.classList.remove('is-invalid');
                }

                if (!isValid) {
                    event.preventDefault();
                    event.stopPropagation();
                }

                form.classList.add('was-validated');
            }, false);
        });
    </script>
@endpush
