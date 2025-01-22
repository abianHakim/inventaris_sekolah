@extends('template.SU')

@push('style')
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0" style="color: black">Daftar Barang</h1>
    </div>

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
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>kode</th>
                            <th>Jenis Barang</th>
                            <th>User id</th>
                            <th>Nama Barang</th>
                            <th>Tanggal Terima</th>
                            <th>Tanggal Entry</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach ($barangInventaris as $barang)
                            <tr>
                                <td>{{ $barang->br_kode }}</td>
                                <td>{{ $barang->jenisbarang->jns_brg_nama ?? '-' }} ({{ $barang->jns_brg_kode }})</td>
                                <td>{{ $barang->user_id }}</td>
                                <td>{{ $barang->br_nama }}</td>
                                <td>{{ $barang->br_tgl_terima }}</td>
                                <td>{{ $barang->br_tgl_entry }}</td>
                                <td>{{ $barang->status_label }}</td>
                                <td>
                                    <!-- Tombol Edit -->
                                    <a href="#" class="btn btn-warning btn-circle" data-toggle="modal"
                                        data-target="#editModal" data-id="{{ $barang->br_kode }} "
                                        data-nama="{{ $barang->br_nama }}" data-jenis="{{ $barang->jns_brg_kode }} "
                                        data-tgl_terima="{{ $barang->br_tgl_terima }}"
                                        data-status="{{ $barang->br_status }}">
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
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="editForm" method="POST" action="{{ route('pbarang.update', ':br_kode') }}">
                @csrf
                @method('PATCH')
                <div class="modal-body">
                    <!-- Form Fields -->
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>
        // Tambahkan event listener ke tombol delete
        $(document).on('click', '.deleteBtn', function(e) {
            e.preventDefault(); // Mencegah form langsung dikirimkan

            // Ambil ID dari data-id pada tombol
            var formId = $(this).data('id');
            var deleteForm = $('#deleteForm-' + formId);

            // Konfirmasi menggunakan SweetAlert2
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
                    // Jika konfirmasi "Hapus" diklik, submit form
                    deleteForm.submit();
                }
            });
        });
    </script>

    <script>
        $(document).ready(function() {
            $('#dataTable').DataTable({
                "paging": true,
                "lengthChange": true,
                "lengthMenu": [10, 25, 50, 100],
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "dom": 'Bfrtip',
                "buttons": [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            });
        });

        $('#editModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget); // Tombol yang dipilih untuk membuka modal
            var br_kode = button.data('id');
            var br_nama = button.data('nama');
            var jns_brg_kode = button.data('jenis');
            var br_tgl_terima = button.data('tgl_terima');
            var br_status = button.data('status');

            var modal = $(this);
            modal.find('#edit_br_kode').val(br_kode);
            modal.find('#edit_br_nama').val(br_nama);
            modal.find('#edit_jns_brg_kode').val(jns_brg_kode);
            modal.find('#edit_br_tgl_terima').val(br_tgl_terima);
            modal.find('#edit_br_status').val(br_status);

            // Update action URL form untuk update data
            var actionUrl = '{{ route('pbarang.update', ':br_kode') }}';
            actionUrl = actionUrl.replace(':br_kode', br_kode);
            modal.find('#editForm').attr('action', actionUrl);
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
