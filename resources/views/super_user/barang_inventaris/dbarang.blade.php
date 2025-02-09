@extends('template.su')

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
        <h1 class="h3 mb-0" style="color: black">Daftar Barang</h1>
    </div>

    <a href="{{ route('pbarang') }}" class="btn btn-primary btn-icon-split mb-4">
        <span class="text">Tambah Jenis Barang</span>
        <span class="icon text-white-50">
            <i class="fas fa-plus"></i>
        </span>
    </a>

    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Tabel</h6>
        </div>

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}'
                });
            </script>
        @elseif (session('error'))
            <script>
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: '{{ session('error') }}'
                });
            </script>
        @endif
        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Berhasil',
                    text: '{{ session('success') }}'
                });
            </script>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>kode</th>
                            <th>Jenis Barang</th>
                            {{-- <th>User id</th> --}}
                            <th>Nama Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Kondisi</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        {{-- ({{ $barang->jns_brg_kode }}) --}}
                        @foreach ($barangInventaris as $barang)
                            <tr>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->jenisbarang->jns_brg_nama ?? '-' }} </td>
                                {{-- <td>{{ $barang->user_id }}</td>     --}}
                                <td>{{ $barang->br_nama }}</td>
                                <td>{{ $barang->br_tgl_terima }}</td>
                                <td>
                                    @switch($barang->br_con)
                                        @case(1)
                                            Kondisi Baik
                                        @break

                                        @case(2)
                                            Rusak (Bisa Diperbaiki)
                                        @break

                                        @case(3)
                                            Rusak (Tidak Bisa Digunakan)
                                        @break
                                    @endswitch
                                </td>
                                <td>{{ $barang->status_label }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="#" class="btn btn-warning btn-circle edit-btn" data-toggle="modal"
                                        data-target="#editModal" data-id="{{ $barang->br_kode }}"
                                        data-nama="{{ $barang->br_nama }}" data-jenis="{{ $barang->jns_brg_kode }}"
                                        data-tgl_terima="{{ $barang->br_tgl_terima }}"
                                        data-status="{{ $barang->br_status }}" data-con="{{ $barang->br_con }}">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Form Delete -->
                                    <form action="{{ route('pbarang.destroy', $barang->br_kode) }}" method="POST"
                                        class="d-inline" id="deleteForm-{{ $barang->br_kode }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-circle deleteBtn"
                                            data-id="{{ $barang->br_kode }}">
                                            <i class="fas fa-trash"></i>
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

<!-- Modal Edit -->
<div class="modal fade" id="editModal" tabindex="-1" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">Edit Barang</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="{{ route('pbarang.update', ':br_kode') }}">
                @csrf
                @method('PATCH')
                <!-- Form Fields -->
                <div class="modal-body">
                    <div class="form-group">
                        <label for="edit_br_kode">Kode Barang</label>
                        <input type="text" class="form-control" id="edit_br_kode" name="br_kode" readonly>
                    </div>
                    <div class="form-group">
                        <label for="edit_br_nama">Nama Barang</label>
                        <input type="text" class="form-control" id="edit_br_nama" name="br_nama">
                    </div>
                    <div class="form-group">
                        <label for="edit_jns_brg_kode">Jenis Barang</label>
                        <select class="form-control" id="edit_jns_brg_kode" name="jns_brg_kode">
                            <option value="">-- Pilih Jenis Barang --</option>
                            @foreach ($jenisBarang as $jenis)
                                <option value="{{ $jenis->jns_brg_kode }}">{{ $jenis->jns_brg_kode }} -
                                    {{ $jenis->jns_brg_nama }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_br_tgl_terima">Tanggal Terima</label>
                        <input type="date" class="form-control" id="edit_br_tgl_terima" name="br_tgl_terima">
                    </div>
                    <div class="form-group">
                        <label for="edit_br_status">Status Barang</label>
                        <select class="form-control" id="edit_br_status" name="br_status">
                            <option value="1">Terseda</option>
                            <option value="0">Tidak Tersedia</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit_br_con">Kondisi Barang</label>
                        <select class="form-control" id="edit_br_con" name="br_con">
                            <option value="1">Kondisi Baik</option>
                            <option value="2">Rusak (Bisa Diperbaiki)</option>
                            <option value="3">Rusak (Tidak Bisa Digunakan)</option>
                            <option value="0">Dihapus dari Sistem</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tambahkan event listener ke tombol delete
        $(document).on('click', '.deleteBtn', function(e) {
            e.preventDefault();
            var formId = $(this).data('id');
            var deleteForm = $('#deleteForm-' + formId);

            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Data ini akan dihapus dan tidak bisa dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Hapus',
                cancelButtonText: 'Batal',
                reverseButtons: true
            }).then((result) => {
                if (result.isConfirmed) {
                    deleteForm.submit();
                }
            });
        });

        // Edit Modal
        $(document).on('click', '.edit-btn', function() {
            var br_kode = $(this).data('id');
            var br_nama = $(this).data('nama');
            var jns_brg_kode = $(this).data('jenis');
            var br_tgl_terima = $(this).data('tgl_terima');
            var br_status = $(this).data('status');
            var br_con = $(this).data('con');

            $('#edit_br_kode').val(br_kode);
            $('#edit_br_nama').val(br_nama);
            $('#edit_jns_brg_kode').val(jns_brg_kode);
            $('#edit_br_tgl_terima').val(br_tgl_terima);
            $('#edit_br_status').val(br_status);
            $('#edit_br_con').val(br_con)

            var actionUrl = '{{ route('pbarang.update', ':br_kode') }}';
            actionUrl = actionUrl.replace(':br_kode', br_kode);
            $('#editForm').attr('action', actionUrl);
        });
    </script>


    <script>
        @if (session('success'))
            Swal.fire({
                title: 'Sukses!',
                text: '{{ session('success') }}',
                icon: 'success',
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true
            });
        @endif
    </script>
@endpush
