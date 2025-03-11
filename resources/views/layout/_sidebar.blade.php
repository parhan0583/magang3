<head>
    <!-- Link ke file CSS Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />

    <!-- Menambahkan custom CSS -->
    <style>
        .select2-container {
            width: 100% !important;
            z-index: 9999 !important;
        }

    </style>
</head>
{{-- jquery css ajax select2--}}
<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="{{asset('adminlte/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{auth()->user()->name}}</a>
        </div>
      </div>

      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <li class="nav-item">
            <a href="/dashboard" class="nav-link {{(request()->is('dashboard')) ? 'active' : ''}}">
              <i class="nav-icon fas fa-tachometer-alt"></i>
              <p>Dashboard</p>
            </a>
          </li>
          @if (auth()->user()->role == 'admin')
          <li class="nav-item">
            <a href="/buatakun" class="nav-link {{(request()->is('buatakun')) ? 'active' : ''}}">
              <i class="nav-icon fas fa-user"></i>
              <p>Buat Akun</p>
            </a>
          </li>
          @endif


          @if (auth()->user()->role == 'admin')
          <li class="nav-item">
              <a href="/GetRegistrasiRole" class="nav-link {{(request()->is('GetRegistrasiRole')) ? 'active' : ''}}" >
                <i class="nav-icon fas bi bi-key"></i>
                <p>
                    RegisterRole
                </p>
            </a>
          </li>
          @endif

          @if (auth()->user()->role == 'admin')
        <li class="nav-item">
            <a href="/masteruser" class="nav-link {{(request()->is('masteruser')) ? 'active' : ''}}">
                <i class="nav-icon fas bi bi-person"></i>
                <p>
                    Master User
                </p>
            </a>
        </li>
        @endif


        <li class="nav-item">
            <a href="/TrainingMaster"  class="nav-link {{(request()->is('TrainingMaster')) ? 'active' : ''}}">
                <i class="nav-icon fas fas fa-book"></i>
                <p>
                    Training Master
                </p>
            </a>
        </li>

        @if (auth()->user()->role == 'admin')
        <li class="nav-item">
            <a href="/TrainigUser"  class="nav-link {{(request()->is('TrainigUser')) ? 'active' : ''}}">
                <i class="nav-icon fas fa-chalkboard-teacher"></i>
                <p>Training User</p>
            </a>
        </li>
        @endif

        <li class="nav-item">
          <a href="/logout" class="nav-link">
            <i class="nav-icon fas fa-power-off"></i>
            <p>Logout</p>
          </a>
        </li>
    </ul>
      </nav>
    </div>
</aside>

