@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('kategori.store') }}" method="POST" enctype="multipart/form-data">                    
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">DESKRIPSI</label>
                                <input type="text" class="form-control @error('deskripsi') is-invalid @enderror" name="deskripsi" value="{{ old('deskripsi') }}" placeholder="Masukkan Deskripsi">
                            
                                <!-- error message untuk deskripsi -->
                                @error('deskripsi')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label class="font-weight-bold">KATEGORI</label>
                         
                                <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategori1" value="M">
                                    <label class="form-check-label" for="kategori1">
                                      M - Barang Model
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategori2" value="A">
                                    <label class="form-check-label" for="kategori2">
                                      A - Alat
                                    </label>
                                  </div>
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategori3" value="BHP">
                                    <label class="form-check-label" for="kategori3">
                                      BHP - Barang Habis Pakai
                                    </label>
                                  </div> 
                                  <div class="form-check">
                                    <input class="form-check-input" type="radio" name="kategori" id="kategori4" value="BTHP">
                                    <label class="form-check-label" for="kategori4">
                                      BTHP - Barang Tidak Habis Pakai
                                    </label>
                                  </div>                                 

                                <!-- error message untuk nis -->
                                @error('kategori')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                         
                            <button type="submit" class="btn btn-md btn-primary">SIMPAN</button>
                            <button type="reset" class="btn btn-md btn-warning">RESET</button>

                            <div class="row">
                              <div class="col-md-12  text-right">
                                  <a href="{{ route('kategori.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
                              </div>
                            </div>

                        </form> 
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection