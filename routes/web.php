<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\Getregistrasirole;
use App\Http\Controllers\JenisTrainingController;
use App\Http\Controllers\MasterUserController;
use App\Http\Controllers\TrainingUserController;
use Illuminate\Support\Facades\Route;


Route::get('/', function (){
    return view('welcome');
});
Route::get ('/login', fn () => view('auth.login'))->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/getUserEmail', [AuthController::class, 'getUserEmail']);
Route::get('/getUserName', [AuthController::class, 'getUserName']);
Route::get('/getUserRole', [AuthController::class, 'getUserRole']);

//masteruser
Route::get('/getUserNik', [MasterUserController::class, 'getUserNik']);
Route::get('/getUserIdnik', [MasterUserController::class, 'getUserIdnik']);
Route::get('/getUserIdkaryawan', [MasterUserController::class, 'getUserIdkaryawan']);

Route::post('/registerRole', [AuthController::class, 'registerRole'])->name('auth.registerRole');

Route::get('/logout', [AuthController::class, 'logout']);
Route::get('/registerrole', [AuthController::class, 'registerrole']);

Route::resource('jenisTraining',JenisTrainingController::class);
//mengambil dan input data nama role
Route::get('/Getregistrasirole', [Getregistrasirole::class, 'index']); // Mengambil data role
//jenistraining
Route::get('/jenisTraining2', [JenisTrainingController::class, 'pushData']);
Route::get('/TrainingMaster', [JenisTrainingController::class, 'index'])->name('training.master');
Route::get('/getDataTraining', [JenisTrainingController::class, 'getData'])->name('getDataTraining');
Route::get('/editTraining/{id}', [JenisTrainingController::class, 'edit'])->name('editTraining');
Route::post('/updateTraining/{id}', [JenisTrainingController::class, 'update'])->name('updateTraining');
Route::delete('/deleteTraining/{id}', [JenisTrainingController::class, 'destroy'])->name('deleteTraining');
Route::post('/storeTraining', [JenisTrainingController::class, 'store2']);

Route::get('/getJenisTrainingData', [JenisTrainingController::class, 'getData'])->name('get.jenistraining.data');
Route::get('/getDataJenisTraining', [JenisTrainingController::class, 'getDataJenisTraining'])->name('getDataJenisTraining');


Route::group(['middleware'=>['auth','check_role:admin']], function(){
    Route::get('/buatakun', fn ()=> view('auth.CRUDakun'));
    // route menu Pengelompokkan user(GetRegisterrole)
    Route::get('/GetRegistrasiRole', [Getregistrasirole::class, 'index'])->middleware('auth');
    Route::get('/getDataRole', [Getregistrasirole::class, 'getData'])->name('getDataRole');
    Route::get('/getSelectData', [Getregistrasirole::class, 'getSelectData'])->name('getSelectData');
    Route::delete('/deleteRole/{id}', [Getregistrasirole::class, 'destroy'])->name('deleteRole');
    Route::get('/editRole/{id}', [Getregistrasirole::class, 'edit'])->name('editRole');
    Route::post('/updateRole/{id}', [Getregistrasirole::class, 'update'])->name('updateRole');
    Route::post('/storeRole', [Getregistrasirole::class, 'store']); // Menyimpan data role
    //
    ///////////////////////////////////////////////////////////////////////////////////////////////////////////////////
    //route menu Masteruser
    Route::get('/masteruser', [MasterUserController::class, 'index'])->middleware('auth');
        //userNIK
    Route::get('/getUser/{id}', [MasterUserController::class, 'getUser']);
    Route::get('/getAllUserData', [MasterUserController::class, 'getAllUserData']);
    Route::post('/store', [MasterUserController::class, 'store']);
    Route::delete('/deleteUser/{id}', [MasterUserController::class, 'deleteUser']);
    //simpan data kedatabase
    Route::post('/storeMasterUser', [MasterUserController::class, 'store']); // Menyimpan data role
    //ambil data database
    Route::get('/getDataMasterUser', [MasterUserController::class, 'getData'])->name('getDataMasterUser');
    Route::get('/getNIK', [MasterUserController::class, 'getUserNik']);
    Route::get('/getUserIdkaryawan', [MasterUserController::class, 'getUserIdkaryawan']);
    //edit,update,delete
    Route::delete('/deleteMasterU/{id}', [MasterUserController::class, 'destroy'])->name('deleteMasterU');
    Route::get('/editMasterU/{id}', [MasterUserController::class, 'edit'])->name('editMasterU');
    Route::post('/updateMasterU/{id}', [MasterUserController::class, 'update'])->name('updateMasterU');
    ///////////////////////////////////////////////////////////////////////////////////////////////////
    //route menu training user
    Route::get('/TrainigUser', [TrainingUserController::class, 'index'])->middleware('auth');
    Route::get('/getDataTrainingUser', [TrainingUserController::class, 'getData'])->name('getDataTrainingUser');
    Route::post('/storeTrainingUser', [TrainingUserController::class, 'store']); // Menyimpan data role

    //edit,update,delete
    Route::delete('/deleteTrainingU/{id}', [TrainingUserController::class, 'destroy'])->name('deleteTrainingU');
    Route::get('/editTrainingU/{id}', [TrainingUserController::class, 'edit'])->name('editTrainingU');
    Route::post('/updateTrainingU/{id}', [TrainingUserController::class, 'update'])->name('updateTrainingU');
});

Route::group(['middleware'=>['auth','check_role:admin,staff']], function(){
    Route::get('/dashboard', [DashboardController::class, 'index'])->middleware('auth');
});
Route::group(['middleware'=>['auth','check_role:customer']], function(){
    Route::get ('/customer', fn ()=> "halaman customer");
});
