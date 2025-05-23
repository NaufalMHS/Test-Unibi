<?php

namespace App\Http\Controllers;
use App\Models\MasterTransaksi;
use App\Models\DetailTransaksi;
use App\Models\MasterProduk;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class MasterTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    
     public function index(Request $request)
    {
        $menu = 'detail_transaksi';
        
        $query = MasterTransaksi::with(['detailTransaksi.produk', 'user'])
            ->where('user_id', Auth::id())
            ->orderBy('id', 'desc');

        if ($request->has('cari') && !empty($request->cari)) {
            $searchTerm = '%' . $request->cari . '%';
            
            $query->where(function($q) use ($searchTerm, $request) {
                $q->where('kode_transaksi', 'like', $searchTerm);
                
                $q->orWhereHas('user', function($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                });
                
                $q->orWhereHas('detailTransaksi.produk', function($q) use ($searchTerm) {
                    $q->where('produk', 'like', $searchTerm);
                });
                
                try {
                    $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->cari);
                    $q->orWhereDate('tanggal', $date->format('Y-m-d'));
                } catch (\Exception $e) {
                    try {
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->cari);
                        $q->orWhereDate('tanggal', $date->format('Y-m-d'));
                    } catch (\Exception $e) {
                    }
                }
            });
        }

        $transaksi = $query->paginate(10)
            ->through(function ($trx) {
                $trx->total_bayar = $trx->detailTransaksi->sum(function($detail) {
                    return $detail->quantity * $detail->produk->harga;
                });
                return $trx;
            });

        return view('user.transaksi.index', compact('transaksi', 'menu'));
    }

    public function indexAdmin(Request $request)
    {
        $menu = 'detail_transaksi';
        
        $query = MasterTransaksi::with(['detailTransaksi.produk'])
           
            ->orderBy('id', 'desc');

        if ($request->has('cari') && !empty($request->cari)) {
            $searchTerm = '%' . $request->cari . '%';
            
            $query->where(function($q) use ($searchTerm, $request) {
                $q->where('kode_transaksi', 'like', $searchTerm);
                
                $q->orWhereHas('user', function($q) use ($searchTerm) {
                    $q->where('name', 'like', $searchTerm);
                });
                
                $q->orWhereHas('detailTransaksi.produk', function($q) use ($searchTerm) {
                    $q->where('produk', 'like', $searchTerm);
                });
                
                try {
                    $date = \Carbon\Carbon::createFromFormat('d-m-Y', $request->cari);
                    $q->orWhereDate('tanggal', $date->format('Y-m-d'));
                } catch (\Exception $e) {
                    try {
                        $date = \Carbon\Carbon::createFromFormat('Y-m-d', $request->cari);
                        $q->orWhereDate('tanggal', $date->format('Y-m-d'));
                    } catch (\Exception $e) {
                    }
                }
            });
        }

        $transaksi = $query->paginate(10)
            ->through(function ($trx) {
                $trx->total_bayar = $trx->detailTransaksi->sum(function($detail) {
                    return $detail->quantity * $detail->produk->harga;
                });
                return $trx;
            });

        return view('user.transaksi.index', compact('transaksi', 'menu'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {   
        $menu = 'transaksi';
        $produk = MasterProduk::where('stok', '>', 0)->get();
        return view('admin.transaksi.create', compact('produk' , 'menu'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'produk_id.*' => 'required|exists:master_produk,id',
            'quantity.*' => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request) {
            $transaksi = MasterTransaksi::create([
                'kode_transaksi' => '', 
                'tanggal' => now(),
            ]);

            $kode = 'TRX' . $transaksi->id . now()->format('Ymd');
            $transaksi->update(['kode_transaksi' => $kode]);

            foreach ($request->produk_id as $index => $id_produk) {
                $produk = MasterProduk::findOrFail($id_produk);

                if ($produk->stok < $request->quantity[$index]) {
                    throw new \Exception('Stok tidak mencukupi untuk produk: ' . $produk->produk);
                }

                $produk->decrement('stok', $request->quantity[$index]);

                DetailTransaksi::create([
                    'id_transaksi' => $transaksi->id,
                    'id_produk' => $id_produk,
                    'quantity' => $request->quantity[$index],
                ]);
            }
        });

        return redirect()->route('user.transaksi.index')->with('success', 'Checkout berhasil!');
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $transaksi = MasterTransaksi::with(['detailTransaksi.produk'])->findOrFail($id);
        
        $total = 0;
        foreach ($transaksi->detailTransaksi as $detail) {
            $total += $detail->quantity * $detail->produk->harga;
        }
        
        return view('user.transaksi.detail', [
            'transaksi' => $transaksi,
            'total' => $total
        ]);
    }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $transaksi = MasterTransaksi::with('detailTransaksi')->findOrFail($id);
    
       
        foreach ($transaksi->detailTransaksi as $detail) {
            $detail->delete();
        }
        $transaksi->delete();
    
        return redirect()->back()->with('success', 'Transaksi berhasil dihapus.');
    }
}
