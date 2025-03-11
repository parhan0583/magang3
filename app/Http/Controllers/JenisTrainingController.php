<?php

namespace App\Http\Controllers;

use App\Models\jenisTraining;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class JenisTrainingController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('TrainingMaster');
    }
    public function getData()
    {
        $dataTrainingRole = jenisTraining::orderBy('namajenis', 'asc')->get();
        return DataTables::of($dataTrainingRole)
            ->addIndexColumn() // Menambahkan kolom index
            ->make(true); // Format JSON untuk digunakan oleh DataTables
    }
    public function edit($id)
    {
        // Menampilkan data peran untuk diedit
        $namaJenis = jenisTraining::findOrFail($id);
        return response()->json($namaJenis);
    }
    public function update(Request $request, $id)
    {
        // Validasi input dari pengguna
        $validated = $request->validate([
            'namajenis' => 'required|string|max:255',
        ]);

        try {
            $role = jenisTraining::findOrFail($id);  // Temukan role berdasarkan ID
            $role->namajenis = $request->namajenis;  // Update nama peran
            $role->save();  // Simpan perubahan

            return response()->json(['message' => 'Data berhasil diupdate!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat mengupdate data!'], 500);
        }
    }
    public function destroy($id)
    {
        try {
            $role = jenisTraining::findOrFail($id);  // Temukan role berdasarkan ID
            $role->delete();  // Hapus role

            return response()->json(['message' => 'Role berhasil dihapus!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menghapus data!'], 500);
        }
    }
    public function pushData()
    {
        $dataJenisTraining = jenisTraining::orderBy('namajenis','asc')->get(); // Ambil semua data role
         return response()->json(['jenistraining' => $dataJenisTraining]);
    }
    public function getDataJenisTraining()
    {
        $dataJenisTraining = JenisTraining::orderBy('namajenis', 'asc')->get(); // Retrieve the data

        return response()->json([
            'data' => $dataJenisTraining
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store2(Request $request)
    {
        $validated = $request->validate([
            'namajenis' => 'required|string|max:255',
        ]);

        try {
            $dataTrainingRole = new jenisTraining();
            $dataTrainingRole->namajenis = $request->namajenis;
            $dataTrainingRole->save();

            return response()->json(['message' => 'Data berhasil disimpan!'], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Terjadi kesalahan saat menyimpan data!'], 500);
        }
    }
    public function store(Request $request)
    {

        $dataJenisTraining = [
            'namajenis' => $request->namaJenis, // Menyimpan ke kolom 'namaperan'
        ];
        jenisTraining::create($dataJenisTraining);

        return response()->json(['message' => 'Data berhasil disimpan!'], 200);
        }

    /**
     * Display the specified resource.
     */
    public function show(jenisTraining $jenisTraining)
    {
        //
    }


}
