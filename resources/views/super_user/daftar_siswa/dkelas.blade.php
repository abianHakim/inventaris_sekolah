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
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Daftar Kelas</h1>
    </div>


    <button type="button" class="btn btn-primary btn-icon-split" data-mode="add" data-toggle="modal" data-target="#dataModal">
        <span class="text">Tambah Data Kelas</span>
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
                            <th>id</th>
                            <th>Kelas</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($kelas as $kel)
                            <tr>
                                <td>{{ $kel->id }}</td>

                                <td>{{ $kel->nama_kelas . ' ' . $kel->nama_jurusan }}</td>

                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="#" class="btn btn-warning btn-circle edit-btn"
                                        data-id="{{ $kel->id }}" data-nama_kelas="{{ $kel->nama_kelas }}"
                                        data-nama_jurusan="{{ $kel->nama_jurusan }}" data-mode="edit" data-toggle="modal"
                                        data-target="#dataModal">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <!-- Form Delete -->
                                    <form action="{{ route('kelas.destroy', $kel->id) }}" method="POST" class="d-inline"
                                        id="deleteForm-{{ $kel->id }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-circle deleteBtn"
                                            data-id="{{ $kel->id }}">
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


<!-- Modal Tambah Data -->
<div class="modal fade" id="dataModal" tabindex="-1" role="dialog" aria-labelledby="dataModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="dataModalLabel">Tambah/Edit Data Kelas</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <form id="dataForm" method="POST">
                @csrf
                <div class="modal-body">
                    <!-- Field Nama Kelas -->
                    <div class="form-group">
                        <label for="nama_kelas">Kelas Berapa</label>
                        <select class="form-control" id="nama_kelas" name="nama_kelas" required>
                            <option value="" disabled selected>Pilih Kelas</option>
                            <option value="X">X</option>
                            <option value="XI">XI</option>
                            <option value="XII">XII</option>
                        </select>
                    </div>

                    <!-- Field Nama Jurusan -->
                    <div class="form-group">
                        <label for="nama_jurusan">Nama Jurusan</label>
                        <select class="form-control" id="nama_jurusan" name="nama_jurusan" required>
                            <option value="" disabled selected>Pilih Jurusan yang Tersedia</option>
                            <option value="PPLG-RPL 1">PPLG-RPL 1</option>
                            <option value="PPLG-GIM 1">PPLG-GIM 1</option>
                            <option value="MPLB-ML 1">MPLB-ML 1</option>
                            <option value="MPLB-ML 2">MPLB-ML 2</option>
                            <option value="MPLB-MP 1">MPLB-MP 1</option>
                            <option value="MPLB-MP 2">MPLB-MP 2</option>
                            <option value="MPLB-MP 3">MPLB-MP 3</option>
                            <option value="AKKUL-AK 1">AKKUL-AK 1</option>
                            <option value="AKKUL-AK 2">AKKUL-AK 2</option>
                            <option value="AKKUL-AK 3">AKKUL-AK 3</option>
                            <option value="AKKUL-AK 4">AKKUL-AK 4</option>
                            <option value="AKKUL-PB 1">AKKUL-PB 1</option>
                            <option value="TKJ-TR 1">TKJ-TR 1</option>
                            <option value="TKJ-TK 1">TKJ-TK 1</option>
                            <option value="TKJ-TK 2">TKJ-TK 2</option>
                        </select>
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


@push('style')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
            $('#dataForm').on('submit', function(e) {
                e.preventDefault();

                $.ajax({
                    url: $(this).attr('action'),
                    method: $(this).attr('method'),
                    data: $(this).serialize(),
                    success: function(response) {
                        $('#dataModal').modal('hide');
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil disimpan',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                location.reload();
                            }
                        });
                    },
                    error: function(error) {
                        Swal.fire({
                            title: 'Error!',
                            text: 'Terjadi kesalahan saat menyimpan data',
                            icon: 'error',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });

            $('.deleteBtn').on('click', function() {
                const id = $(this).data('id');
                Swal.fire({
                    title: 'Apakah anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $(`#deleteForm-${id}`).submit();
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Data berhasil dihapus',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                    }
                });
            });
        });

        $(document).on('click', '[data-target="#dataModal"]', function() {
            const mode = $(this).data('mode');
            const modalTitle = $('#dataModalLabel');
            const dataForm = $('#dataForm');

            dataForm[0].reset();

            if (mode === 'add') {
                modalTitle.text('Tambah Data Kelas');
                dataForm.attr('action', '{{ route('kelas.store') }}');
                dataForm.find('input[name="_method"]').remove();
            }

            if (mode === 'edit') {
                modalTitle.text('Edit Data Kelas');
                const id = $(this).data('id');
                const nama_kelas = $(this).data('nama_kelas');
                const nama_jurusan = $(this).data('nama_jurusan');

                $('#nama_kelas').val(nama_kelas);
                $('#nama_jurusan').val(nama_jurusan);

                dataForm.attr('action', `superkelas/${id}`);

                if (!dataForm.find('input[name="_method"]').length) {
                    dataForm.append('<input type="hidden" name="_method" value="PATCH">');
                }
            }
        });
    </script>
@endpush
