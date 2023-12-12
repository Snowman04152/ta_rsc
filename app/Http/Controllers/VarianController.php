<?php

namespace App\Http\Controllers;

use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Varian;
use Illuminate\Http\Request;
use Validator;

class VarianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {

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
            'harga_produk' => 'required',
            'berat' => 'required',
            'id_produk' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $varian = new Varian;
        $varian->id_produk = $request->id_produk;
        $varian->harga_produk = $request->harga_produk;
        $varian->berat = $request->berat;
        $varian->save();
        Alert::success('Berhasil Ditambahkan', 'Varian Berhasil Ditambah!.');
        return redirect()->route('produk.edit', ['id' => $request->id_produk]);
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
        $messages = [
            'required' => ':Attribute harus diisi.',
            'numeric' => 'Isi :attribute dengan angka'
        ];
        $validator = Validator::make($request->all(), [

            'harga_produk' => 'required',
            'berat' => 'required',
            'id_produk' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        // ELOQUENT
        $varian = Varian::find($id);
        $varian->id_produk = $request->id_produk;
        $varian->harga_produk = $request->harga_produk;
        $varian->berat = $request->berat;
        $varian->save();
        Alert::success('Berhasil Diedit', 'Varian Berhasil Diedit!.');
        return redirect()->route('produk.edit', ['id' => $request->id_produk]);
    }
    
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id, string $id_produk)
    {
        confirmDelete('Hapus Varian', 'Apakah Anda Ingin Menghapus Varian?');
        $deletedVarian = Varian::find($id);
        if ($deletedVarian) {
            $deletedVarian->delete();
        }

        return response()->json(['success' => true]);
        // return redirect()->route('produk.edit', ['id' => $id_produk]);
    }
}
