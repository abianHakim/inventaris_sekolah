@extends('template.SU')

@push('style')
    <style>
        table td {
            vertical-align: middle !important;
        }

        .custom-btn {
            padding: 10px 15px;
        }

        .btn-sm {
            margin: 0;
        }

        form {
            margin-bottom: 0 !important;
        }

        .btn-icon-split .text {
            margin-right: 5px;
        }

        .btn-icon-split .icon {
            display: flex;
            align-items: center;
        }

        .btn:hover {
            opacity: 0.85;
            cursor: pointer;
        }

        .btn-info:hover {
            background-color: #17a2b8;
        }

        .btn-danger:hover {
            background-color: #dc3545;
        }
    </style>
@endpush


@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Jenis Barang</h1>
    </div>

    <button type="button" class="btn btn-primary btn-icon-split" data-toggle="modal" data-target="#exampleModal">
        <span class="text">Tambah Jenis Barang</span>
        <span class="icon text-white-50">
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
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($tr_jenis_barang as $barang)
                            <tr>
                                <td>{{ $barang->jns_brg_kode }}</td>
                                <td>{{ $barang->jns_brg_nama }}</td>
                                <td>
                                    <!-- Tombol Update -->
                                    <button class="btn btn-info btn-sm custom-btn mr-2" data-toggle="modal"
                                        data-target="#exampleModal" data-kode="{{ $barang->jns_brg_kode }}"
                                        data-nama="{{ $barang->jns_brg_nama }}">
                                        <i class="fas fa-edit"></i> Update
                                    </button>

                                    <!-- Tombol Delete -->
                                    <form action="{{ route('jbarang.destroy', ['jns_brg_kode' => $barang->jns_brg_kode]) }}"
                                        method="POST" style="display: inline-block;">
                                        @csrf
                                        @method('DELETE') <!-- Pastikan ini ada -->
                                        <button type="submit" class="delete-btn btn btn-danger btn-sm custom-btn">
                                            <i class="fas fa-trash-alt"></i> Delete
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

{{-- modal tambah data --}}
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Jenis Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="modalForm" action="{{ route('jbarang.store') }}" method="POST">
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
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>



@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>



    <script>
        $(document).ready(function() {
            // Fokus otomatis ke input nama saat modal dibuka
            $('#exampleModal').on('shown.bs.modal', function() {
                $('#jns_brg_nama').focus();
            });

            // Konfirmasi penghapusan dengan SweetAlert
            $('.delete-btn').click(function(e) {
                e.preventDefault();

                let form = $(this).closest('form');
                let kode = form.find('input[name="jns_brg_kode"]').val(); // Ambil kode dari form

                // Pengecekan dengan SweetAlert
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: 'Data yang dihapus tidak dapat dikembalikan!',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Hapus!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Kirim permintaan ajax untuk memeriksa ketergantungan
                        $.ajax({
                            url: '/check-barang-terkait/' +
                            kode, // URL endpoint untuk pengecekan barang terkait
                            method: 'GET',
                            success: function(response) {
                                if (response.barangTerkait) {
                                    // Jika ada barang yang terkait, tampilkan pesan error
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Gagal!',
                                        text: 'Jenis Barang ini tidak dapat dihapus karena ada barang yang terkait.',
                                        timer: 3000,
                                        showConfirmButton: false
                                    });
                                } else {
                                    // Jika tidak ada barang yang terkait, lanjutkan submit form
                                    form.submit();
                                }
                            },
                            error: function(xhr, status, error) {
                                // Tangani error jika permintaan ajax gagal
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Terjadi Kesalahan!',
                                    text: 'Gagal memproses permintaan.',
                                });
                            }
                        });
                    }
                });
            });

            // Event saat modal dibuka (untuk update dan tambah)
            $('#exampleModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var nama = button.data('nama');
                var kode = button.data('kode');
                var modal = $(this);
                var form = modal.find('#modalForm');

                // Cek update atau tambah
                if (nama) {

                    modal.find('.modal-title').text('Update Jenis Barang');
                    modal.find('#jns_brg_nama').val(nama);

                    // Update action URL dan method
                    var actionUrl = '{{ route('jbarang.update', ':jns_brg_kode') }}';
                    actionUrl = actionUrl.replace(':jns_brg_kode', kode);
                    form.attr('action', actionUrl);

                    // Menambahkan method PATCH
                    form.find('[name="_method"]').remove();
                    form.append('<input type="hidden" name="_method" value="PATCH">');

                    $('#btnSubmit').text('Update');
                } else {
                    // Modal untuk Tambah
                    modal.find('.modal-title').text('Tambah Jenis Barang');
                    modal.find('#jns_brg_nama').val('');

                    // Set action URL untuk store
                    form.attr('action', '{{ route('jbarang.store') }}');
                    form.find('[name="_method"]').remove();
                    $('#btnSubmit').text('Simpan');
                }
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

            // SweetAlert untuk notifikasi error jika ada masalah dalam penghapusan
            @if (session('error'))
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal!',
                    text: '{{ session('error') }}',
                    timer: 3000,
                    showConfirmButton: false
                });
            @endif
        });
    </script>
@endpush
