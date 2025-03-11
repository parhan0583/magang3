<?php

namespace App\Http\Controllers;

use App\Models\RegisterRole;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Yajra\DataTables\Facades\DataTables;

class AuthController extends Controller
{
    public function login(Request $request){
         $request->validate([
             'email' => 'required|email|max:50',
             'password' => 'required|max:50',
         ]);
         if (Auth::attempt($request->only('email','password'),$request->remember)) {

             //authentikasi hanya untuk customer yang masuk ke halaman /customer
             if(Auth::user()->role == 'customer') return Redirect()('/customer');

            return redirect('/dashboard');
         }
         return back()->with('failed','Email atau Password salah');
    }
    public function logout(){
        Auth::logout(Auth::user());
        return redirect('/login');
    }

    // public function getUserEmail()
    // {
    // $datauser = User::orderBy('email', 'asc')->get(); // Ambil semua data user
    // return response()->json([
    //     'datauser' => $datauser,
    // ]);
    // }
    // public function getUserName()
    // {
    // $datauser = User::orderBy('name', 'asc')->get(); // Ambil semua data user
    // return response()->json([
    //     'datauser' => $datauser,
    // ]);
    // }
    // public function getUserRole()
    // {
    // $datauser = User::orderBy('role', 'asc')->get(); // Ambil semua data user
    // return response()->json([
    //     'datauser' => $datauser,
    // ]);
    // }
    public function BuatAkun(){
        return redirect('/login');
    }
}
