@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="font-weight-bold mb-3 mt-3">DAFTAR BARANG KELUAR</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @if(session('success'))
                            <div class="alert alert-success mt-3">
                                {{ session('success') }}
                            </div>
                        @endif
                        @if(session('error'))
                            <div class="alert alert-danger mt-3">
                                {{ session('error') }}
                            </div>
                        @endif

                        <div class="row mb-3">
                            <div class="col-md-7">
                                <a href="{{ route('barangmasuk.create') }}" class="btn btn-md btn-success">TAMBAH BARANG MASUK</a>
                            </div>
                            <div class="col-md-5">
                                <form action="{{ route('barangmasuk.index') }}" method="GET">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Cari barang..." value="{{ request()->input('search') }}">
                                        <input type="date" name="tgl_masuk" class="form-control" value="{{ request()->input('tgl_masuk') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-secondary" type="submit"><i class="fa fa-search"></i></button>
                                        </div>
                                        @if(request()->filled('search') || request()->filled('tgl_masuk'))
                                            <div class="input-group-append">
                                                <a href="{{ route('barangmasuk.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
                                            </div>
                                        @endif
                                    </div>
                                </form>
                            </div>
                        </div>

                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th>NO</th>
                                    <th>DATE</th>
                                    <th>QTY_MASUK</th>
                                    <th>BARANG</th>
                                    <th style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($datamasuk as $data)
                                    <tr>
                                        <td>{{ ++$i  }}</td>
                                        <td>{{ $data->tgl_masuk  }}</td>
                                        <td>{{ $data->qty_masuk  }}</td>
                                        <td>{{ $data->barang->merk }} - {{ $data->barang->seri }} </td>
                                        <td class="text-center"> 
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barangmasuk.destroy', $data->id) }}" method="POST">
                                                <a href="{{ route('barangmasuk.show', $data->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('barangmasuk.edit', $data->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-sm btn-danger"><i class="fa fa-trash"></i></button>
                                            </form>
                                        </td>
                                        
                                    </tr>
                                @empty
                                    <div class="alert">
                                        Data Barang belum tersedia
                                    </div>
                                @endforelse
                            </tbody>
                            
                        </table>
                        {{ $datamasuk->links('pagination::bootstrap-5') }}
                    </div>
                </div>  
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <script>    
        //message with sweetalert
        @if(session('success'))
            Swal.fire({
                icon: "success",
                title: "BERHASIL",
                text: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @elseif(session('error'))
            Swal.fire({
                icon: "error",
                title: "GAGAL!",
                text: "{{ session('error') }}",
                showConfirmButton: false,
                timer: 2000
            });
        @endif
    </script>
@endsection