@extends('admin.layout.main')

@section('content')
<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            <a href="{{ route('user.transaksi.index') }}" class="a-breadcrumbs">Data Transaksi</a> /
        </span> Checkout Produk
    </h4>

    <div class="card">
        <h5 class="card-header">Form Checkout Produk</h5>

        <form action="{{ route('user.checkout.store') }}" method="POST">
            @csrf
            <div class="card-body">
                {{-- Tampilkan Error Validasi --}}
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Produk</th>
                                <th>Stok Tersedia</th>
                                <th>Harga</th>
                                <th>Qty</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produk as $item)
                                <tr>
                                    <td>{{ $item->produk }}</td>
                                    <td>{{ $item->stok }}</td>
                                    <td>Rp {{ number_format($item->harga, 0, ',', '.') }}</td>
                                    <td>
                                        <input type="hidden" name="produk_id[]" value="{{ $item->id }}">
                                        <input 
                                            type="number" 
                                            name="quantity[]" 
                                            class="form-control @error('quantity.*') is-invalid @enderror" 
                                            min="0" 
                                            max="{{ $item->stok }}" 
                                            value="0"
                                        >
                                        @error('quantity.*')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="text-end mt-4">
                    <button class="btn btn-primary" type="submit">Checkout</button>
                    <a href="{{ route('user.transaksi.index') }}" class="btn btn-warning">Kembali</a>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
