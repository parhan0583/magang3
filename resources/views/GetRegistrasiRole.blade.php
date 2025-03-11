@extends('layout.master')

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
                        <li class="breadcrumb-item active">RegisterRole</li>
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
                <h3>Daftar Role Pengguna</h3>
                <button class="btn btn-primary" id="registerRoleLink">Tambah Role</button>
            </div>
            <div class="card-body">
                <table id="roleTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Peran</th>
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

<!-- Modal Register Role -->
<div class="modal fade" id="modalRegisterRole" tabindex="-1" aria-labelledby="modalRegisterRoleLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="modalRegisterRoleLabel">Tambah Role Pengguna</h5>
            </div>
            <div class="modal-body">
                <form id="registerRoleForm">
                    <div class="form-group">
                        <label for="PostRegisterRole">Nama Peran (Register Role)</label>
                        <input class="form-control" id="PostRegisterRole" name="namaperan" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="cancelButton" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary simpan-role" id="saveRoleBtn">Simpan</button>
            </div>
        </div>
    </div>
</div>

@section('js')
<!-- Muat jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- Muat DataTables -->
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

        // Menangani klik pada tombol Simpan Peran
        $('#saveRoleBtn').on('click', function() {
            var namaperan = $('#PostRegisterRole').val();  // Ambil nilai input dari form

            // Cek apakah input tidak kosong
            if (namaperan !== '') {
                // Kirim data ke server menggunakan AJAX
                $.ajax({
                    url: '/storeRole',  // Ganti dengan route untuk menyimpan data
                    method: 'POST',
                    data: {
                        namaperan: namaperan,
                        _token: '{{ csrf_token() }}'  // Token CSRF untuk keamanan
                    },
                    success: function(response) {
                        alert('Role berhasil ditambahkan!');
                        modal.hide();  // Menutup modal setelah berhasil
                        $('#roleTable').DataTable().ajax.reload();  // Menyegarkan tabel setelah data disimpan
                    },
                    error: function(error) {
                        alert('Terjadi kesalahan saat menyimpan data!');
                    }
                });
            } else {
                alert('Nama Peran tidak boleh kosong!');
            }
        });

        // Inisialisasi DataTable dan ambil data dengan AJAX
        $('#roleTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('getDataRole') }}",
            columns: [
                { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },
                { data: 'namaperan', name: 'namaperan' },
                {
                    data: null,  // Kolom untuk tombol Update dan Delete
                    render: function(data, type, row) {
                        return `
                            <button class="btn btn-warning btn-sm" onclick="editRole(${row.id})">Edit</button>
                            <button class="btn btn-danger btn-sm" onclick="deleteRole(${row.id})">Delete</button>
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
    window.editRole = function(id) {
        // Ambil data role berdasarkan ID
        $.ajax({
            url: '/editRole/' + id,  // Ganti dengan route untuk mendapatkan data peran yang akan diedit
            method: 'GET',
            success: function(response) {
                // Menampilkan data dalam modal untuk mengedit
                $('#PostRegisterRole').val(response.namaperan);  // Mengisi input dengan nama peran
                $('#saveRoleBtn');  // Ubah teks tombol menjadi Update
                $('#saveRoleBtn').off('click').on('click', function() {
                    updateRole(id);  // Panggil fungsi update ketika tombol Update ditekan
                });
                modal.show();
            }
        });
    };

    // Fungsi untuk mengupdate role
    function updateRole(id) {
        var namaperan = $('#PostRegisterRole').val();  // Ambil nilai dari input 'PostRegisterRole'

        if (namaperan !== '') {
            // Kirim data ke server menggunakan AJAX
            $.ajax({
                url: '/updateRole/' + id,  // Ganti dengan route untuk mengupdate data
                method: 'POST',
                data: {
                    namaperan: namaperan,
                    _token: '{{ csrf_token() }}'  // Token CSRF untuk keamanan
                },
                success: function(response) {
                    alert('Role berhasil diupdate!');
                    console.log('string');
                    modal.hide();
                    $('#roleTable').DataTable().ajax.reload();
                },
                error: function(error) {
                    alert('Terjadi kesalahan saat mengupdate data!');
                }
            });
        } else {
            alert('Nama Peran tidak boleh kosong!');
        }
    }

    // Fungsi untuk menghapus role
    window.deleteRole = function(id) {
        if (confirm("Apakah Anda yakin ingin menghapus role ini?")) {
            $.ajax({
                url: '/deleteRole/' + id,  // Ganti dengan route untuk menghapus data
                method: 'DELETE',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    alert("Role berhasil dihapus!");
                    $('#roleTable').DataTable().ajax.reload();  // Menyegarkan tabel setelah data dihapus
                },
                error: function(error) {
                    alert('Terjadi kesalahan saat menghapus data!');
                }
            });
        }
    };
    document.getElementById('cancelButton').addEventListener('click', function() {
    console.log('string');
    modal.hide();  // Menutup modal saat tombol Cancel diklik
        });
    });
</script>

@endsection
