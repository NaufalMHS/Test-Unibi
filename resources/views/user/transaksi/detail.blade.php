@extends('admin.layout.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light">
            @if(auth()->user()->hasRole('admin'))
                <a href="{{ route('admin.transaksi.index') }}" class="a-breadcrumbs">Transaksi</a> /
            @endif
            @if(auth()->user()->hasRole('user'))
                <a href="{{ route('user.transaksi.index') }}" class="a-breadcrumbs">Transaksi</a> /
            @endif</span> 
        Detail Transaksi
    </h4>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5></h5>
            @if(auth()->user()->hasRole('admin'))

                <a href="{{ route('admin.transaksi.index') }}" class="btn btn-sm btn-secondary">
                    Kembali
                </a>
            @endif
            @if(auth()->user()->hasRole('user'))
            <a href="{{ route('user.transaksi.index') }}" class="btn btn-sm btn-secondary">
                Kembali
            </a>
            @endif
        </div>

        <div class="card-body">
            <div class="row mb-4">
                <div class="col-md-6">
                    <p><strong>Tanggal:</strong> {{ \Carbon\Carbon::parse($transaksi->tanggal)->format('d-m-Y H:i:s') }}</p>
                    <p><strong>Kode Transaksi:</strong> {{ $transaksi->kode_transaksi }}</p>
                </div>
                <div class="col-md-6 text-md-end">
                    <p><strong>Total Bayar:</strong> Rp {{ number_format($total, 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NO</th>
                            <th>PRODUK</th>
                            <th>QUANTITY</th>
                            <th>HARGA</th>
                            <th>TOTAL</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($transaksi->detailTransaksi as $detail)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $detail->produk->produk }}</td>
                                <td>{{ $detail->quantity }}</td>
                                <td>Rp {{ number_format($detail->produk->harga, 0, ',', '.') }}</td>
                                <td>Rp {{ number_format($detail->quantity * $detail->produk->harga, 0, ',', '.') }}</td>
                            </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-end"><strong>Total</strong></td>
                            <td><strong>Rp {{ number_format($total, 0, ',', '.') }}</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection