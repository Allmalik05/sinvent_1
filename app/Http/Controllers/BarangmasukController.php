<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangMasuk;
use App\Models\BarangKeluar;
use App\Models\Barang;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BarangmasukController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        Paginator::useBootstrap();
        $datamasuk = BarangMasuk::paginate(5);
        $user = Auth::user();
        return view('v_barangMasuk.index', compact('datamasuk', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $rsetBarang = Barang::all();
        $today = Carbon::now()->toDateString();
        return view('v_barangMasuk.create', compact('rsetBarang', 'today', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi input
        $request->validate([
            'tgl_masuk' => 'required|date',
            'qty_masuk' =>'required|numeric',
            'barang_id' => 'required|exists:kategori,id'
        ]);

        // buat wadah untuk mengecek apakah date sama
        $cek_update_stok = BarangMasuk::where('tgl_masuk', $request->tgl_masuk)->where('barang_id', $request->barang_id)->first();

        // jika ada/satu tanggal maka update
        if($cek_update_stok){
            $cek_update_stok->qty_masuk += $request->qty_masuk;
            $cek_update_stok->save();
            return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan(update)!!']);
        }else{
            // jika tidak sama maka create
            BarangMasuk::create([
                'tgl_masuk' => $request->tgl_masuk,
                'qty_masuk' => $request->qty_masuk,
                'barang_id' => $request->barang_id
            ]);
            return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }
        // $TglMasukBarang = BarangMasuk::where('barang_id', $request->barang_id)->orderBy('tgl_masuk', 'desc')->first();
        // if ($TglMasukBarang && $request->tgl_keluar < $TglMasukBarang->tgl_masuk) {
        //     return redirect()->back()->withErrors(['tgl_keluar' => 'Tanggal keluar tidak boleh sebelum tanggal barang masuk terbaru.']);
        // }

        // simpan data barang
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $datamasuk = BarangMasuk::find($id);
        return view('v_barangMasuk.show', compact('datamasuk', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $datamasuk = BarangMasuk::findOrFail($id);
        $rsetBarang = Barang::all();
        return view('v_barangMasuk.edit', compact('datamasuk', 'rsetBarang', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validasi input
        $request->validate([
            'tgl_masuk' => 'required|date',
            'qty_masuk' =>'required|numeric'
        ]);

        // Update data barang
        $datamasuk = BarangMasuk::findOrFail($id);
        $datamasuk->update([
            'tgl_masuk' => $request->tgl_masuk,
            'qty_masuk' => $request->qty_masuk
        ]);
        return redirect()->route('barangmasuk.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datamasuk = BarangMasuk::find($id);
        
        // Memeriksa apakah ada record di tabel BarangKeluar dengan barang_id yang sama
        $referencedInBarangKeluar = BarangKeluar::where('barang_id', $datamasuk->barang_id)->exists();

        if ($referencedInBarangKeluar) {
        // Jika ada referensi, penghapusan ditolak
        return redirect()->route('barangmasuk.index')->with(['error' => 'Data Tidak Bisa Dihapus Karena Masih Digunakan di Tabel Barang Keluar!']);
        }

        // Menghapus record di tabel BarangMasuk
        $datamasuk->delete();

        // Redirect ke index dengan pesan sukses
        return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
        //delete post
        // $datamasuk->delete();

        //redirect to index
        // return redirect()->route('barangmasuk.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}