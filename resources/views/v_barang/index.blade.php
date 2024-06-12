@extends('layouts.adm-main')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <div class="row">
                            <div class="col-md-6">
                                <h4 class="font-weight-bold mb-3 mt-3">DAFTAR BARANG</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="row mb-3">
                            <div class="col-md-7">
                                <a href="{{ route('barang.create') }}" class="btn btn-md btn-success mb-3">TAMBAH BARANG</a>
                            </div>
                            <div class="col-md-5">
                                <form action="{{ route('barang.index') }}" method="get" >
                                    <div class="input-group">
                                        <input type="search" name="search" class="form-control bg-light border-0 small" placeholder="Search for..."
                                            aria-label="Search" aria-describedby="basic-addon2" value="{{ request()->input('search') }}">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="submit">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                        @if(request()->filled('search'))
                                            <div class="input-group-append">
                                                <a href="{{ route('barang.index') }}" class="btn btn-secondary"><i class="fa fa-times"></i></a>
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
                                    <th>MERK</th>
                                    <th>SERI</th>
                                    <!-- <th>SPESIFIKASI</th> -->
                                    <th>STOK</th>
                                    <th>KATEGORI</th>
                                    <th style="width: 15%">AKSI</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($rsetBarang as $index => $rowbarang)
                                    <tr>
                                        <td>{{ $rsetBarang->firstItem() + $index }}</td>
                                        <td>{{ $rowbarang->merk  }}</td>
                                        <td>{{ $rowbarang->seri  }}</td>
                                        <!-- <td>{{ $rowbarang->spesifikasi  }}</td> -->
                                        <td>{{ $rowbarang->stok  }}</td>
                                        <td>{{ $rowbarang->kategori->kategori }}</td>
                                        <td class="text-center"> 
                                            <form onsubmit="return confirm('Apakah Anda Yakin ?');" action="{{ route('barang.destroy', $rowbarang->id) }}" method="POST">
                                                <a href="{{ route('barang.show', $rowbarang->id) }}" class="btn btn-sm btn-dark"><i class="fa fa-eye"></i></a>
                                                <a href="{{ route('barang.edit', $rowbarang->id) }}" class="btn btn-sm btn-primary"><i class="fa fa-pencil-alt"></i></a>
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
                        {{ $rsetBarang->links('pagination::bootstrap-5') }}
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