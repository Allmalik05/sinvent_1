<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\BarangKeluar;
use App\Models\Barang;
use App\Models\BarangMasuk;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class BarangkeluarController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        Paginator::useBootstrap();
        $search = $request->input('search');
        $tgl_keluar = $request->input('tgl_keluar');

        $datakeluar = Barangkeluar::with('barang')
                                ->when($search, function ($query, $search) {
                                    return $query->whereHas('barang', function($q) use ($search) {
                                        $q->where('merk', 'like', '%' . $search . '%')
                                        ->orWhere('seri', 'like', '%' . $search . '%');
                                    });
                                })
                                ->when($tgl_keluar, function ($query, $tgl_keluar) {
                                    return $query->whereDate('tgl_keluar', $tgl_keluar);
                                })
                                ->latest()
                                ->paginate(10);


        $user = Auth::user();
        return view('v_barangKeluar.index', compact('datakeluar', 'user'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $user = Auth::user();
        $rsetBarang = Barang::all();
        // Mengambil tanggal hari ini
        $today = Carbon::now()->toDateString();
        return view('v_barangKeluar.create', compact('rsetBarang', 'today', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validasi input
        $request->validate([
            'tgl_keluar' => 'required|date',
            'qty_keluar' =>'required|numeric',
            'barang_id' => 'required|exists:kategori,id'
        ]);

        // Validasi input data max
        $rsetBarang = Barang::findOrFail($request->barang_id);

        // Check if the qty_keluar exceeds the available stock
        if ($request->qty_keluar > $rsetBarang->stok) {
            return redirect()->back()->withErrors(['qty_keluar' => 'Jumlah barang keluar tidak boleh melebihi jumlah stok tersedia.']);
        }

        // Validasi tolak input seblum tanggal data masuk
        $latestTglMasuk = BarangMasuk::where('barang_id', $request->barang_id)->orderBy('tgl_masuk', 'desc')->first();
        if ($latestTglMasuk && $request->tgl_keluar < $latestTglMasuk->tgl_masuk) {
            return redirect()->back()->withErrors(['tgl_keluar' => 'Tanggal keluar tidak boleh sebelum tanggal barang masuk terbaru.']);
        }

        // buat wadah untuk mengecek apakah date sama
        $cek_update_stok = BarangKeluar::where('tgl_keluar', $request->tgl_keluar)->where('barang_id', $request->barang_id)->first();

        // jika ada/satu tanggal maka update
        if($cek_update_stok){
            $cek_update_stok->qty_keluar += $request->qty_keluar;
            $cek_update_stok->save();
            return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Disimpan(update)!!']);
        }else{
            // jika tidak sama maka create
            BarangKeluar::create([
                'tgl_keluar' => $request->tgl_keluar,
                'qty_keluar' => $request->qty_keluar,
                'barang_id' => $request->barang_id
            ]);
            return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Disimpan!']);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $user = Auth::user();
        $datakeluar = Barangkeluar::find($id);
        return view('v_barangKeluar.show', compact('datakeluar', 'user'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $user = Auth::user();
        $datakeluar = BarangKeluar::findOrFail($id);
        $rsetBarang = Barang::all();
        return view('v_barangKeluar.edit', compact('datakeluar', 'rsetBarang', 'user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //validasi input
        $request->validate([
            'tgl_keluar' => 'required|date',
            'qty_keluar' =>'required|numeric'
        ]);

        
        $datakeluar = BarangKeluar::findOrFail($id);
        $rsetBarang = Barang::findOrFail($datakeluar->barang_id);

        // Periksa apakah jumlah keluar melebihi stok yang tersedia
        if ($request->qty_keluar > $rsetBarang->stok + $datakeluar->qty_keluar) {
            return redirect()->back()->withErrors(['qty_keluar' => 'Jumlah keluar melebihi stok yang tersedia'])->withInput();
        }

        // Check if the tgl_keluar is before the latest tgl_masuk
        $latestTglMasuk = BarangMasuk::where('barang_id', $datakeluar->barang_id)->orderBy('tgl_masuk', 'desc')->first();
        if ($latestTglMasuk && $request->tgl_keluar < $latestTglMasuk->tgl_masuk) {
            return redirect()->back()->withErrors(['tgl_keluar' => 'Tanggal keluar tidak boleh sebelum tanggal barang masuk terbaru.']);
        }

        // Update data barang
        $datakeluar->update([
            'tgl_keluar' => $request->tgl_keluar,
            'qty_keluar' => $request->qty_keluar
        ]);
        return redirect()->route('barangkeluar.index')->with('success', 'Barang berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $datakeluar = BarangKeluar::find($id);

        //delete post
        $datakeluar->delete();

        //redirect to index
        return redirect()->route('barangkeluar.index')->with(['success' => 'Data Berhasil Dihapus!']);
    }
}
