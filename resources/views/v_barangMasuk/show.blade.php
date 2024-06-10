@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8">
               <div class="card border-0 shadow rounded">
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>MERK</td>
                                <td>{{ $datamasuk->barang->merk }}</td>
                            </tr>
                            <tr>
                                <td>SERI</td>
                                <td>{{ $datamasuk->barang->seri }}</td>
                            </tr>
                            <tr>
                                <td>QTY MASUK</td>
                                <td>{{ $datamasuk->qty_masuk }}</td>
                            </tr>
                            <tr>
                                <td>DATE</td>
                                <td>{{ $datamasuk->tgl_masuk }}</td>
                            </tr>
                        </table>
                    </div>
               </div>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12  text-right">
                <a href="{{ route('barangmasuk.index') }}" class="btn btn-md btn-primary mb-3">Back</a>
            </div>
        </div>
    </div>
@endsection