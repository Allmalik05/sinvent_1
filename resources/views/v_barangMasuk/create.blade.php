@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                    <div class="row">
                        <div class="col-md-12  text-left">
                            <h2>Barang Masuk</h2>
                        </div>
                        <div class="col-md-12  text-right">
                            <a href="{{ route('barangmasuk.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
                        </div>
                    </div>
                        <form action="{{ route('barangmasuk.store') }}" method="POST" enctype="multipart/form-data">                    
                            @csrf

                            <div class="form-group">
                                <label class="font-weight-bold">DATE</label>
                                <input type="date" class="form-control @error('tgl_masuk') is-invalid @enderror" name="tgl_masuk" value="{{ $today }}" placeholder="Masukkan Date">
                            
                                <!-- error message untuk tgl_masuk -->
                                @error('tgl_masuk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">QUANTITAS</label>
                                <input type="number" class="form-control @error('qty_masuk') is-invalid @enderror" name="qty_masuk" value="{{ old('qty_masuk') }}" placeholder="Masukkan Quantitas">
                            
                                <!-- error message untuk qty_masuk -->
                                @error('qty_masuk')
                                    <div class="alert alert-danger mt-2">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label class="font-weight-bold">BARANG</label>
                                <select class="form-select @error('barang_id') is-invalid @enderror" name="barang_id" aria-label="Default select example">
                                    <option value="" selected disabled>Pilih barang</option>
                                    @foreach($rsetBarang as $barang)
                                        <option value="{{ $barang->id }}">{{ $barang->merk }} - {{ $barang->seri }} </option>
                                    @endforeach
                                </select>
                                @error('barang_id')
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