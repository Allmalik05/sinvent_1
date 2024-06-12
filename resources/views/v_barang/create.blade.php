@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="font-weight-bold mb-3 mt-3">TAMBAH BARANG</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-12  text-right">
                                <a href="{{ route('barang.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
                            </div>
                        </div>
                        <form action="{{ route('barang.store') }}" method="POST" enctype="multipart/form-data">                    
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">MERK</label>
                                <input type="text" class="form-control @error('merk') is-invalid @enderror" name="merk" value="{{ old('merk') }}" placeholder="Masukkan Merk">
                            
                                <!-- error message untuk merk -->
                                @error('merk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">SERI</label>
                                <input type="text" class="form-control @error('seri') is-invalid @enderror" name="seri" value="{{ old('seri') }}" placeholder="Masukkan Seri">
                            
                                <!-- error message untuk seri -->
                                @error('seri')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">SPESIFIKASI</label>
                                <input type="text" class="form-control @error('spesifikasi') is-invalid @enderror" name="spesifikasi" value="{{ old('spesifikasi') }}" placeholder="Masukkan Merk">
                            
                                <!-- error message untuk spesifikasi -->
                                @error('spesifikasi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">Kategori</label>
                                <select class="form-select @error('kategori_id') is-invalid @enderror" name="kategori_id" aria-label="Default select example">
                                    <option value="" selected disabled>Pilih Kategori</option>
                                    @foreach($rsetKategori as $kategori)
                                        <option value="{{ $kategori->id }}">{{ $kategori->deskripsi }}</option>
                                    @endforeach
                                </select>
                                @error('kategori_id')
                                    <div class="alert alert-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                            
                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection