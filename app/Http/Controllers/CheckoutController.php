<?php

namespace App\Http\Controllers;

use App\Models\MasterProduk;
use App\Models\MasterTransaksi;
use App\Models\DetailTransaksi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    
    
    public function index()
    {
        
        $menu = 'checkout';
        $produk = MasterProduk::where('stok', '>', 0)->get();
        return view('user.checkout.index', compact('produk', 'menu'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'produk_id.*' => 'required|exists:master_produk,id',
            'quantity.*' => 'nullable|integer|min:0',
        ]);

        DB::beginTransaction();

        try {
            // Buat transaksi baru
            $transaksi = MasterTransaksi::create([
                'user_id' => Auth::id(),
                'kode_transaksi' => '',
                'tanggal' => now(),
            ]);

            // Generate kode transaksi
            $kode = 'TRX' . $transaksi->id . now()->format('Ymd');
            $transaksi->update(['kode_transaksi' => $kode]);

            // Loop untuk menyimpan detail transaksi
            foreach ($request->produk_id as $index => $id_produk) {
                $qty = (int) $request->quantity[$index];
                if ($qty > 0) {
                    $produk = MasterProduk::findOrFail($id_produk);

                    // Cek stok
                    if ($produk->stok < $qty) {
                        throw new \Exception('Stok tidak cukup untuk produk: ' . $produk->produk);
                    }

                    // Update stok produk
                    $produk->decrement('stok', $qty);

                    // Simpan detail transaksi
                    DetailTransaksi::create([
                        'id_transaksi' => $transaksi->id,
                        'id_produk' => $id_produk,
                        'quantity' => $qty,
                    ]);
                }
            }

            // Commit transaksi jika berhasil
            DB::commit();

            return redirect()->route('user.transaksi.index')->with('success', 'Checkout berhasil!');
        } catch (\Exception $e) {
            // Rollback transaksi jika ada error
            DB::rollBack();
            return back()->withErrors(['msg' => $e->getMessage()])->withInput();
        }
    }
}
