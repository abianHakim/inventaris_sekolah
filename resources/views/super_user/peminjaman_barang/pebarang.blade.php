@extends('template.SU')

@section('content')
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Pengembalian Barang</h1>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <div class="card shadow">
        <div class="card-header">
            <h5 class="m-0 font-weight-bold text-primary">Form Pengembalian Barang</h5>
        </div>
        <div class="card-body">
            <form action="{{ route('pengembalian.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="pb_id">Pilih Siswa</label>
                    <select class="form-control" id="pb_id" name="pb_id" required>
                        <option value="">Pilih Siswa</option>
                        @foreach ($peminjaman as $p)
                            <option value="{{ $p->pb_id }}" data-barang='@json($p->detailPeminjaman)'>
                                {{ $p->siswa->nama_siswa }} - {{ $p->siswa->nisn }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label>Barang yang Dipinjam</label>
                    <ul id="barang-list" class="list-group"></ul>
                </div>

                <button type="submit" class="btn btn-success">Kembalikan Barang</button>
            </form>
        </div>
    </div>

    <script>
        document.getElementById('pb_id').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let barangList = document.getElementById('barang-list');
            barangList.innerHTML = '';

            if (selectedOption.value) {
                let barang = JSON.parse(selectedOption.getAttribute('data-barang'));
                barang.forEach(function(item) {
                    let li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.textContent = item.barang.br_nama;
                    barangList.appendChild(li);
                });
            }
        });
    </script>
@endsection

@push('script')
    <script>
        document.getElementById('pb_id').addEventListener('change', function() {
            let selectedOption = this.options[this.selectedIndex];
            let barangList = document.getElementById('barang-list');
            barangList.innerHTML = '';

            if (selectedOption.value) {
                let barang = JSON.parse(selectedOption.getAttribute('data-barang'));
                barang.forEach(function(item) {
                    let li = document.createElement('li');
                    li.classList.add('list-group-item');
                    li.textContent = item.barang.br_nama;
                    barangList.appendChild(li);
                });
            }
        });
    </script>
@endpush