{{-- //modaltraininguser --}}
<div class="modal" tabindex="-1" id="trainingmodaluser">
    <div class="modal-dialog">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title">Modal title</h5>
        </div>
        <div class="modal-body">
            <form>
                <div class="form-group">
                    <label for="TabelRoleUser">Role User</label>
                    <select class="form-control" id="GetRoleUser" name="role" style="margin-bottom: 10px;"></select>
                    <label for="TabelRoleUser" style="margin-top: 10px;" style="margin-bottom: 10px;">Jenis Pelatihan</label>
                    <select class="form-control" id="GetJenisPelatihan" name="jenispelatihan" style="margin-top: 10px;"></select>
                </div>
            </form>
        </div>
        <div class="modal-footer">
            <button type="button" class="btn btn-secondary" id="cancelbtn">Cancel</button>
          <button type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>
  {{-- //modaltrainingmaster --}}
  <div class="modal" tabindex="-1" id="trainingmodalmaster">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title">Modal title</h5>
          </div>
          <div class="modal-body">
            <form >
                <div class="form-group">
                    <label for="TabelRegisterRole">Masukan jenis training</label>
                    <input class="form-control" id="PostRegisterTrain" name="Prt">
                    </input>
                </div>
            </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="button" class="btn btn-primary simpan-jenistraining">Save changes</button>
          </div>
        </div>
    </div>
</div>



<!-- JavaScript -->
<!-- 1. Muat jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.js" integrity="sha256-eKhayi8LEQwp4NKxN+CfCh+3qOVUtJn3QNZ0TciWLP4=" crossorigin="anonymous"></script>

<!-- 2. Muat Select2 -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script>
<!-- 2. Muat Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>

<script>
// document.addEventListener('DOMContentLoaded', function() {
//     var myModal = new bootstrap.Modal(document.getElementById('trainingmodaluser'));
//     // Event listener untuk membuka modal
//     $('body').on('click', '#TrainingUserLink', function(e) {
//         e.preventDefault();
//         myModal.show();

//         // Ambil data role user ketika modal dibuka
//         $.ajax({
//             url: '/getSelectData',  // Memanggil rute yang mengembalikan data role
//             method: 'GET',
//             success: function(data) {
//                 let dropdownRoleUser = $('#GetRoleUser');
//                 dropdownRoleUser.empty();  // Menghapus opsi yang ada
//                 dropdownRoleUser.append('<option value="">Pilih Role User</option>');  // Opsi default

//                 // Menambahkan opsi berdasarkan data dari server
//                 data.pelatihan.forEach(function(pelatihan) {
//                     dropdownRoleUser.append('<option value="' + pelatihan.id + '">' + pelatihan.namaperan + '</option>');
//                 });

//                 // Inisialisasi ulang Select2 setelah dropdown diperbarui
//                 $('#GetRoleUser').select2();
//             },
//             error: function(xhr, status, error) {
//                 console.log('Error:', error);
//             }
//         });

//         $.ajax({
//             url: '/jenisTraining2', // Memanggil rute yang mengembalikan data JenisTraining
//             method: 'GET',
//             success: function(data) {
//                 let dropdown = $('#GetJenisPelatihan');
//                 dropdown.empty();  // Menghapus opsi yang ada
//                 dropdown.append('<option value="">Pilih Jenis pelatihan</option>');  // Opsi default

//                 // Menambahkan opsi berdasarkan data dari server
//                 data.jenistraining.forEach(function(jenistraining) {
//                     dropdown.append('<option value="' + jenistraining.id + '">' + jenistraining.namajenis + '</option>');
//                 });

//                 // Inisialisasi ulang Select2 setelah dropdown diperbarui
//                 $('#GetJenisPelatihan').select2().trigger('change');
//             },
//             error: function(xhr, status, error) {
//                 console.log('Error:', error);
//             }
//         });
//     });

//     // Event listener untuk tombol simpan jenis training
//     $('.simpan-jenistraining').off('click').on('click', function() {
//         var namaJenis = $('#PostRegisterTrain').val();  // Ambil nilai dari input

//         if (namaJenis == '') {
//             alert('Jenis Training tidak boleh kosong!');
//             return;
//         }

//         // Kirim data ke server menggunakan AJAX
//         $.ajax({
//             url: '/storeJenistraining',  // URL route untuk menyimpan data
//             method: 'POST',
//             data: {
//                 namaJenis: namaJenis,  // Data yang akan dikirim
//                 _token: '{{ csrf_token() }}',  // CSRF token
//             },
//             success: function(response) {
//                 // Jika berhasil
//                 alert(response.message);  // Menampilkan pesan 'Data berhasil disimpan!'
//                 $('#trainingmodalmaster').modal('hide');  // Tutup modal
//             },
//             error: function(xhr, status, error) {
//                 // Jika gagal
//                 alert('Terjadi kesalahan. Coba lagi!');
//             }
//         });
//     });

//     // Event listener untuk tombol cancel, menutup modal dan menghapus backdrop
//     document.getElementById('cancelbtn').addEventListener('click', function() {
//         console.log('Modal will be closed');  // Log ke konsol ketika tombol Cancel diklik
//         // Menutup modal
//         myModal.hide();
//         // Menghapus backdrop jika masih ada
//         $('.modal-backdrop').remove();
//     });
// });
</script>
