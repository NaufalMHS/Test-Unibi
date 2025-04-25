@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('admin.produk.index') }}" class="a-breadcrumbs">Data Produk</a> /
        </span> Edit Produk
    </h4>

    <div class="card">
        <h5 class="card-header">Edit Produk</h5>

        <form action="{{ route('admin.produk.update', $produk->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="card-body">
                <div class="row">
                    <div class="col">

                        <!-- Nama Produk -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Nama Produk</label>
                            <div class="col-md-9">
                                <input class="form-control" type="text" name="produk" value="{{ old('produk', $produk->produk) }}" required />
                                @error('produk')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Stok -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Stok</label>
                            <div class="col-md-9">
                                <input class="form-control" type="number" name="stok" value="{{ old('stok', $produk->stok) }}" min="0" required />
                                @error('stok')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Harga -->
                        <div class="mb-3 row">
                            <label class="col-md-3 col-form-label">Harga</label>
                            <div class="col-md-9">
                                <input class="form-control" type="number" name="harga" value="{{ old('harga', $produk->harga) }}" min="0" required />
                                @error('harga')
                                    <div class="text-danger">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <!-- Tombol Simpan -->
                        <div class="text-end">
                            <button class="btn btn-primary" type="submit">Update</button>
                            <a class="btn btn-warning" href="{{ route('admin.produk.index') }}">Kembali</a>
                        </div>

                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
