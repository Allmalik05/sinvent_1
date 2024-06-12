@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-10">
                    <div class="col-md-12  text-right">
                        <a href="{{ route('barang.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
                    </div>
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>MERK</td>
                                <td>{{ $rsetBarang->merk }}</td>
                            </tr>
                            <tr>
                                <td>SERI</td>
                                <td>{{ $rsetBarang->seri }}</td>
                            </tr>
                            <tr>
                                <td>SPESIFIKASI</td>
                                <td>{{ $rsetBarang->spesifikasi }}</td>
                            </tr>
                            <tr>
                                <td>STOK</td>
                                <td>{{ $rsetBarang->stok }}</td>
                            </tr>
                            <tr>
                            <tr>
                                <td>DESKRIPSI</td>
                                <td>{{ $rsetBarang->kategori->deskripsi }}</td>
                            </tr>
                                <td>KATEGORI</td>
                                <td>{{ $rsetKategori->ketkategori }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>
        </div>
    </div>
@endsection