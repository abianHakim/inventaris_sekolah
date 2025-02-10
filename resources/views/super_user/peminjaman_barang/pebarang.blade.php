@extends('template.SU')

@push('script')
    <link href="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.1.0/css/buttons.dataTables.min.css" rel="stylesheet">
@endpush

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengembalian Barang</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header bg-primary text-white">
            <h5 class="m-0 font-weight-bold">Daftar Peminjaman</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered" id="dataTable">
                    <thead class="thead-dark">
                        <tr>
                            <th>Nama Siswa</th>
                            <th>NISN</th>
                            <th style="width: 20%">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($peminjaman as $p)
                            <tr class="siswa-row" data-pb-id="{{ $p->pb_id }}"
                                data-barang='@json($p->detailPeminjaman)'>
                                <td>
                                    <i class="fas fa-user text-primary"></i>
                                    <strong>{{ $p->siswa->nama_siswa }}</strong>
                                </td>
                                <td>{{ $p->siswa->nisn }}</td>
                                <td class="text-center">
                                    <button class="btn btn-sm btn-success btn-pengembalian"
                                        data-pb-id="{{ $p->pb_id }}">
                                        <i class="fas fa-undo"></i> Kembalikan
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="{{ asset('assets/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <!-- Load jQuery & DataTables -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>

    <script>
        $(document).ready(function() {
            let table = $('#dataTable').DataTable({
                "destroy": true, // Agar bisa di-reload tanpa error
                "paging": true,
                "ordering": true,
                "info": true,
                "lengthChange": false,
                "language": {
                    "search": "Cari:",
                    "paginate": {
                        "next": "→",
                        "previous": "←"
                    },
                    "zeroRecords": "Tidak ada data ditemukan"
                }
            });

            // Klik Baris Tabel untuk Menampilkan Barang yang Dipinjam
            $('#dataTable tbody').on('click', 'tr.siswa-row', function() {
                let row = table.row(this);
                let pbId = $(this).data('pb-id');
                let barangList = JSON.parse($(this).attr('data-barang'));

                if (row.child.isShown()) {
                    row.child.hide();
                } else {
                    let detailBarang = '<div class="p-3 border rounded bg-light shadow-sm">';
                    detailBarang +=
                        '<h6 class="text-dark"><i class="fas fa-box"></i> Barang yang Dipinjam:</h6>';
                    detailBarang += '<ul class="list-group">';

                    if (barangList.length === 0) {
                        detailBarang +=
                            '<li class="list-group-item text-danger">Tidak ada barang dipinjam</li>';
                    } else {
                        barangList.forEach(function(item) {
                            detailBarang += `<li class="list-group-item">
                                <i class="fas fa-box text-secondary"></i> ${item.barang.br_nama}
                            </li>`;
                        });
                    }

                    detailBarang += '</ul></div>';

                    row.child(detailBarang).show();
                }
            });

            // Tombol Pengembalian Barang dengan SweetAlert
            $('.btn-pengembalian').on('click', function(event) {
                event.stopPropagation(); // Mencegah pemicu dropdown saat tombol ditekan

                let pbId = $(this).data('pb-id');

                Swal.fire({
                    title: 'Konfirmasi Pengembalian',
                    text: "Apakah Anda yakin ingin mengembalikan barang ini?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#28a745',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Ya, Kembalikan!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.method = 'POST';
                        form.action = "{{ route('pengembalian.store') }}";
                        form.innerHTML = `@csrf<input type="hidden" name="pb_id" value="${pbId}">`;
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
