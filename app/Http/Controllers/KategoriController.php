<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\Paginator;
use Illuminate\Http\Request;
use App\Models\Kategori;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    use ValidatesRequests;

    public function index()
    {
        // $rsetKategori = Kategori::getKategoriAll();
        // return view('v_kategori.index', compact('rsetKategori'));

        Paginator::useBootstrap();
        $rsetKategori = DB::table('kategori')->select('id','deskripsi', 'kategori',DB::raw('ketKategorik(kategori) as ketkategori'))->paginate(8);
        $user = Auth::user();
        return view('v_kategori.index',compact('rsetKategori', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $aKategori = array('blank'=>'Pilih Kategori',
                            'M'=>'Barang Modal',
                            'A'=>'Alat',
                            'BHP'=>'Bahan Habis Pakai',
                            'BTHP'=>'Bahan Tidak Habis Pakai'
                            );
        return view('v_kategori.create',compact('aKategori', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'deskripsi'   => 'required',
            'kategori'    => 'required | in:M,A,BHP,BTHP',
        ]);

        $cek_deskripsi = Kategori::where('deskripsi', $request->deskripsi)->exists();

        // validasi jika input deskripsi sama, error
        if($cek_deskripsi){
            return redirect()->back()->withErrors(['deskripsi' => 'Maaf deskripsi sudah ada.']);
        }else{
            Kategori::create([
                'deskripsi'  => $request->deskripsi,
                'kategori' => $request->kategori
            ]);
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }    
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $rsetKategori = Kategori::getKategoriById($id);
        return view('v_kategori.show', compact('rsetKategori', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $rsetKategori = Kategori::findOrFail($id);
        return view('v_kategori.edit', compact('rsetKategori', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'deskripsi' => 'required',
            'kategori'  => 'required | in:M,A,BHP,BTHP',
        ]);

        $rsetKategori = Kategori::findOrFail($id);

        // Cek apakah deskripsi baru sudah ada di record lain
        $cekDeskripsi = Kategori::where('deskripsi', $request->deskripsi)
                                ->where('id', '!=', $id)
                                ->exists();

        if ($cekDeskripsi) {
        // Jika deskripsi sudah ada, kembali dengan pesan error
        return redirect()->back()->withErrors(['deskripsi' => 'Maaf deskripsi sudah ada.']);
        }else{
            $rsetKategori->update([
                'deskripsi' => $request->deskripsi,
                'kategori'  => $request->kategori
            ]);
            return redirect()->route('kategori.index')->with('success', 'Item updated successfully');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // validasi jika record kategori dipakai di barang, error
        if (DB::table('barang')->where('kategori_id', $id)->exists()){
            return redirect()->route('kategori.index')->with(['error' => 'Data Gagal Dihapus!']);
        } else {
            $rsetKategori = Kategori::find($id);
            $rsetKategori->delete();
            return redirect()->route('kategori.index')->with(['success' => 'Data Berhasil Dihapus!']);
        }
    }
}