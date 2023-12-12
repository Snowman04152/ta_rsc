<?php

namespace App\Http\Controllers;

use App\Models\Ulasan;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Varian;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function dashboard(){
        $pageTitle = 'Dashboard';
        return view('customer.dashboard',compact('pageTitle'));
    }
    public function produkreg(){
        $produk = Produk::with('varian')->get();

        


        return view('customer.produk.produk',compact('produk'));
    }
    public function detailproduk(string $id , Request $request){
        $id_varian = $request->varian;
        $pageTitle = 'Detail Produk';
        $produk = Produk::find($id);
        if ($id_varian !== null) {
            $varian = Varian::where(['id_produk' => $id, 'id' => $id_varian])->first();
        } else {
            $varian = Varian::where('id_produk', $id)->first();
            
        }
        $varian2 = Varian::where('id_produk', $id)->get();
    
        if ($varian && $varian->id !== null) {
            $ulasan = Ulasan::with('transaksi.user', 'varian')
                ->where('id_varian', $varian->id)
                ->get();

            if($ulasan->count() == 0 ){
                $ratingTotal = 0 ;
                $transaksiTotal = 0 ;
                $ulasanTotal = 0 ;
            }else{
                $ratingTotal = $ulasan->sum('rating') / $ulasan->count();
                $transaksiTotal = Keranjang::where('id_varian', $varian->id)->whereNotNull('id_transaksi')->count();
                $ulasanTotal = $ulasan->count();
            }


        } else {
            $ulasan = null ;
            $ratingTotal = 0;
            $transaksiTotal = 0 ;
            $ulasanTotal = 0 ;
        }

        return view('customer.produk.detailproduk',compact('produk','varian','varian2','ulasan','ratingTotal','transaksiTotal' , 'ulasanTotal'));
    }
    public function lelang(){
        return view('customer.lelang.lelang');
    }
    public function detaillelang(){
        return view('customer.lelang.detaillelang');
    }
    public function riwayatlelang(){
        return view('customer.lelang.riwayatlelang');
}
    public function keranjang(){
        return view('customer.keranjang.keranjang');
    }
    public function pesanan(){
        return view('customer.pesanan.pesanan');
    }
    public function profil(){
        return view('customer.profil.profil');
    }
    // public function riwayat(){
    //     return view('customer.riwayat.riwayat');
    // }
    public function detailpembelian(){
        return view('customer.riwayat.detailpembelian');
    }
    public function bantuan(){
        return view('customer.bantuan');
    }
    
}
