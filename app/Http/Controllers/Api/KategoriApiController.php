<?php

namespace App\Http\Controllers\Api;

use App\Models\Kategori;
use App\Http\Controllers\Controller;
// use Illuminate\Support\Facades\DB;
use App\Http\Resources\PostResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
// use Illuminate\Foundation\Validation\ValidatesRequests;

class KategoriApiController extends Controller
{    
    // use ValidatesRequests;
    public function index()
    {
        //get all posts
        $rsetKategori = kategori::all();

        //return collection of posts as a resource
        // return new Kategori(true, 'List Data Kategori', $rsetKategori);

        return response()->json($rsetKategori);
    }
    
    public function store(Request $request)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'deskripsi'   => 'required',
            'kategori'    => 'required | in:M,A,BHP,BTHP',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

         // Buat data baru
         $kategori = Kategori::create([
            'deskripsi' => $request->deskripsi,
            'kategori'  => $request->kategori
        ]);

        //return response
        return response()->json([
            'success' => true,
            'message' => 'Data Berhasil Disimpan!',
            'data'    => $kategori
        ]); 
    }

    public function show($id)
    {
        // Temukan kategori berdasarkan ID
        $kategori = Kategori::find($id);

        // Periksa apakah kategori ditemukan
        if (!$kategori) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori tidak ditemukan'
            ], 404);
        }

        // Kembalikan data kategori sebagai resource JSON
        return response()->json([
            'success' => true,
            'message' => 'Detail Data Kategori!',
            'data' => $kategori
        ]);
        // return response()->json($kategori);
    }

    // /**
    //  * update
    //  *
    //  * @param  mixed $request
    //  * @param  mixed $id
    //  * @return void
    //  */
    public function update(Request $request, string $id)
    {
        //define validation rules
        $validator = Validator::make($request->all(), [
            'deskripsi'  => 'required',
            'kategori'   => 'required',
        ]);

        //check if validation fails
        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        //find kategori by ID
        $kategori = Kategori::find($id);

        //update kategori
        $kategori->update([
            'deskripsi'  => $request->deskripsi,
            'kategori'   => $request->kategori,
        ]);
        

        //return response
        return new PostResource(true, 'Data Post Berhasil Diubah!', $kategori);
    }

    public function destroy($id)
    {

        //find kategori by ID
        $kategori = Kategori::find($id);

        if(!$kategori){
            return response()->json(['message' => "Kategori tidak ditemukan"], 404);
        }
        //delete kategori
        $kategori->delete();

        //return response
        return response()->json(['message' => "Kategori berhasil dihapus"], 200);
    }

    // public function update(Request $request, $kategori_id)
    // {
    //     // Define validation rules
    //     $validator = Validator::make($request->all(), [
    //         'deskripsi' => 'required',
    //         'kategori'  => 'required|in:M,A,BHP,BTHP',
    //     ]);

    //     // Check if validation fails
    //     if ($validator->fails()) {
    //         return response()->json([
    //             'success'   => false,
    //             'message'   => 'Validasi gagal.',
    //             'errors'    => $validator->errors()
    //         ], 422);
    //     }

    //     // Temukan kategori berdasarkan ID
    //     $kategori = Kategori::find($kategori_id);

    //     // Periksa apakah kategori ditemukan
    //     if (!$kategori) {
    //         return response()->json([
    //             'success'   => false,
    //             'message'   => 'Kategori tidak ditemukan.'
    //         ], 404);
    //     }

    //     // Update data kategori
    //     $kategori->update([
    //         'deskripsi' => $request->deskripsi,
    //         'kategori'  => $request->kategori
    //     ]);

    //     // Return response JSON
    //     return response()->json([
    //         'success'   => true,
    //         'message'   => 'Kategori berhasil diperbarui.',
    //         'data'      => $kategori
    //     ]);
    // }

}