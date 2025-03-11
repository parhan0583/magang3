@extends('layout.master')

@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Training User</h1>
                </div><!-- /.col -->
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">TrainingUser</li>
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
                <h3>Daftar Pengguna</h3>
                <button class="btn btn-primary" id="trainingUserLink">Tambah TrainingUSer</button>
            </div>
            <div class="card-body">
                <table id="roleTable" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Role</th>
                            <th>Nama Jenis</th>
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

{{-- Modal masteruser --}}
<div class="modal" tabindex="-1" id="myModalId">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah / Edit User</h5>
            </div>
            <div class="modal-body">
                <form id="masterUserForm" id="formMasteruser">
                    <div class="form-group">
                        <label for="GetRoleUser1" style="margin-top: 10px;">Role</label>
                        <select class="form-control" id="GetRoleUser1" name="role"></select>
                    </div>
                    <div class="form-group">
                        <label for="GetNameUser" style="margin-top: 10px;">jenis Training</label>
                        <select class="form-control" id="GetNameUser" name="name" style="margin-bottom: 10px;"></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" id="CancelBtn" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" id="saveUserBtn">Simpan</button>
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
<script>
    var myModal = new bootstrap.Modal(document.getElementById('myModalId'), {
    keyboard: false
});
    document.addEventListener('DOMContentLoaded', function() {

    // Event listener untuk membuka modal
    $('body').on('click', '#trainingUserLink', function(e) {
        e.preventDefault();
        myModal.show();

        // Memanggil data untuk dropdown NIK
        $.ajax({
            url: '/getNIK',  // Memanggil rute yang mengembalikan data user
            method: 'GET',
            success: function(data) {
                let dropdownNameUser = $('#GetNameUser');  // Menampilkan nama user
                dropdownNameUser.empty();  // Menghapus opsi yang ada
                dropdownNameUser.append('<option value="">Pilih Nama User</option>');  // Opsi default

                // Menambahkan opsi berdasarkan data dari server
                data.datauser.forEach(function(user) {
                    dropdownNameUser.append('<option value="' + user.printid + '">' + user.nm_lengkap + '</option>');
                });

                // Inisialisasi Select2 setelah dropdown diperbarui
                $('#GetNameUser').select2({
                    width: '100%',
                    placeholder: "Pilih",
                    allowClear: true
                }).trigger('change');  // Memicu perubahan pada Select2 setelah inisialisasi
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });

        // Memanggil data untuk dropdown Role
        $.ajax({
            url: '/jenisTraining2', // Memanggil rute yang mengembalikan data JenisTraining
            method: 'GET',
            success: function(data) {
                let dropdown = $('#GetRoleUser1');
                dropdown.empty();  // Menghapus opsi yang ada
                dropdown.append('<option value="">Pilih Jenis pelatihan</option>');  // Opsi default

                // Menambahkan opsi berdasarkan data dari server
                data.jenistraining.forEach(function(jenistraining) {
                    dropdown.append('<option value="' + jenistraining.id + '">' + jenistraining.namajenis + '</option>');
                });

                // Inisialisasi ulang Select2 setelah dropdown diperbarui
                $('#GetRoleUser1').select2().trigger('change');
            },
            error: function(xhr, status, error) {
                console.log('Error:', error);
            }
        });
    });

    // Event listener untuk tombol cancel, menutup modal dan menghapus backdrop
    document.getElementById('CancelBtn').addEventListener('click', function() {
        console.log('Modal will be closed');
        myModal.hide();
    });

    // Event listener untuk tombol simpan
    $('#saveUserBtn').on('click', function() {
    var name = $('#GetNameUser option:selected').text();  // Ambil teks Nama User dari dropdown
    var role = $('#GetRoleUser1 option:selected').text();  // Ambil nilai input Role

    // Cek apakah input tidak kosong
    console.log("Nama User: " + name);  // Log nilai Nama User
    console.log("Role: " + role);  // Log nilai Role

    // Cek apakah input tidak kosong
    if (name !== '' && role !== '') {
        // Kirim data ke server menggunakan AJAX
        $.ajax({
            url: '/storeMasterUser',  // Ganti dengan route untuk menyimpan data
            method: 'POST',
            data: {
                name: name,  // Kirim Nama User yang dipilih
                role: role,  // Kirim Role
                _token: '{{ csrf_token() }}'  // Token CSRF untuk keamanan
            },
            success: function(response) {
                alert('Role berhasil ditambahkan!');
                console.log('tutup');
                myModal.hide();  // Menutup modal setelah berhasil
                $('#roleTable').DataTable().ajax.reload();  // Menyegarkan tabel setelah data disimpan
            },
            error: function(error) {
                alert('Terjadi kesalahan saat menyimpan data!');
            }
        });
    } else {
        alert('Nama User, dan Role tidak boleh kosong!');
    }
});
        // Inisialisasi DataTable dan ambil data dengan AJAX
        $('#roleTable').DataTable({
        processing: true,  // Menampilkan indikator loading
        serverSide: true,  // Menggunakan server-side processing
        ajax: {
            url: "{{ route('getDataMasterUser') }}",  // Rute untuk mengambil data
            type: 'GET',  // Menggunakan metode GET untuk mengambil data
        },
        columns: [
            { data: 'DT_RowIndex', name: 'DT_RowIndex', orderable: false, searchable: false },  // Menampilkan Nomer Urut
            { data: 'name', name: 'name' },  // Menampilkan Nama User
            { data: 'role', name: 'role' },  // Menampilkan Role
            {
                data: null,  // Kolom untuk tombol Edit dan Delete
                render: function(data, type, row) {
                    return `
                        <button class="btn btn-warning btn-sm" onclick="editMasterU(${row.id})">Edit</button>
                        <button class="btn btn-danger btn-sm" onclick="deleteMasterU(${row.id})">Delete</button>
                    `;
                }
            }
        ],
        language: {
            search: "Cari:",  // Label untuk pencarian
            paginate: {
                next: "",  // Teks untuk tombol "Next"
                previous: ""  // Teks untuk tombol "Previous"
            },
            lengthMenu: "Tampilkan _MENU_ entri",  // Label untuk dropdown jumlah entri
            info: "Menampilkan _START_ hingga _END_ dari _TOTAL_ entri",  // Informasi jumlah entri yang ditampilkan
        },
        pagingType: 'full_numbers',  // Menampilkan navigasi halaman lengkap
        // Mengaktifkan penomoran otomatis untuk DataTable
        columnDefs: [
            { targets: 0, searchable: false, orderable: false }
        ]
    });
    // Fungsi untuk mengedit data
window.editMasterU = function(id) {
    $.ajax({
        url: '/editMasterU/' + id,  // Rute untuk mendapatkan data berdasarkan ID
        method: 'GET',
        success: function(response) {
            console.log(response);  // Log response untuk memastikan data yang diterima

            // Mengisi dropdown NIK dan Nama User berdasarkan data yang diterima
            $('#GetNameUser').val(response.name).trigger('change');  // Menggunakan data 'name'
            $('#GetRoleUser1').val(response.role).trigger('change');  // Menggunakan data 'role'

            // Ubah teks tombol menjadi Update
            $('#saveUserBtn').off('click').on('click', function() {
                updateMasterU(id);  // Panggil fungsi update ketika tombol Update ditekan
            });

            myModal.show();  // Menampilkan modal untuk Edit

        },
        error: function(xhr, status, error) {
            console.log(error);  // Log error jika ada masalah
        }
    });
};
function updateMasterU(id) {
    var name = $('#GetNameUser').val();  // Ambil nilai Nama User dari input
    var role = $('#GetRoleUser1').val();  // Ambil nilai Role dari input

    // Cek apakah input tidak kosong
    if (name !== '' && role !== '') {
        console.log("Data yang dikirim: ", nik, name, role);  // Debugging untuk memastikan data

        $.ajax({
            url: '/updateMasterU/' + id,  // Ganti dengan route untuk mengupdate data
            method: 'POST',
            data: {
                name: name,  // Kirim Nama User yang dipilih
                role: role,  // Kirim Role yang dipilih
                _token: '{{ csrf_token() }}'  // Token CSRF untuk keamanan
            },
            success: function(response) {
                alert('Role berhasil diupdate!');
                myModal.hide();  // Menutup modal setelah berhasil
                $('#roleTable').DataTable().ajax.reload();  // Menyegarkan tabel setelah data diupdate
            },
            error: function(error) {
                alert('Terjadi kesalahan saat mengupdate data!');
            }
        });
    } else {
        alert('NIK, Nama User, dan Role tidak boleh kosong!');
    }
}



// Fungsi untuk menghapus role
window.deleteMasterU = function(id) {
    if (confirm("Apakah Anda yakin ingin menghapus role ini?")) {
        $.ajax({
            url: '/deleteMasterU/' + id,  // Ganti dengan route untuk menghapus data
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
}
    document.getElementById('myModalId').addEventListener('click', function() {
    console.log('string');
    modal.hide();  // Menutup modal saat tombol Cancel diklik
        });
    });


</script>
@endsection
