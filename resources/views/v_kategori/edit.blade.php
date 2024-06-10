@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kategori.update',$rsetKategori->id) }}" method="POST">                    
                            @csrf
                            @method('PUT')

                            <div class="form-group">
                                <label class="font-weight-bold">DESKRIPSI</label>
                                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" value="{{ old('deskripsi',$rsetKategori->deskripsi) }}" placeholder="Masukkan Deskripsi">
                            
                                <!-- error message untuk deskripsi -->
                                @error('deskripsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="options">KATEGORI</label>
                                <select name="kategori" class="form-control" required>
                                    <option value="M" {{ $rsetKategori->kategori === 'M' ? 'selected' : '' }}>Barang Modal</option>
                                    <option value="A" {{ $rsetKategori->kategori === 'A' ? 'selected' : '' }}>Alat</option>
                                    <option value="BHP" {{ $rsetKategori->kategori === 'BHP' ? 'selected' : '' }}>Barang Habis Pakai</option>
                                    <option value="BTHP" {{ $rsetKategori->kategori === 'BTHP' ? 'selected' : '' }}>Barang Tidak Habis Pakai</option>
                                    <!-- Tambahkan opsi lain sesuai kebutuhan -->
                                </select>
                                @error('kategori')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror

                            <br>
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>
                        </form> 
                    </div>
                    <div class="row">
                        <div class="col-md-12  text-right">
                            <a href="{{ route('kategori.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
                        </div>
                    </div>
                </div>

 

            </div>
        </div>
    </div>
@endsection