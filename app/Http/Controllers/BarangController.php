<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Barang;
use App\Models\Kategori;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;


class BarangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Paginator::useBootstrap();
        // $rsetBarang = Barang::orderBy('id', 'asc')->get();
        $rsetBarang = Barang::paginate(5);
        $user = Auth::user();
        return view('v_barang.index',compact('rsetBarang', 'user'));
        // $rsetBarang = Barang::all();
        // return view('v_barang.1',compact('rsetBarang'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $rsetKategori = Kategori::all();
        return view('v_barang.create', compact('rsetKategori', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi input
        $request->validate([
            'merk' => 'required|string|max:50',
            'seri' =>'required|string|max:50',
            'spesifikasi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategori,id'
        ]);

        // simpan data barang
        Barang::create([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'kategori_id' => $request->kategori_id
        ]);

        return redirect()->route('barang.index')->with(['success' => 'Data Berhasil Disimpan!']);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $rsetBarang = Barang::find($id);    
        return view('v_barang.show',compact('rsetBarang', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $rsetBarang = Barang::findOrFail($id);
        $rsetKategori = Kategori::all();
        return view('v_barang.edit', compact('rsetBarang', 'rsetKategori', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validasi input jika diperlukan
        $request->validate([
            'merk' => 'required|string|max:50',
            'seri' => 'required|string|max:50',
            'spesifikasi' => 'nullable|string',
            'kategori_id' => 'required|exists:kategori,id',
        ]);

        // Update data barang
        $rsetBarang = Barang::findOrFail($id);
        $rsetBarang->update([
            'merk' => $request->merk,
            'seri' => $request->seri,
            'spesifikasi' => $request->spesifikasi,
            'kategori_id' => $request->kategori_id,
        ]);
        return redirect()->route('barang.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Cek apakah ada transaksi barang keluar terkait dengan barang
        $barangMasukTerkait = BarangMasuk::where('barang_id', $id)->exists();
        // Cek apakah ada transaksi barang keluar terkait dengan barang
        $barangKeluarTerkait = BarangKeluar::where('barang_id', $id)->exists();
    
        // Cek apakah stok barang tidak nol
        $stokBarang = Barang::where('id', $id)->where('stok', '>', 0)->exists();
    
        if ($barangMasukTerkait || $barangKeluarTerkait || $stokBarang) {
            return redirect()->route('barang.index')->with(['error' => 'Barang tidak dapat dihapus karena terkait dengan transaksi atau masih memiliki stok.']);
        } else {
            // Hapus barang jika tidak terkait dengan transaksi dan stoknya nol
            $rsetBarang = Barang::find($id);
            $rsetBarang->delete();
    
            return redirect()->route('barang.index')->with(['success' => 'Barang berhasil dihapus.']);
        }
    }
}