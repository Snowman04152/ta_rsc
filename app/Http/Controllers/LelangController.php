<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use App\Models\ProdukLelang;
use App\Models\PengingatLelang;
use App\Models\PenawaranLelang;
use App\Models\TransaksiLelang;
use App\Models\Transaksi;
use App\Models\Alamat;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;


use Storage;
use Validator;

class LelangController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Lelang';

        $lelang = ProdukLelang::all();
        return view('admin.lelang.lelangproduk', compact('pageTitle', 'lelang'));
    }

    public function data_lelang($id)
    {
        $userId = auth()->id();
        $penawaran = PenawaranLelang::with('user')->whereHas('user')->where('id_produk_lelang', $id)->get();
        $penawaranTertinggiMax = collect($penawaran)->max('penawaran_harga');
        // $penawaranUser = $penawaran->where('id_user', $userId);
        // $penawaranTertinggiUser = $penawaranUser->max('penawaran_harga');
        // $sortedPenawaran = $penawaran->sortByDesc('penawaran_harga');

        // $penawaranTertinggi = collect($penawaran)->max('penawaran_harga');
        // $dataTertinggi = $penawaran->where('penawaran_harga', $penawaranTertinggi)->first();
        // $dataTertinggiUser = $penawaranUser->sortByDesc('penawaran_harga')->first();
        // // dd($dataTertinggiUser);
        // $rankAll = $sortedPenawaran->pluck('penawaran_harga')->search($penawaranTertinggi);
        // $rank = $sortedPenawaran->pluck('id_user')->search($userId);
        // $penawaranTotal = count($penawaran);

        return response()->json([
            'penawaranTertinggiMax' => $penawaranTertinggiMax,
        ], 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pageTitle = 'Add Lelang';

        return view('admin.lelang.addlelang', compact('pageTitle'));
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
            'nama_lelang' => 'required',
            'umur_simpan' => 'required',
            'harga_mulai' => 'required',
            'kelipatan' => 'required',
            'time_start' => 'required',
            'berat' => 'required',
            'time_end' => 'required',
            'tanggal_ambil' => 'required',
            'tanggal_konfirmasi' => 'required',
            'lokasi_ambil' => 'required',
            'foto_lelang' => 'required',
            'deskripsi' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $file = $request->file('foto_lelang');
        if ($file != null) {
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();
            $file->store('public/files');
        }

        // ELOQUENT
        $lelang = new ProdukLelang;
        $lelang->nama_produk_lelang = $request->nama_lelang;
        $lelang->umur_simpan = $request->umur_simpan;
        $lelang->harga_lelang = $request->harga_mulai;
        $lelang->harga_lelang_process = $request->harga_mulai;
        $lelang->berat = $request->berat;
        $lelang->kelipatan = $request->kelipatan;
        $lelang->tanggal_mulai_lelang = $request->time_start;
        $lelang->tanggal_selesai_lelang = $request->time_end;
        $lelang->tanggal_konfirmasi_lelang = $request->tanggal_konfirmasi;
        $lelang->tanggal_pengambilan = $request->tanggal_ambil;
        $lelang->lokasi_pengambilan = $request->lokasi_ambil;
        $lelang->status_lelang = 0;
        $lelang->deskripsi = $request->deskripsi;

        if ($file != null) {
            $lelang->original_filename = $originalFilename;
            $lelang->encrypted_filename = $encryptedFilename;
        }

        $lelang->save();
        Alert::success('Berhasil Ditambah', 'Lelang Berhasil Ditambah!.');
        return redirect()->route('lelang.index');
    }



    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $pageTitle = 'Detail Lelang';
        $lelang = ProdukLelang::find($id);
        $penawaran = PenawaranLelang::with('user')->whereHas('user')->where('id_produk_lelang', $id)->get();
        $pengingat = PengingatLelang::where('id_produk_lelang', $id)->with('user')->whereHas('user')->get();
        return view('admin.lelang.detaillelang', compact('pageTitle', 'lelang', 'pengingat', 'penawaran'));
    }

    public function lelangShow()
    {
        $pageTitle = 'Lelang';
        $lelang = ProdukLelang::all();
        $pengingat = PengingatLelang::where('id_user', Auth::id())->get();
        return view('customer.lelang.lelang', compact('pageTitle', 'lelang', 'pengingat'));
    }

    public function lelangDetail(string $id)
    {
        $pageTitle = 'Detail Lelang';
        $user = User::find(Auth::id());
        $lelang = ProdukLelang::find($id);
        $penawaran = PenawaranLelang::with('user')->whereHas('user')->where('id_produk_lelang', $id)->get();
        $pengingat = PengingatLelang::where('id_produk_lelang', $id)->where('id_user', Auth::id())->first();
        return view('customer.lelang.detaillelang', compact('pageTitle', 'lelang', 'pengingat', 'penawaran', 'user'));
    }

    public function lelangStart(string $id)
    {
        $lelang = ProdukLelang::find($id);
        $lelang->status_lelang = 1;
        $lelang->save();
        Alert::success('Lelang Dibuka!');
        return redirect()->route('lelang.show', ['lelang' => $id]);
    }

    public function lelangEnd(string $id)
    {
        $lelang = ProdukLelang::find($id);
        $lelang->status_lelang = 2;
        $lelang->save();
        Alert::success('Lelang Ditutup');
        return redirect()->route('lelang.show', ['lelang' => $id]);
    }

    public function pesananLelang(Request $request, string $id)
    {
        $pageTitle = 'Pesanan Lelang';
        $user = User::with('alamat')->whereHas('alamat')->find(Auth::id());
        $penawaran = PenawaranLelang::with('produk_lelang')->whereHas('produk_lelang')->find($id);
        
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
                    'weight' => $penawaran->produk_lelang->berat * 1000,
                    'courier' => 'jne',
                ]);
                

                $rajaongkirjne = $response->object()->rajaongkir->results[0];

                $response = Http::post('https://api.rajaongkir.com/starter/cost', [
                    'key' => $apikey,
                    'origin' => 444,
                    'destination' => $selected_kota->city_id,
                    'weight' => $penawaran->produk_lelang->berat * 1000,
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

        // Alert::success('Berhasil Dibuat', 'Pesanan Berhasil Dibuat!.');
        // dd($rajaongkirpos);
        return view('customer.pesanan.pesananlelang', compact('id', 'pageTitle', 'user', 'penawaran', 'alamatActive', 'rajaongkirjne', 'rajaongkirpos', 'pengiriman'));
    }

    public function checkoutLelangView(string $id)
    {
        $transaksilelang = TransaksiLelang::find($id);
        $penawaran = PenawaranLelang::with(['produk_lelang', 'user'])->find($transaksilelang->id_penawaran);
        $alamat = Alamat::find($transaksilelang->id_alamat);
        $snapToken = TransaksiLelang::find($transaksilelang->id_penawaran)->value('snaptoken');

        return view('customer.pesanan.pembayaranlelang', ['id' => $id], compact('snapToken', 'alamat', 'penawaran', 'transaksilelang'));
    }

    public function checkoutLelang(Request $request, string $id)
    {
        $penawaran = PenawaranLelang::with(['produk_lelang', 'user'])->find($id);
        $penawaran->status_konfirmasi = 2;
        $penawaran->save();
        if (isset($request)) {
            $transaksilelang = new TransaksiLelang;
            $transaksilelang->kurir = $request->nama_kurir;
            $transaksilelang->harga_ongkir = $request->harga_ongkir;
            $transaksilelang->id_penawaran = $id;
            $transaksilelang->tipe_transaksi = 2;
            $transaksilelang->id_alamat = $request->id_alamat;
            $transaksilelang->total_harga = $request->total_harga;
            $transaksilelang->status = 0;
            $transaksilelang->save();
        }

        $alamat = Alamat::find($request->id_alamat);

        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = false;
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = true;
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = true;

        if ($penawaran->user->telp_user != null) {
            $telp = $penawaran->user->telp_user;
        } else {
            $telp = 0;
        }

        if (isset($request)) {
            $params = array(
                'transaction_details' => array(
                    'order_id' => 'lelang_' . $transaksilelang->id,
                    'gross_amount' => $transaksilelang->total_harga,
                ),
                'customer_details' => array(
                    'first_name' => $penawaran->user->username,
                    'last_name' => '',
                    'phone' => $telp,
                ),
            );
            $snapToken = \Midtrans\Snap::getSnapToken($params);
            $transaksilelang = TransaksiLelang::find($transaksilelang->id);
            $transaksilelang->snaptoken = $snapToken;
            $transaksilelang->save();

        } else {
            $snapToken = TransaksiLelang::where('id_penawaran', $penawaran->id)->value('snaptoken');
        }

        Alert::success('Berhasil Dibuat', 'Pesanan Berhasil Dibuat!.');


        return redirect()->route('lelang.checkout.view', ['id' => $id]);



    }
    public function callBack(Request $request)
    {

        $server_key = config('midtrans.server_key');
        $hashed = hash("sha512", $request->order_id . $request->status_code . $request->gross_amount . $server_key);
        if ($hashed == $request->signature_key) {
            $type = explode('_', $request->order_id)[0];
            $order_id = explode('_', $request->order_id)[1];
            if ($request->transaction_status == 'capture') {
                if ($type == 'lelang') {
                    $transaksilelang = TransaksiLelang::find($order_id);
                    if ($transaksilelang->kurir = 'AMBIL_DITEMPAT') {
                        $transaksilelang->status = 2;
                    } else {
                        $transaksilelang->status = 3;
                    }
                    $transaksilelang->save();
                    $penawaran = PenawaranLelang::find($transaksilelang->id_penawaran);
                    $penawaran->status_konfirmasi = 3;
                    $penawaran->save();
                    return response()->json("OK", 200);
                } else {
                    $transaksi = Transaksi::find($order_id);
                    $transaksi->status = 1;
                    $transaksi->save();
                    return response()->json("OK", 200);
                    // return redirect()->route('produk.beli.view', ['id' => $transaksi->id]);           
                }
            }
        }

    }

    public function lelangTerima(string $id)
    {
        $transaksilelang = TransaksiLelang::find($id);
        $transaksilelang->status = 4;
        $transaksilelang->save();
        Alert::success('Pesanan Selesai');
        return redirect()->route('lelang.checkout.view', ['id' => $id]);
    }

    public function riwayatLelang()
    {
        $user = User::find(Auth::id());
        $pageTitle = 'Penawaran Lelang';
        $penawaran = PenawaranLelang::with('produk_lelang')->whereHas('produk_lelang')->where('id_user', Auth::id())->get();
        $lelang = ProdukLelang::all();
        return view('customer.lelang.riwayatlelang', compact('pageTitle', 'penawaran', 'lelang', 'user'));

    }

    public function riwayatlelangConfirm(string $id)
    {
        $penawaran = PenawaranLelang::find($id);
        $penawaran->status_konfirmasi = 1;
        $penawaran->save();
        Alert::success('Berhasil Konfirmasi');
        return redirect()->route('lelang.riwayat');
    }

    public function addResi(Request $request, string $id)
    {
        $transaksi = TransaksiLelang::find($id);
        $transaksi->resi = $request->resi;
        $transaksi->status = 3;
        $transaksi->save();
        Alert::success('Berhasil Ditambahkan', 'Resi Berhasil Ditambah!');
        return redirect()->route('transaksi.lelang.detail', ['id' => $transaksi->id]);
    }


    public function TransaksiEnd(string $id)
    {
        $transaksi = TransaksiLelang::find($id);
        $transaksi->status = 4;
        $transaksi->save();
        Alert::success('Transaksi Selesai');
        return redirect()->route('transaksi.lelang.detail', ['id' => $transaksi->id]);
    }


    public function TransaksiCancel(string $id)
    {
        $transaksi = TransaksiLelang::find($id);
        $transaksi->status = 5;
        $transaksi->save();
        return redirect()->route('transaksi.lelang.detail', ['id' => $transaksi->id]);
    }
    public function TransaksiConfirm(string $id)
    {
        $transaksi = TransaksiLelang::find($id);
        $transaksi->status = 2;
        $transaksi->save();
        Alert::success('Berhasil Konfirmasi');
        return redirect()->route('transaksi.lelang.detail', ['id' => $transaksi->id]);

    }

    // public function lelangBayar(soal)

    public function lelangConfirm(string $id, string $id_lelang)
    {
        $penawaran = PenawaranLelang::find($id);
        $penawaran->status_konfirmasi = 1;
        $penawaran->save();
        Alert::success('Berhasil Konfirmasi');
        return redirect()->route('lelang.detail', ['id' => $id_lelang]);
    }
    public function riwayatlelangCancel(string $id, string $id_lelang)
    {
        $user = User::find(Auth::id());
        $user->status = 0;
        $user->save();

        $penawaran = PenawaranLelang::find($id);
        $penawaran->status_tawaran = 0;
        $penawaran->save();
        Alert::success('Berhasil Dibatalkan!');
        return redirect()->route('lelang.riwayat');
    }
    public function lelangCancel(string $id, string $id_lelang)
    {
        $user = User::find(Auth::id());
        $user->status = 0;
        $user->save();

        // $lelang = ProdukLelang::find($id_lelang);

        // $transaksi_lelang = new TransaksiLelang;
        // $transaksi_lelang->tanggal_pesan = $lelang->tanggal_konfirmasi_lelang;
        // $transaksi_lelang->id_penawaran = $penawaran->id;
        // $transaksi_lelang->harga_final = $penawaran->penawaran_harga;
        // $transaksi_lelang->status = 0;
        // $transaksi_lelang->save();
        $penawaran = PenawaranLelang::find($id);
        $penawaran->status_tawaran = 0;
        $penawaran->save();
        Alert::success('Berhasil Dibatalkan');
        return redirect()->route('lelang.detail', ['id' => $id_lelang]);
    }

    public function addPenawaran(string $id, Request $request)
    {
        $lelang = ProdukLelang::find($id);
        $penawaran = new PenawaranLelang;
        $penawaran->id_produk_lelang = $id;
        $penawaran->id_user = Auth::id();
        $penawaran->status_tawaran = 1;
        $penawaran->status_konfirmasi = 0;
        $penawaran->penawaran_harga = $request->qty_lelang;
        $penawaran->tanggal_konfirmasi_lelang = $lelang->tanggal_konfirmasi_lelang;
        $penawaran->save();
        $lelang->harga_lelang_process = $request->qty_lelang;
        $lelang->save();
        Alert::success('Penawaran ditambahkan');
        return redirect()->route('lelang.detail', ['id' => $id]);

    }

    public function addPengingat(string $id_produk_lelang)
    {
        $check = User::find(Auth::id());
        if ($check->telp_user == null) {
            return redirect()->back()->with('error', 'Nomor telepon harus diisi sebelum melanjutkan.');

        } else {
            $pengingat = new PengingatLelang;
            $pengingat->id_produk_lelang = $id_produk_lelang;
            $pengingat->id_user = Auth::id();
            $pengingat->status = 1;
            $pengingat->save();
            Alert::success('Berhasil Ditambahkan');
            return redirect()->route('lelangprod');
        }
    }

    public function addPengingatDetail(string $id_produk_lelang)
    {
        $check = User::find(Auth::id());
        if ($check->telp_user == null) {
            return redirect()->back()->with('error', 'Nomor telepon harus diisi sebelum melanjutkan.');

        } else {
            $pengingat = new PengingatLelang;
            $pengingat->id_produk_lelang = $id_produk_lelang;
            $pengingat->id_user = Auth::id();
            $pengingat->status = 1;
            $pengingat->save();
            Alert::success('Berhasil Ditambahkan');
            return redirect()->route('lelang.detail', ['id' => $id_produk_lelang]);
        }
    }


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $pageTitle = 'Edit Lelang';
        $lelang = ProdukLelang::find($id);

        return view('admin.lelang.editlelang', compact('pageTitle', 'lelang'));
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka',
            'date' => 'Isi :attribute dengan tanggal',
            'after' => 'Waktu Selesai Harus Setelah Waktu Mulai',

        ];
        $validator = Validator::make($request->all(), [
            'nama_lelang' => 'required',
            'umur_simpan' => 'required',
            'harga_mulai' => 'required',
            'kelipatan' => 'required',
            'time_start' => 'required',
            'time_end' => 'required',
            'berat' => 'required',
            'tanggal_ambil' => 'required',
            'tanggal_konfirmasi' => 'required',
            'lokasi_ambil' => 'required',
            'deskripsi' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $lelang = ProdukLelang::find($id);
        $lelang->nama_produk_lelang = $request->nama_lelang;
        $lelang->umur_simpan = $request->umur_simpan;
        $lelang->harga_lelang = $request->harga_mulai;
        $lelang->harga_lelang_process = $request->harga_mulai;
        $lelang->kelipatan = $request->kelipatan;
        $lelang->berat = $request->berat;
        $lelang->tanggal_mulai_lelang = $request->time_start;
        $lelang->tanggal_selesai_lelang = $request->time_end;
        $lelang->tanggal_konfirmasi_lelang = $request->tanggal_konfirmasi;
        $lelang->tanggal_pengambilan = $request->tanggal_ambil;
        $lelang->lokasi_pengambilan = $request->lokasi_ambil;
        $lelang->deskripsi = $request->deskripsi;

        if ($request->hasFile('foto_lelang')) {
            // Delete existing file if any
            if ($lelang->encrypted_filename) {
                Storage::delete('public/files/' . $lelang->encrypted_filename);
            }

            $file = $request->file('foto_lelang');
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

            // Store new file
            $file->storeAs('public/files', $encryptedFilename);

            $lelang->original_filename = $originalFilename;
            $lelang->encrypted_filename = $encryptedFilename;
        }

        $lelang->save();
        Alert::success('Berhasil Diedit', 'Lelang Berhasil Diedit!.');
        return redirect()->route('lelang.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function nonAktif(string $id){

        $lelang = ProdukLelang::find($id);
        $lelang->status_lelang = 3 ;
        $lelang->save();
        return redirect()->route('lelang.index');
    }

    public function destroy(string $id)
    {

        $deletedProdukLelang = ProdukLelang::find($id);
        if ($deletedProdukLelang) {
            if ($deletedProdukLelang->encrypted_filename) {
                Storage::delete('public/files/' . $deletedProdukLelang->encrypted_filename);
                $deletedProdukLelang->delete();
            }
        }
        // Update the properties of another Varian with the same $id_produk
        return redirect()->route('lelang.index');
    }
}
