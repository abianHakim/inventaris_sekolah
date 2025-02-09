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
        <h1 class="h3 mb-0 text-gray-800" style="color: black">Daftar Siswa</h1>
    </div>

    <button type="button" class="btn btn-primary btn-icon-split" data-mode="add" data-toggle="modal" data-target="#tambahModal">
        <span class="text">Tambah Data Siswa</span>
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
                            <th>NISN</th>
                            <th>Nama Siswa</th>
                            <th>Kelas</th>
                            <th>No Siswa</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($Siswa as $siswa)
                            <tr>
                                <td>{{ $siswa->siswa_id }}</td>
                                <td>{{ $siswa->nisn }}</td>
                                <td>{{ $siswa->nama_siswa }}</td>
                                <td>{{ $siswa->kelas->nama_kelas . ' ' . $siswa->kelas->nama_jurusan }}</td>
                                <td>{{ $siswa->no_siswa }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <button type="button" class="btn btn-warning btn-circle edit-btn" data-toggle="modal"
                                        data-target="#tambahModal" data-mode="edit" data-id="{{ $siswa->siswa_id }}"
                                        data-nisn="{{ $siswa->nisn }}" data-nama="{{ $siswa->nama_siswa }}"
                                        data-kelas="{{ $siswa->kelas_id }}">
                                        <i class="fas fa-edit"></i>
                                    </button>
                                    <!-- Form Delete -->
                                    <form action="{{ route('siswa.destroy', $siswa->siswa_id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-circle">
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

<!-- Modal Tambah Siswa -->
<div class="modal fade" id="tambahModal" tabindex="-1" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="tambahModalLabel">Tambah / Edit Siswa</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
            </div>
            <!-- Form Edit / Add -->
            <form action="{{ route('siswa.store') }}" method="POST" id="tambahForm">
                @csrf
                <input type="hidden" name="siswa_id" value="{{ old('siswa_id') }}">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="nisn" class="form-label">NISN</label>
                        <input type="text" class="form-control" id="nisn" name="nisn" required
                            value="{{ old('nisn') }}">
                    </div>
                    <div class="mb-3">
                        <label for="nama_siswa" class="form-label">Nama Siswa</label>
                        <input type="text" class="form-control" id="nama_siswa" name="nama_siswa" required
                            value="{{ old('nama_siswa') }}">
                    </div>
                    <div class="mb-3">
                        <label for="kelas_id" class="form-label">Kelas</label>
                        <select class="form-control" id="kelas_id" name="kelas_id" required>
                            @foreach ($Kelas as $kelas)
                                <option value="{{ $kelas->id }}"
                                    {{ old('kelas_id') == $kelas->id ? 'selected' : '' }}>
                                    {{ $kelas->nama_kelas . ' ' . $kelas->nama_jurusan }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
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
            // Handle delete confirmation
            $('.delete-form').on('submit', function(e) {
                e.preventDefault();
                const form = $(this);

                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.unbind('submit').submit(); // Submit form jika user mengonfirmasi
                    }
                });
            });

            // Menangani klik untuk modal tambah/update
            $(document).on('click', '[data-toggle="modal"]', function() {
                const mode = $(this).data('mode');
                const form = $('#tambahModal form');

                // Reset form
                form[0].reset();
                form.find('input[name="_method"]').remove();

                if (mode === 'add') {
                    form.attr('action', '{{ route('siswa.store') }}');
                    form.attr('method', 'POST');
                    $('#tambahModalLabel').text('Tambah Siswa');
                } else if (mode === 'edit') {
                    const siswaId = $(this).data('id');
                    const nisn = $(this).data('nisn');
                    const nama = $(this).data('nama');
                    const kelasId = $(this).data('kelas');

                    form.attr('action', `/supersiswa/${siswaId}`);
                    form.attr('method', 'POST');
                    form.append('<input type="hidden" name="_method" value="PATCH">');
                    $('#tambahModalLabel').text('Edit Siswa');

                    // Set values to form fields
                    $('#nisn').val(nisn);
                    $('#nama_siswa').val(nama);
                    $('#kelas_id').val(kelasId);
                }
            });

            // Menampilkan pop-up sukses setelah data disimpan atau dihapus
            @if (session('success'))
                Swal.fire({
                    icon: 'success',
                    title: 'Sukses!',
                    text: '{{ session('success') }}',
                    showConfirmButton: false,
                    timer: 1500 
                });
            @endif
        });
    </script>
@endpush
