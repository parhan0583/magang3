<?php
namespace App\Http\Controllers;

use App\Models\HrisDatadiris;
use App\Models\HrisDatadirisDetail;
use App\Models\HrisDatadirisMasteruser;
use App\Models\HrisDatadiriTraininguser;
use App\Models\HrisKaryawan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MasterUserController extends Controller
{
    public function index()
    {
        return view('masteruser');
    }

    // Method untuk mengambil data User Email (printid dari hris_datadiris)
    public function getUserNik()
    {
        // Menambahkan filter sts_rsgn = 0, hanya angka di nik dan hanya huruf di nm_lengkap
        $datauser = HrisDatadiris::select('printid', 'nik', 'nm_lengkap')
                                  ->where('sts_rsgn', 0)
                                  ->whereRaw("nik REGEXP '^[0-9]+$'")  // Memfilter nik hanya angka
                                  ->whereRaw("nm_lengkap REGEXP '^[A-Za-z]+$'")  // Memfilter nm_lengkap hanya huruf
                                  ->orderByRaw('CAST(nik AS UNSIGNED) ASC')
                                  ->orderBy('nm_lengkap', 'asc')
                                  ->get();

        return response()->json([
            'datauser' => $datauser
        ]);
    }
            // Validasi data yang diterima dari AJAX
        public function store(Request $request)
        {
        $validated = $request->validate([
            'nik' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'role' => 'required|string|max:255',
        ]);

        try {
            $dataTrainingRole = new HrisDatadirisMasteruser();
            $dataTrainingRole->nik = $request->nik;  // Simpan NIK yang diterima
            $dataTrainingRole->name = $request->name;  // Simpan Nama User yang diterima
            $dataTrainingRole->role = $request->role;  // Simpan Role yang diterima
            $dataTrainingRole->save();

            return response()->json(['message' => 'Data berhasil disimpan!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
        }


        public function getData()
        {
        $dataTrainingRole = HrisDatadiriTraininguser::orderBy('name', 'asc')  // Mengurutkan berdasarkan NIK
        ->orderBy('role', 'asc')  // Mengurutkan berdasarkan Role
        ->get();

        return DataTables::of($dataTrainingRole)
        ->addIndexColumn() // Menambahkan kolom index
        ->make(true); // Format JSON untuk digunakan oleh DataTables
        }

    // Menampilkan data user untuk diedit
// Fungsi untuk mengedit data
public function edit($id)
{
    // Menemukan data user berdasarkan ID
    $role = HrisDatadiriTraininguser::findOrFail($id);

    // Mengembalikan data dalam format JSON
    return response()->json($role);
}

// Fungsi untuk memperbarui data
public function update(Request $request, $id)
{
    // Menemukan data user berdasarkan ID
    $role = HrisDatadiriTraininguser::findOrFail($id);

    // Validasi input yang datang
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'role' => 'required|string|max:255',
    ]);

    // Memperbarui data user
    $role->update([
        'name' => $validatedData['name'],
        'role' => $validatedData['role'],
    ]);

    // Mengembalikan respon sukses
    return response()->json(['message' => 'Data berhasil diperbarui', 'data' => $role]);
}

public function destroy($id)
{
    try {
        $role = HrisDatadiriTraininguser::findOrFail($id);  // Temukan role berdasarkan ID
        $role->delete();  // Hapus role

        return response()->json(['message' => 'Role berhasil dihapus!'], 200);
    } catch (\Exception $e) {
        return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
    }
}

}
