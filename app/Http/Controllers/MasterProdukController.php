<?php

namespace App\Http\Controllers;

use App\Models\MasterProduk;
use Illuminate\Http\Request;

class MasterProdukController extends Controller
{
    /**
     * Display a listing of the resource.
     */ 
    public function index(Request $request)
    {
        $menu = 'kelola_produk';
        
        $query = MasterProduk::query()->orderBy('id', 'desc');

        if ($request->filled('cari')) {
            $searchTerm = '%' . $request->cari . '%';
            
            $query->where(function($q) use ($searchTerm, $request) {
                $q->where('produk', 'like', $searchTerm);
                
                if (is_numeric($request->cari)) {
                    $q->orWhere('stok', '=', (int)$request->cari);
                }
                
                if (is_numeric($request->cari)) {
                    $q->orWhere('harga', '=', (float)$request->cari);
                }
                          
                if (is_numeric($request->cari)) {
                    $q->orWhere('id', '=', (int)$request->cari);
                }
            });
        }
        $produk = $query->paginate(10)->appends($request->query());

        return view('admin.produk.index', compact('produk', 'menu'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $menu = 'kelola_produk';
        return view('admin.produk.create', compact('menu'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
        $request->validate([
            'produk' => 'required|unique:master_produk,produk',
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
        ]);

        MasterProduk::create($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MasterProduk $produk)
    {
        $menu = 'kelola_produk';
        return view('admin.produk.edit', compact('produk' , 'menu'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MasterProduk $produk)
    {
        $request->validate([
            'produk' => 'required|unique:master_produk,produk,' . $produk->id,
            'stok' => 'required|integer|min:0',
            'harga' => 'required|integer|min:0',
        ]);

        $produk->update($request->all());

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MasterProduk $produk)
    {
        $produk->delete();

        return redirect()->route('admin.produk.index')->with('success', 'Produk berhasil dihapus.');
    }
}
