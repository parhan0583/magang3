<?php

namespace App\Http\Controllers;

use App\Models\peran;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class Getregistrasirole extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('GetRegistrasiRole');
    }

    public function getData()
    {
        $dataTrainingRole = peran::orderBy('namaperan', 'asc')->get();
        return DataTables::of($dataTrainingRole)
            ->addIndexColumn() // Menambahkan kolom index
            ->make(true); // Format JSON untuk digunakan oleh DataTables
    }

    public function getSelectData()
    {
        $dataTrainingRole = peran::orderBy('namaperan', 'asc')->get();

        // Mengembalikan hanya data yang diperlukan untuk dropdown
        return response()->json([
            'pelatihan' => $dataTrainingRole
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'namaperan' => 'required|string|max:255',
        ]);

        try {
            $dataTrainingRole = new peran();
            $dataTrainingRole->namaperan = $request->namaperan;
            $dataTrainingRole->save();

            return response()->json(['message' => 'Data berhasil disimpan!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Menampilkan data peran untuk diedit
        $role = peran::findOrFail($id);
        return response()->json($role);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validasi input dari pengguna
        $validated = $request->validate([
            'namaperan' => 'required|string|max:255',
        ]);

        try {
            $role = peran::findOrFail($id);  // Temukan role berdasarkan ID
            $role->namaperan = $request->namaperan;  // Update nama peran
            $role->save();  // Simpan perubahan

            return response()->json(['message' => 'Data berhasil diupdate!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengupdate data!'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $role = peran::findOrFail($id);  // Temukan role berdasarkan ID
            $role->delete();  // Hapus role

            return response()->json(['message' => 'Role berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
}
