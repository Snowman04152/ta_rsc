<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use App\Models\User;
use App\Models\Transaksi;
use App\Models\TransaksiLelang;
use Illuminate\Http\Request;

class AdminController extends Controller
{
//     public function showData()
// {
//     $data = Admin::all();
//     return view('test', ['data' => $data]);
// }

    // public function index(){
    //     $pageTitle = 'Halaman Login Admin';
    //     return view('admin.loginadmin' );
    // }
    public function dashboard(){
        $pageTitle = 'Dashboard Admin';
        return view('admin.dashboard' , compact('pageTitle'));
    }
    public function transaksiIndex(){
        $pageTitle = 'Transaksi Produk';
        $transaksi = Transaksi::all();
        return view('admin.transaksi.transaksi', compact('pageTitle','transaksi'));

    }
    public function transaksiLelangIndex(){
        $pageTitle = 'Transaksi Lelang';
        $transaksi = TransaksiLelang::with('penawaran.user','penawaran.produk_lelang')->get();
        
        return view('admin.transaksi.transaksilelang', compact('pageTitle','transaksi'));

    }

    public function CustomerIndex(){
        $pageTitle = 'Customer';
        $user = User::all();
        return view('admin.customer.customer', compact('pageTitle','user'));
    }

    public function CustomerDetail(string $id){
        $pageTitle = 'Detail Customer';
        $user = User::with('alamat')->find($id);
        return view('admin.customer.detailcustomer', compact('pageTitle','user'));

    }

    public function transaksiLelangDetail(string $id){
        $pageTitle = 'Detail Transaksi Lelang';
        $transaksi = TransaksiLelang::with('penawaran.user','penawaran.produk_lelang','alamat')->find($id);
        return view('admin.transaksi.detailtransaksilelang', compact('pageTitle','transaksi'));

    }

    public function transaksiDetail(string $id){
        $pageTitle = 'Detail Transaksi Produk';
        $transaksi = Transaksi::with('alamat')->find($id);
        return view('admin.transaksi.detailtransaksi', compact('pageTitle','transaksi'));

    }
    // public function produk(){
    //     $pageTitle = 'Produk Admin';
    //     return view('admin.produk.produk');
    // }
    // public function addprod(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.produk.addproduk');
    // }
    // public function editprod(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.produk.editproduk');
    // }
    // public function lelangprod(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.lelang.lelangproduk');
    // }
    // public function editlelang(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.lelang.editlelang');
    // }
    // public function addlelang(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.lelang.addlelang');
    // }
    // public function detaillelang(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.lelang.detaillelang');
    // }
    // public function transaksi(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.transaksi.transaksi');
    // }
    // public function detailtransaksi(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.transaksi.detailtransaksi');
    // }
    // public function customer(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.customer.customer');
    // }
    // public function detailcustomer(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.customer.detailcustomer');
    // }
    // public function riwayatcustomer(){
    //     $pageTitle = 'Add Produk Admin';
    //     return view('admin.customer.riwayatcustomer');
    // }
}
