<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\Produk;
use App\Models\Keranjang;
use App\Models\Varian;
use App\Models\Alamat;
use App\Models\Transaksi;
use App\Models\Ulasan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\User;
use Validator;

class ProdukController extends Controller
{




    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        $pageTitle = 'Produk';

        $produk = Produk::all();
        return view('admin.produk.produk', compact('pageTitle', 'produk'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Add Produk';

        return view('admin.produk.addproduk', compact('pageTitle'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka'
        ];
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'umur_simpan' => 'required',
            'tanggal_ambil' => 'required',
            'lokasi_ambil' => 'required',
            'jenis_pengiriman' => 'required',
            'status_produk' => 'required',
            'foto_produk' => 'required',
            'stok' => 'required',
            'deskripsi' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $file = $request->file('foto_produk');
        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();
            $file->store('public/files');
        }

        // ELOQUENT
        $produk = new Produk;
        $produk->nama_produk = $request->nama_produk;
        $produk->tanggal_pengambilan = $request->tanggal_ambil;
        $produk->lokasi_pengambilan = $request->lokasi_ambil;
        $produk->status_pengambilan = $request->jenis_pengiriman;
        $produk->status = $request->status_produk;
        $produk->status_pengambilan = $request->jenis_pengiriman;
        $produk->status = $request->status_produk;
        $produk->stok = $request->stok;
        $produk->umur_simpan = $request->umur_simpan;
        $produk->deskripsi = $request->deskripsi;

        if ($file != null) {
            $produk->original_filename = $originalFilename;
            $produk->encrypted_filename = $encryptedFilename;
        }

        $produk->save();
        Alert::success('Berhasil Ditambah', 'Produk Berhasil Ditambahkan!.');

        return redirect()->route('produk.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id, Request $request)
    {
        $id_varian = $request->varian;
        $pageTitle = 'Detail Produk';
        $produk = Produk::find($id);
        if ($id_varian !== null) {
            $varian = Varian::where(['id_produk' => $id, 'id' => $id_varian])->first();
            // if ($varian === null) {
            //     $varian = Varian::where('id_produk', $id)->first();
            // }
        } else {
            $varian = Varian::where('id_produk', $id)->first();

        }
        $varian2 = Varian::where('id_produk', $id)->get();
        return view('admin.produk.detailproduk', compact('pageTitle', 'produk', 'varian', 'varian2'));
    }
    // public function show(string $id, Request $request)
    // {
    //     $id_varian = $request->varian;
    //     $pageTitle = 'Detail Produk';
    //     $produk = Produk::find($id);
    //     if ($id_varian !== null) {
    //         $varian = Varian::where(['id_produk' => $id, 'id' => $id_varian])->first();
    //         if ($varian === null) {
    //             $varian = Varian::where('id_produk', $id)->first();
    //         }
    //     } else {
    //         $varian = Varian::where('id_produk', $id)->first();
    //     }
    //     $varian2 = Varian::where('id_produk', $id)->get();
    //     return view('admin.produk.detailproduk', compact('pageTitle','produk','varian','varian2'));
    // }
    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Produk';
        $produk = Produk::find($id);
        $varian = Varian::where('id_produk', $id)->get();

        return view('admin.produk.editproduk', compact('pageTitle', 'produk', 'varian'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'nama_produk' => 'required',
            'umur_simpan' => 'required',
            'tanggal_ambil' => 'required',
            'jenis_pengiriman' => 'required',
            'status_produk' => 'required',
            'stok' => 'required',
            'lokasi_ambil' => 'required',
            'deskripsi' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }


        $produk = Produk::find($id);
        $produk->nama_produk = $request->nama_produk;
        $produk->tanggal_pengambilan = $request->tanggal_ambil;
        $produk->status = $request->status_produk;
        $produk->status_pengambilan = $request->jenis_pengiriman;
        $produk->lokasi_pengambilan = $request->lokasi_ambil;
        $produk->umur_simpan = $request->umur_simpan;
        $produk->deskripsi = $request->deskripsi;
        $produk->stok = $request->stok;

        if ($request->hasFile('foto_produk')) {
            // Delete existing file if any
            if ($produk->encrypted_filename) {
                Storage::delete('public/files/' . $produk->encrypted_filename);
            }

            $file = $request->file('foto_produk');
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

            // Store new file
            $file->storeAs('public/files', $encryptedFilename);

            $produk->original_filename = $originalFilename;
            $produk->encrypted_filename = $encryptedFilename;
        }

        $produk->save();
        Alert::success('Berhasil Diedit', 'Produk Berhasil Diedit!.');
        return redirect()->route('produk.edit', ['id' => $id]);


    }

    public function beliProdukView(string $id)
    {
        $transaksiuser = Transaksi::find($id);
        $alamat = Alamat::find($transaksiuser->id_alamat);
        $keranjangUser = Keranjang::with('user')->where('id_user', Auth::id())->first();
        $snapToken = $transaksiuser->snaptoken;
        return view('customer.pesanan.pembayaran', ['id' => $id], compact('snapToken', 'alamat', 'keranjangUser', 'transaksiuser'));
    }

    public function beliProduk(Request $request)
    {
        $transaksi = new Transaksi;
        $transaksi->kurir = $request->nama_kurir;
        $transaksi->harga_ongkir = $request->harga_ongkir;
        $transaksi->id_alamat = $request->id_alamat;
        $transaksi->total_harga = $request->total_harga;
        $transaksi->id_user = Auth::id();
        $transaksi->tipe_transaksi = 1;
        $transaksi->status = 0;
        $transaksi->resi = '';
        $transaksi->save();

        $keranjang = $request->keranjang;
        foreach ($keranjang as $keranjangs) {
            $id_keranjang = $keranjangs['id_keranjang'];
            $keranjang = Keranjang::with('varian')->find($keranjangs['id_keranjang']);
            $produk = Produk::find($keranjang->varian->id_produk);
            $produk->stok -= $keranjang->jumlah_produk;
            $produk->save();
            $keranjang->id_transaksi = $transaksi->id;
            $keranjang->save();
        }

        $keranjangUser = Keranjang::with('user')->where('id_user', Auth::id())->first();

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        if ($keranjangUser->user->telp_user != null) {
            $telp = $keranjangUser->user->telp_user;
        } else {
            $telp = 0;
        }
        $params = array(
            'transaction_details' => array(
                'order_id' => 'produk_' . $transaksi->id,
                'gross_amount' => $transaksi->total_harga,
            ),
            'customer_details' => array(
                'first_name' => $keranjangUser->user->username,
                'last_name' => '',
                'phone' => $telp,
            ),
        );
        $snapToken = \Midtrans\Snap::getSnapToken($params);
        $transaksi->snaptoken = $snapToken;
        $transaksi->save();

        Alert::success('Pesanan DIbuat', 'Pesanan Berhasil Dibuat!.');

        return redirect()->route('produk.beli.view', ['id' => $transaksi->id]);
    }

    public function riwayat()
    {
        $pageTitle = 'Riwayat Pembelian';
        $transaksi = Transaksi::where('id_user', Auth::id())->get();
        return view('customer.produk.riwayat', compact('pageTitle', 'transaksi'));

    }

    public function Terima(string $id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->status = 4;
        $transaksi->save();
        Alert::success('Barang Diterima!');
        return redirect()->route('produk.beli.view', ['id' => $id]);
    }

    public function ulasan(Request $request)
    {
        $id_varian = $request->id_varian;
        $id_transaksi = $request->id_transaksi;
        $rating = $request->rating;
        $review = $request->review;
        $files = $request->file('foto_produk');
        // dd($request->foto_produk[1]['foto_produk']);
        foreach ($id_transaksi as $index => $id_transaksis) {
            $ulasan = new Ulasan;
            $ulasan->id_varian = $id_varian[$index]['id_varian'];
            $ulasan->id_transaksi = $id_transaksis['id_transaksi'];
            $ulasan->review_produk = $review[$index]['review'];
            $ulasan->rating = $rating[$index]['rating'];

            // Mengambil foto produk sesuai index
            $file = $files[$index];
            if ($file) {
                // Delete existing file if any
                if ($ulasan->encrypted_filename) {
                    Storage::delete('public/files/' . $ulasan->encrypted_filename);
                }
                $originalFilename = $file->getClientOriginalName();
                $encryptedFilename = $file->hashName();

                // Store new file
                $file->storeAs('public/files', $encryptedFilename);
                // Menyimpan informasi file di Ulasan (jika diperlukan)
                $ulasan->original_filename = $originalFilename;
                $ulasan->encrypted_filename = $encryptedFilename;
            }

            $ulasan->save();
        }
        Alert::success('Ulasan Berhasil Ditambah!', 'Terima Kasih Telah Berbelanja');
        return redirect()->route('produk.beli.view', ['id' => $ulasan->id_transaksi]);
    }

    public function addResi(Request $request, string $id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->resi = $request->resi;
        $transaksi->status = 3;
        $transaksi->save();
        Alert::success('Berhasil Ditambah', 'Resi Berhasil Ditambah!.');
        return redirect()->route('transaksi.detail', ['id' => $transaksi->id]);
    }


    public function TransaksiEnd(string $id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->status = 4;
        $transaksi->save();
        Alert::success('Transaksi Selesai');
        return redirect()->route('transaksi.detail', ['id' => $transaksi->id]);
    }


    public function TransaksiCancel(string $id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->status = 5;
        $transaksi->save();
        Alert::success('Transaksi Dibatalkan');
        return redirect()->route('transaksi.detail', ['id' => $transaksi->id]);
    }
    public function TransaksiConfirm(string $id)
    {
        $transaksi = Transaksi::find($id);
        $transaksi->status = 2;
        $transaksi->save();
        Alert::success('Berhasil Diterima', 'Transaksi Diterima!.');
        return redirect()->route('transaksi.detail', ['id' => $transaksi->id]);

    }

    public function beliLangsung(Request $request, string $id)
    {
        $pageTitle = 'Pesanan Produk';
        $user = User::with('alamat')->whereHas('alamat')->find(Auth::id());
        $keranjangs = new Keranjang;
        $keranjangs->id_user = Auth::id();
        $keranjangs->id_varian = $id;
        $keranjangs->id_transaksi = null;
        $keranjangs->jumlah_produk = $request->quantityhid;
        $keranjangs->save();

        $keranjang = Keranjang::with('varian.produk')->where('id_user', auth()->id())->where('id_transaksi', null)->get();
        $alamatActive = null;
        if (isset($request->alamat)) {
            $alamatActive = Alamat::where('id_user', auth()->id())->find($request->alamat);
        }

        if (!$alamatActive) {
            $alamatActive = Alamat::where('id_user', auth()->id())->first();
        }

        $rajaongkirjne = (object) [
            'costs' => []
        ];

        $rajaongkirpos = (object) [
            'costs' => []
        ];

        $apikey = '99013c4e614eb8ca3125660bcddc9830';


        if ($alamatActive) {
            $response = Http::get("https://api.rajaongkir.com/starter/city?key=$apikey");
            if ($response->successful()) {
                $kota = $response->object()->rajaongkir->results;
                $selected_kota = null;
                foreach ($kota as $k) {
                    if (str_contains($alamatActive->kabupaten, 'KABUPATEN')) {
                        $kotaActive = str_replace('KABUPATEN ', '', $alamatActive->kabupaten);
                    } else if (str_contains($alamatActive->kabupaten, 'KOTA')) {
                        $kotaActive = str_replace('KOTA ', '', $alamatActive->kabupaten);
                    } else {
                        $kotaActive = $alamatActive->kabupaten;
                    }
                    if (strtolower($k->city_name) === strtolower($kotaActive)) {
                        $selected_kota = $k;
                    }
                }
                $response = Http::post('https://api.rajaongkir.com/starter/cost', [
                    'key' => $apikey,
                    'origin' => 444,
                    'destination' => $selected_kota->city_id,
                    'weight' => $keranjangs->jumlah_produk * 1000,
                    'courier' => 'jne',
                ]);

                $rajaongkirjne = $response->object()->rajaongkir->results[0];

                $response = Http::post('https://api.rajaongkir.com/starter/cost', [
                    'key' => $apikey,
                    'origin' => 444,
                    'destination' => $selected_kota->city_id,
                    'weight' => $keranjangs->jumlah_produk * 1000,
                    'courier' => 'pos',
                ]);

                $rajaongkirpos = $response->object()->rajaongkir->results[0];

            }
        }

        $pengiriman = null;
        if (isset($request->kurir) && isset($request->opsi_pengiriman)) {
            if ($request->kurir == 'jne') {
                $pengiriman = $rajaongkirjne->costs[$request->opsi_pengiriman];
                $pengiriman->opsi = 'JNE';
            } else {
                $pengiriman = $rajaongkirpos->costs[$request->opsi_pengiriman];
                $pengiriman->opsi = 'POS';
            }
        }

        return view('customer.pesanan.pesanan', compact('pageTitle', 'user', 'keranjang', 'alamatActive', 'rajaongkirjne', 'rajaongkirpos', 'pengiriman'));
    }
    public function pesananProduk(Request $request)
    {
        $pageTitle = 'Pesanan Produk';
        $user = User::with('alamat')->whereHas('alamat')->find(Auth::id());


        $keranjang = $request->keranjang;
        $value = $request->value;
        if (isset($request->keranjang) && isset($request->value)) {
            foreach ($keranjang as $index => $keranjangs) {
                $id_keranjang = $keranjangs['id'];
                $values = $value[$index]['jumlah_produk'];
                $qty = Keranjang::with('varian.produk')->find($id_keranjang);
                if ($values <= $qty->varian->produk->stok) {
                    $qty->jumlah_produk = $values;
                    $qty->save();
                } else {
                    return back()->with('alert', 'Stok tidak mencukupi.');
                }
            }

        }
        $keranjang = Keranjang::with('varian.produk')->where('id_user', auth()->id())->where('id_transaksi', null)->get();
        $TotalBerat = 0;
        foreach ($keranjang as $item) {
            $TotalBerat += ($item->varian->berat ?? 0) * $item->jumlah_produk;
        }


        $alamatActive = null;
        if (isset($request->alamat)) {
            $alamatActive = Alamat::where('id_user', auth()->id())->find($request->alamat);
        }

        if (!$alamatActive) {
            $alamatActive = Alamat::where('id_user', auth()->id())->first();
        }

        $rajaongkirjne = (object) [
            'costs' => []
        ];

        $rajaongkirpos = (object) [
            'costs' => []
        ];

        $apikey = '53f3c1f4874e8c95238533a4c5977f81';

        if ($alamatActive) {
            $response = Http::get("https://api.rajaongkir.com/starter/city?key=$apikey");
            if ($response->successful()) {
                $kota = $response->object()->rajaongkir->results;
                $selected_kota = null;
                foreach ($kota as $k) {
                    if (str_contains($alamatActive->kabupaten, 'KABUPATEN')) {
                        $kotaActive = str_replace('KABUPATEN ', '', $alamatActive->kabupaten);
                    } else if (str_contains($alamatActive->kabupaten, 'KOTA')) {
                        $kotaActive = str_replace('KOTA ', '', $alamatActive->kabupaten);
                    } else {
                        $kotaActive = $alamatActive->kabupaten;
                    }
                    if (strtolower($k->city_name) === strtolower($kotaActive)) {
                        $selected_kota = $k;
                    }
                }
                $response = Http::post('https://api.rajaongkir.com/starter/cost', [
                    'key' => $apikey,
                    'origin' => 444,
                    'destination' => $selected_kota->city_id,
                    'weight' => $TotalBerat * 1000,
                    'courier' => 'jne',
                ]);

                $rajaongkirjne = $response->object()->rajaongkir->results[0];

                $response = Http::post('https://api.rajaongkir.com/starter/cost', [
                    'key' => $apikey,
                    'origin' => 444,
                    'destination' => $selected_kota->city_id,
                    'weight' => $TotalBerat * 1000,
                    'courier' => 'pos',
                ]);

                $rajaongkirpos = $response->object()->rajaongkir->results[0];

            }
        }

        $pengiriman = null;
        if (isset($request->kurir) && isset($request->opsi_pengiriman)) {
            if ($request->kurir == 'jne') {
                $pengiriman = $rajaongkirjne->costs[$request->opsi_pengiriman];
                $pengiriman->opsi = 'JNE';
            } else {
                $pengiriman = $rajaongkirpos->costs[$request->opsi_pengiriman];
                $pengiriman->opsi = 'POS';
            }
        }

        // dd($rajaongkirpos);
        return view('customer.pesanan.pesanan', compact('pageTitle', 'user', 'keranjang', 'alamatActive', 'rajaongkirjne', 'rajaongkirpos', 'pengiriman'));
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deletedProduk = Produk::find($id);
        $deletedVarian = Varian::where('id_produk', $id);
        if ($deletedProduk) {
            if ($deletedProduk->encrypted_filename) {
                Storage::delete('public/files/' . $deletedProduk->encrypted_filename);
                $deletedVarian->delete();
                $deletedProduk->delete();
            }
        }
        // Update the properties of another Varian with the same $id_produk
        Alert::success('Berhasil Dihapus', 'Produk Berhasil Dihapus!.');
        return redirect()->route('produk.index');
    }
}

