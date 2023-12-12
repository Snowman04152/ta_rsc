<?php

namespace App\Http\Controllers;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Keranjang;
use App\Models\Varian;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class KeranjangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Keranjang';
        $keranjang = Keranjang::with('varian.produk')->whereHas('varian.produk')->where('id_user', Auth::id())->where('id_transaksi', null)->get();
        return view('customer.keranjang.keranjang', compact('pageTitle', 'keranjang'));



    }

    public function Addqty(Request $request)
    {
        $keranjang = $request->keranjang;
        $value = $request->value;

        foreach ($keranjang as $index => $keranjangs) {
            $id = $keranjangs['id'];
            $values = $value[$index]['jumlah_produk'];

            $qty = Keranjang::find($id);
            $qty->jumlah_produk = $values;
            $qty->save();
        }
        return redirect()->route('keranjang.index');



    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, string $id)
    {
        $produk = Varian::where('id', $id)->value('id_produk');
        $keranjang = new Keranjang;
        $keranjang->id_user = Auth::id();
        $keranjang->id_varian = $id;
        $keranjang->id_transaksi = null;
        $keranjang->jumlah_produk = $request->quantity;
        $keranjang->save();

        
        return redirect()->route('detailproduk', ['id' => $produk, 'varian' => $id]);
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
    public function destroy(string $id)
    {
        $deletedKeranjang = Keranjang::find($id);
        if ($deletedKeranjang) {
            $deletedKeranjang->delete();
        }

        // Update the properties of another Varian with the same $id_produk
        return redirect()->route('keranjang.index');
    }
}
