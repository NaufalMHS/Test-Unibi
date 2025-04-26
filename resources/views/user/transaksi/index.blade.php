@extends('admin.layout.main')

@section('content')

<div class="container-xxl flex-grow-1 container-p-y">
    <h4 class="fw-bold py-3 mb-4">
        <span class="text-muted fw-light"></span> Data Transaksi Saya
    </h4>

    <div class="card">
        <h5 class="card-header">
            <div class="row mb-4">
                <div class="col-md-6">
                    Riwayat Checkout
                </div>
                <div class="col-md-6 d-flex flex-row-reverse">
                @if(auth()->user()->hasRole('user'))
                    <form action="{{ route('user.transaksi.index') }}" method="GET">               
                        <div class="input-group">
                            <input type="text" id="cari" class="form-control" name="cari" value="{{ request('cari') }}" placeholder="Cari kode transaksi...">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                    @endif
                @if(auth()->user()->hasRole('admin'))
                    <form action="{{ route('admin.transaksi.index') }}" method="GET">               
                        <div class="input-group">
                            <input type="text" id="cari" class="form-control" name="cari" value="{{ request('cari') }}" placeholder="Cari kode transaksi...">
                            <button class="btn btn-outline-primary" type="submit">Cari</button>
                        </div>
                    </form>
                    @endif
                    
                </div>
            </div>
        </h5>

        <div class="table-responsive text-nowrap">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Transaksi</th>
                        <th>Tanggal</th>
                        <th>Total Bayar</th>
                        <th>Detail Produk</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transaksi as $index => $trx)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $trx->kode_transaksi }}</td>
                            <td>{{ \Carbon\Carbon::parse($trx->tanggal)->format('d-m-Y') }}</td>
                            <td>Rp {{ number_format($trx->total_bayar, 0, ',', '.') }}</td>
                            <td>
                                <ul class="mb-0">
                                    @foreach ($trx->detailTransaksi as $detail)
                                        <li>{{ $detail->produk->produk }} x {{ $detail->quantity }}</li>
                                    @endforeach
                                </ul>
                            </td>
                            <td>
                                @if(auth()->user()->hasRole('user'))
                                    <a href="{{ route('user.transaksi.show', $trx->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bx bx-show"></i> Detail
                                    </a>
                                    <form action="{{ route('user.transaksi.destroy', $trx->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif

                                @if(auth()->user()->hasRole('admin'))
                                    <a href="{{ route('admin.transaksi.show', $trx->id) }}" class="btn btn-sm btn-primary">
                                        <i class="bx bx-show"></i> Detail
                                    </a>
                                    <form action="{{ route('admin.transaksi.destroy', $trx->id) }}" method="POST" class="d-inline"
                                        onsubmit="return confirm('Yakin ingin menghapus transaksi ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            <i class="bx bx-trash"></i> Hapus
                                        </button>
                                    </form>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                    @if ($transaksi->count() == 0)
                        <tr>
                            <td colspan="6" class="text-center">Belum ada transaksi checkout.</td>
                        </tr>
                    @endif

                </tbody>
            </table>

            {{-- PAGINATION --}}
            <div class="mt-3 px-3">
                {{ $transaksi->links() }}
            </div>
        </div>
    </div>
</div>

@endsection