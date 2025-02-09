@extends('template.SU')

@push('style')
    <style>
        .selected-items-list li {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 8px 12px;
            background: #f8f9fc;
            border-radius: 8px;
            margin-bottom: 6px;
            font-weight: bold;
        }

        .table th,
        .table td {
            vertical-align: middle;
            text-align: center;
        }

        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        .btn-toggle {
            width: 35px;
            height: 35px;
            border-radius: 50%;
            font-size: 18px;
            font-weight: bold;
        }

        .btn-selected {
            background-color: red !important;
            color: white;
        }

        .btn-not-selected {
            background-color: green !important;
            color: white;
        }

        .item-code {
            font-weight: bold;
            background: #007bff;
            color: white;
            padding: 5px 10px;
            border-radius: 5px;
            min-width: 80px;
            text-align: center;
        }

        .item-name {
            flex-grow: 1;
        }
    </style>
@endpush

@section('content')
    <div class="container">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800" style="color: black">Transaksi Peminjaman</h1>
        </div>

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @elseif(session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <div class="form-container">
            <form action="{{ route('peminjaman.store') }}" method="POST">
                @csrf
                <!-- Pilih Siswa & Penanggung Jawab -->
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="siswa">Pilih Siswa:</label>
                            <select name="siswa_id" id="select-siswa" class="form-control select2" required>
                                <option value="">Pilih Siswa</option>
                                @foreach ($siswa as $s)
                                    <option value="{{ $s->siswa_id }}">{{ $s->nama_siswa }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="penanggung_jawab">Penanggung Jawab</label>
                            <input type="text" class="form-control" value="{{ Auth::user()->user_name }}" disabled>
                            <input type="hidden" name="user_id" value="{{ Auth::id() }}">
                        </div>
                    </div>
                </div>

                <!-- Pilih Barang -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Pilih Barang</h6>
                    </div>
                    <div class="card-body">
                        <table class="table table-bordered" id="dataTable">
                            <thead>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Status</th>
                                    <th>Pilih</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($barang as $b)
                                    <tr>
                                        <td>{{ $b->br_nama }}</td>
                                        <td>
                                            <span class="badge badge-{{ $b->br_status == 1 ? 'success' : 'danger' }}">
                                                {{ $b->getStatusLabelAttribute() }}
                                            </span>
                                        </td>
                                        <td>
                                            <button type="button" class="btn btn-sm btn-not-selected btn-toggle"
                                                data-br_kode="{{ $b->br_kode }}" data-br_nama="{{ $b->br_nama }}">
                                                +
                                            </button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Barang yang Dipilih -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-warning">Barang yang Dipilih</h6>
                    </div>
                    <div class="card-body">
                        <ul id="selected-items" class="list-group selected-items-list"></ul>
                    </div>
                </div>

                <!-- Pilih Tanggal Kembali -->
                <div class="form-group">
                    <label for="tanggal_kembali">Tanggal Kembali:</label>
                    <input type="date" name="tanggal_kembali" class="form-control" required>
                </div>

                <!-- Tempat Input Barang yang Dipilih -->
                <div id="barang-input-container"></div>

                <button type="submit" class="btn btn-success btn-block">Pinjam</button>
            </form>
        </div>
    </div>
@endsection

@push('script')
    <script>
        $(document).ready(function() {
            $('#select-siswa').select2({
                placeholder: " Pilih Siswa ",
                allowClear: true,
                width: '100%',
                dropdownParent: $('#select-siswa')
                    .parent()
            });
        });
    </script>

    <script>
        let selectedBarang = [];

        document.addEventListener('click', function(event) {
            if (event.target.classList.contains('btn-toggle')) {
                let brKode = event.target.getAttribute('data-br_kode');
                let brNama = event.target.getAttribute('data-br_nama');

                if (!selectedBarang.some(item => item.brKode === brKode)) {
                    selectedBarang.push({
                        brKode,
                        brNama
                    });
                    event.target.textContent = "-";
                    event.target.classList.remove('btn-not-selected');
                    event.target.classList.add('btn-selected');
                } else {
                    selectedBarang = selectedBarang.filter(item => item.brKode !== brKode);
                    event.target.textContent = "+";
                    event.target.classList.remove('btn-selected');
                    event.target.classList.add('btn-not-selected');
                }

                updateSelectedItems();
            }
        });

        function updateSelectedItems() {
            let list = document.getElementById('selected-items');
            list.innerHTML = "";

            let inputContainer = document.getElementById('barang-input-container');
            inputContainer.innerHTML = "";

            selectedBarang.forEach(({
                brKode,
                brNama
            }) => {
                let listItem = document.createElement('li');
                listItem.innerHTML = `<div class="item-info">
                    <span class="item-code">${brKode}</span>
                    <span class="item-name">${brNama}</span>
                </div>`;

                let removeBtn = document.createElement('button');
                removeBtn.textContent = "Hapus";
                removeBtn.className = "btn btn-sm btn-danger ml-2";
                removeBtn.onclick = function() {
                    selectedBarang = selectedBarang.filter(item => item.brKode !== brKode);

                    let btn = document.querySelector(`.btn-toggle[data-br_kode='${brKode}']`);
                    if (btn) {
                        btn.textContent = "+";
                        btn.classList.remove('btn-selected');
                        btn.classList.add('btn-not-selected');
                    }

                    updateSelectedItems();
                };

                listItem.appendChild(removeBtn);
                list.appendChild(listItem);

                let hiddenInput = document.createElement('input');
                hiddenInput.type = "hidden";
                hiddenInput.name = "barang[]";
                hiddenInput.value = brKode;
                inputContainer.appendChild(hiddenInput);
            });
        }
    </script>
@endpush
