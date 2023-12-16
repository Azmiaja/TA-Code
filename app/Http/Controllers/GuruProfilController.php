<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Pegawai;
use App\Models\PPGuru;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Yajra\DataTables\Facades\DataTables;

class GuruProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $guru = Pegawai::orderBy('idPegawai', 'desc')->where('jenisPegawai', 'Guru')->get();
        return view('mcompany.profile_guru', [
            'title' => 'Company Profil',
            'title2' => 'Profil Guru',
            'guru' => $guru,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'jabatan' => 'required',
                'gambarPP' => 'file|mimes:jpeg,png,jpg,svg',
                'idPegawai' => 'required'
            ]);

            // Logging for debugging
            Log::info('Received data:', $request->all());
            Log::info('Validated data:', $validatedData);

            if ($request->file('gambarPP')) {
                $gambarPath = $request->file('gambarPP')->getClientOriginalName();
                $validatedData['gambarPP'] = $request->file('gambarPP')->storeAs('gambar-guru', $gambarPath, 'public');
            }

            PPGuru::create($validatedData);

            return response()->json([
                'status' => 'success',
                'message' => 'Berhasil menyimpan data.'
            ]);
        } catch (\Exception $e) {
            Log::error('Error storing data: ' . $e->getMessage());

            return response()->json([
                'status' => 'error',
                'message' => 'Error storing data.',
            ], 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data = PPGuru::with('guru')->orderBy('idppGuru', 'desc')->get();

        return DataTables::of($data)
            ->addColumn('namaPegawai', function ($d) {
                return $d->guru->namaPegawai;
            })
            ->addColumn('jabatan', function ($d) {
                return $d->jabatan;
            })
            ->addColumn('gambarPP', function ($d) {
                return $d->gambarPP;
            })
            ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $guruPP = PPGuru::find($id);

        return response()->json($guruPP);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateData(Request $request, $id)
    {
        // Find Berita data by ID
        $guru = PPGuru::find($id);

        $validatedData = $request->validate([
            'idPegawai' => 'required',
            'jabatan' => 'required',
            'gambarPP' => 'file|image|max:2048'
        ]);

        // If there is a new image file
        if ($request->hasFile('gambarPP')) {
            $gambarPath = $request->file('gambarPP')->getClientOriginalName();
            $validatedData['gambarPP'] = $request->file('gambarPP')->storeAs('gambar-guru', $gambarPath, 'public');

            // Delete the old image
            if ($guru->gambar) {
                Storage::delete('public/' . $guru->gambar);
            }
        }

        // Update Berita data
        $guru->update($validatedData);

        // Successfully updated data, send JSON response
        return back()
            ->with('success', 'Berhasil memperbarui data.');
    }





    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $guru = PPGuru::find($id);
        $guru->delete();
        
        Storage::delete('public/' . $guru->gambarPP);

        return response()->json([
            'status' => 'success',
            'message' => 'Berhasil menghapus data.'
        ]);
    }
}
