@extends('template.SU')

@push('style')
    <style>
        table td {
            vertical-align: middle !important;
        }

        .d-flex button {
            height: 36px;
            line-height: 0px;

        }

        .d-flex button {
            padding: 0.375rem 0.75rem;

        }

        .d-flex button {
            margin-top: 10px;
        }
    </style>
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Daftar Pengguna</h1>
        <button class="btn btn-primary" data-toggle="modal" data-target="#modalUser" id="btnTambah">
            <i class="fas fa-plus"></i> Tambah Pengguna
        </button>
    </div>

    <div class="card shadow mb-4">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Role</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($Users as $user)
                            <tr>
                                <td>{{ $user->user_id }}</td>
                                <td>{{ $user->user_name }}</td>
                                <td>{{ $user->user_hak }}</td>
                                <td>
                                    <span class="badge {{ $user->user_sts == 1 ? 'badge-success' : 'badge-danger' }}">
                                        {{ $user->user_sts == 1 ? 'Aktif' : 'Tidak Aktif' }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex justify-content-start ">
                                        <button class="btn btn-info btn-sm btnEdit mr-2" data-id="{{ $user->user_id }}"
                                            data-name="{{ $user->user_name }}" data-hak="{{ $user->user_hak }}"
                                            data-status="{{ $user->user_sts }}">
                                            <i class="fas fa-edit"></i> Edit
                                        </button>

                                        <form class="d-flex deleteForm"
                                            action="{{ route('dpengguna.destroy', $user->user_id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash"></i> Hapus
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

{{-- Modal Tambah/Edit Pengguna --}}
<div class="modal fade" id="modalUser" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalUserTitle">Tambah Pengguna</h5>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>
            <form id="formUser" method="POST">
                @csrf
                <input type="hidden" id="user_id" name="user_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label>Nama Pengguna</label>
                        <input type="text" id="user_name" name="user_name" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label>Kata Sandi</label>
                        <input type="password" id="user_pass" name="user_pass" class="form-control">
                    </div>
                    <div class="mb-3">
                        <label>Hak Akses</label>
                        <select id="user_hak" name="user_hak" class="form-control" required>
                            <option value="">Pilih Hak Akses</option>
                            <option value="Su">Super User</option>
                            <option value="Admin">Admin</option>
                            <option value="User">User</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label>Status</label>
                        <select id="user_sts" name="user_sts" class="form-control" required>
                            <option value="1">Aktif</option>
                            <option value="0">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" id="btnSimpan">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>

@push('script')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const formUser = document.getElementById("formUser");
            const modalUser = new bootstrap.Modal(document.getElementById("modalUser"));
            const modalTitle = document.getElementById("modalUserTitle");
            const btnTambah = document.getElementById("btnTambah");

            // Tambah Pengguna
            btnTambah.addEventListener("click", function() {
                formUser.reset();
                formUser.action = "{{ route('dpengguna.store') }}";
                modalTitle.innerText = "Tambah Pengguna";

                const methodInput = formUser.querySelector("input[name='_method']");
                if (methodInput) methodInput.remove();

                document.getElementById("user_pass").required = true;
            });

            // Edit Pengguna
            document.querySelectorAll(".btnEdit").forEach(button => {
                button.addEventListener("click", function() {
                    const id = this.getAttribute("data-id");
                    const name = this.getAttribute("data-name");
                    const hak = this.getAttribute("data-hak");
                    const status = this.getAttribute("data-status");

                    formUser.action = `/superdpengguna/${id}`;
                    modalTitle.innerText = "Edit Pengguna";

                    const existingMethodInput = formUser.querySelector("input[name='_method']");
                    if (existingMethodInput) existingMethodInput.remove();

                    const methodInput = document.createElement("input");
                    methodInput.type = "hidden";
                    methodInput.name = "_method";
                    methodInput.value = "PATCH";
                    formUser.appendChild(methodInput);

                    document.getElementById("user_id").value = id;
                    document.getElementById("user_name").value = name;
                    document.getElementById("user_hak").value = hak;
                    document.getElementById("user_sts").value = status;
                    document.getElementById("user_pass").required = false;

                    modalUser.show();
                });
            });

            // Simpan Data (Tambah/Edit)
            formUser.addEventListener("submit", function(e) {
                e.preventDefault();
                let formData = new FormData(formUser);
                let action = formUser.action;
                let method = formUser.querySelector("input[name='_method']") ? "POST" : "POST";

                fetch(action, {
                        method: method,
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil!',
                                text: 'Data pengguna berhasil disimpan.',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                modalUser.hide();
                                location.reload();
                            });
                        }
                    });
            });

            // Hapus Pengguna
            document.addEventListener("DOMContentLoaded", function() {
                document.querySelectorAll(".deleteForm").forEach(form => {
                    form.addEventListener("submit", function(event) {
                        event.preventDefault(); // Mencegah form dikirim langsung

                        Swal.fire({
                            icon: 'warning',
                            title: 'Apakah Anda yakin?',
                            text: 'Data ini akan dihapus!',
                            showCancelButton: true,
                            confirmButtonText: 'Hapus',
                            cancelButtonText: 'Batal',
                            reverseButtons: true
                        }).then(result => {
                            if (result.isConfirmed) {
                                fetch(form.action, {
                                        method: 'POST',
                                        body: new FormData(form)
                                    }).then(response => response.json())
                                    .then(data => {
                                        if (data.success) {
                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Berhasil!',
                                                text: 'Data pengguna berhasil dihapus.',
                                                timer: 1500,
                                                showConfirmButton: false
                                            }).then(() => {
                                                location
                                                    .reload();
                                            });
                                        }
                                    });
                            }
                        });
                    });
                });
            });
        });
    </script>
@endpush
