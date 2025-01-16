@extends('template.SU')

@push('style')
@endpush


@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Jenis Barang</h1>
    </div>

    <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#exampleModal">
        <span class="text">Tambah Jenis Barang</span>
        <span class="icon text-white-50 ">
            <i class="fas fa-plus"></i>
        </span>
    </button>

    <div class="card shadow mb-4 mt-3">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>kode</th>
                            <th>Jenis Barang Nama</th>

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tr_jenis_barang as $barang)
                            <tr>
                                <td>{{ $barang->jns_brg_kode }}</td>
                                <td>{{ $barang->jns_brg_nama }}</td>
                            </tr>
                        @endforeach


                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

<!-- Modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Kode Jenis Barang (Max 5)</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('superuser.jbarang.store') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jns_brg_nama">Nama</label>
                        <input type="text" class="form-control @error('jns_brg_nama') is-invalid @enderror"
                            id="jns_brg_nama" name="jns_brg_nama" placeholder="Masukkan Nama Jenis Barang">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        $(document).ready(function() {
            $('#exampleModal').on('shown.bs.modal', function() {
                $('#jns_brg_nama').focus();
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            // Fokus otomatis ke input nama saat modal dibuka
            $('#exampleModal').on('shown.bs.modal', function() {
                $('#jns_brg_nama').focus();
            });

            // SweetAlert untuk notifikasi sukses
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil!',
                    text: '{{ session('success') }}',
                    timer: 1500,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endpush
