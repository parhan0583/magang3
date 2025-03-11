@extends('layout.master')
<link href="https://cdn.jsdelivr.net/npm/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.2/dist/css/bootstrap.min.css" rel="stylesheet">

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Pengelompokan User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">TrainingMaster</li>
                    </ol>
                </div><!-- /.col -->
            </div><!-- /.row -->
        </div><!-- /.container-fluid -->
    </div>

    <!-- Pesan Status -->
    @if (session('status'))
        <div class="alert alert-success">
            {{ session('status') }}
        </div>
    @endif

    <!-- Main content -->
    <div class="container py-4">
        <div class="card">
            <div class="card-header">
                <h3>Daftar Jenis Training</h3>
                <button class="btn btn-primary" id="registerRoleLink">Tambah Jenis Training</button>
            </div>
            <div class="card-body">
                <table id="jenisTrainingTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Jenis Training</th>
                            <th>Aksi</th> <!-- Kolom untuk tombol Update dan Delete -->
                        </tr>
                    </thead>
                    <tbody>
                        <!-- Data akan dimuat dengan AJAX -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

<!-- Modal Register Jenis Training -->
<div class="modal fade" id="modalRegisterRole" tabindex="-1" aria-labelledby="modalRegisterRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegisterRoleLabel">Tambah Jenis Training</h5>
            </div>
            <div class="modal-body">
                <input type="text" id="PostRegisterRole" class="form-control" placeholder="Masukkan Nama Jenis Training">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelBTN" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveRoleBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>


@section('js')
<!-- Muat jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>


<!-- DataTables CSS -->
<link rel="stylesheet" href="https://cdn.datatables.net/1.11.4/css/jquery.dataTables.min.css">

<!-- DataTables JS (load setelah jQuery) -->
<script src="https://cdn.datatables.net/1.11.4/js/jquery.dataTables.min.js"></script>
<!-- Styling untuk DataTables -->
<script>
    var modal = new bootstrap.Modal(document.getElementById('modalRegisterRole'));
    $(document).ready(function() {
        // Event listener untuk membuka modal
        $('#registerRoleLink').on('click', function() {
            modal.show();  // Memunculkan modal
        });

        // Menangani klik pada tombol Simpan Jenis Training
        $('#saveRoleBtn').on('click', function() {
        var namajenis = $('#PostRegisterRole').val();  // Ambil nilai input dari form

        // Cek apakah input tidak kosong
        if (namajenis !== '') {
            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: '/storeTraining',  // Ganti dengan route untuk menyimpan data
                method: 'POST',
                data: {
                    namajenis: namajenis,
                    _token: '{{ csrf_token() }}'  // Token CSRF untuk keamanan
                },
                success: function(response) {
                    alert('Jenis Training berhasil ditambahkan!');
                    modal.hide();

                    // Pastikan DataTable diinisialisasi dengan benar di bagian lain kode
                    // Menyegarkan tabel setelah data disimpan
                    $('#jenisTrainingTable').DataTable().ajax.reload();
                },
                error: function(error) {
                    alert('Terjadi kesalahan saat menyimpan data!');
                    console.log(error.responseText);  // Debugging: log error response
                }
            });
    } else {
        alert('Nama Jenis Training tidak boleh kosong!');
    }
});


        // Inisialisasi DataTable dan ambil data dengan AJAX
        $('#jenisTrainingTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('getDataTraining') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'namajenis', name: 'namajenis' },
                {
                    data: null,  // Kolom untuk tombol Update dan Delete
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-warning btn-sm" onclick="editTraining(${row.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteTraining(${row.id})">Delete</button>
                        `;
                    }
                }
            ],
            language: {
                search: "Cari:",
                paginate: {
                    next: "",
                    previous: ""
                },
                lengthMenu: "Tampilkan _MENU_ entri",
                info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",
            },
            pagingType: 'full_numbers',
        });

        // Fungsi untuk mengedit role
        window.editTraining = function(id) {
            // Ambil data role berdasarkan ID
            $.ajax({
                url: '/editTraining/' + id,  // Ganti dengan route untuk mendapatkan data peran yang akan diedit
                method: 'GET',
                success: function(response) {
                    // Menampilkan data dalam modal untuk mengedit
                    $('#PostRegisterRole').val(response.namajenis);  // Mengisi input dengan nama peran
                    $('#saveRoleBtn').text('Update Jenis Training');  // Ubah teks tombol menjadi Update
                    $('#saveRoleBtn').off('click').on('click', function() {
                        updateTraining(id);  // Panggil fungsi update ketika tombol Update ditekan
                    });
                    modal.show();
                }
            });
        };

        // Fungsi untuk mengupdate role
        function updateTraining(id) {
            var namajenis = $('#PostRegisterRole').val();  // Ambil nilai dari input 'PostRegisterRole'

            if (namajenis !== '') {
                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '/updateTraining/' + id,  // Ganti dengan route untuk mengupdate data
                    method: 'POST',
                    data: {
                        namajenis: namajenis,
                        _token: '{{ csrf_token() }}'  // Token CSRF untuk keamanan
                    },
                    success: function(response) {
                        alert('Jenis Training berhasil diupdate!');
                        modal.hide();
                        $('#jenisTrainingTable').DataTable().ajax.reload();
                    },
                    error: function(error) {
                        alert('Terjadi kesalahan saat mengupdate data!');
                    }
                });
            } else {
                alert('Nama Jenis Training tidak boleh kosong!');
            }
        }

        // Fungsi untuk menghapus role
        window.deleteTraining = function(id) {
            if (confirm("Apakah Anda yakin ingin menghapus jenis training ini?")) {
                $.ajax({
                    url: '/deleteTraining/' + id,  // Ganti dengan route untuk menghapus data
                    method: 'DELETE',
                    data: {
                        _token: '{{ csrf_token() }}'
                    },
                    success: function(response) {
                        alert("Jenis Training berhasil dihapus!");
                        $('#jenisTrainingTable').DataTable().ajax.reload();  // Menyegarkan tabel setelah data dihapus
                    },
                    error: function(error) {
                        alert('Terjadi kesalahan saat menghapus data!');
                    }
                });
            }
        };
        document.getElementById('cancelBTN').addEventListener('click', function() {
        console.log('string');
        modal.hide();  // Menutup modal saat tombol Cancel diklik
        });
    });
</script>

@endsection
