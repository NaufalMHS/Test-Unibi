@extends('admin.layout.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"><a href="{{ route('admin.produk.index') }}" class="a-breadcrumbs">Beranda</a> /</span> Data Produk
    </h4>

    <div class="card">
        <h5 class="card-header">
            <div class="row mb-4">
                <div class="col-md-6">
                    Data Produk
                    <a href="{{ route('admin.produk.create') }}" class="btn btn-primary btn-sm">Tambah Produk</a>
                </div>
                <div class="col-md-6 d-flex flex-row-reverse">
                    <form action="{{ route('admin.produk.index') }}" method="GET">
                        <div class="input-group">
                            <input type="text" id="cari" class="form-control" name="cari" value="{{ request('cari') }}" placeholder="Cari produk...">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                </div>
            </div>
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Produk</th>
                        <th>Stok</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($produk as $index => $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->produk }}</td>
                            <td>{{ $item->stok }}</td>
                            <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                            <td>
                                <a href="{{ route('admin.produk.edit', $item->id) }}" class="btn btn-warning btn-sm">Edit</a>

                                <form action="{{ route('admin.produk.destroy', $item->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('Yakin ingin menghapus produk ini?')">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach

                    @if ($produk->isEmpty())
                        <tr>
                            <td colspan="5" class="text-center">Tidak ada data produk.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{-- PAGINATION --}}
            <div class="mt-3 px-3">
                {{ $produk->links('admin.layout.pagination') }}
            </div>
        </div>
    </div>
</div>

@endsection
