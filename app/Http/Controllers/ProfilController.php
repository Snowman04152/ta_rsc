<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Alamat;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Hash;

class ProfilController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pageTitle = 'Profil User';
        $user = User::find(Auth::id());
        $alamat = Alamat::where('id_user',Auth::id())->get();
        return view('customer.profil.profil', compact('pageTitle', 'user','alamat'));
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
    public function store(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'label' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'nama_jalan' => 'required',
            'kodepos' => 'required',
            'penerima' => 'required',
            'telepon' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $alamat = new Alamat;
        $alamat->id_user = Auth::id();
        $alamat->label = $request->label;
        $alamat->kecamatan = $request->kecamatan;
        $alamat->kabupaten = $request->kabupaten;
        $alamat->provinsi = $request->provinsi;
        $alamat->nama_jalan = $request->nama_jalan;
        $alamat->kode_pos = $request->kodepos;
        $alamat->penerima = $request->penerima;
        $alamat->telepon = $request->telepon;
        $alamat->save();
        Alert::success('Berhasil Ditambah', 'Alamat Berhasil Ditambah!.');
        return redirect()->route('profil.index');
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
    public function editPassword(Request $request)
    {
        $userId = Auth::id();
        $userData = User::findOrFail($userId);
     
        $validator = Validator::make($request->all(), [
            'password_now' => [
                'required',
                function ($attribute, $value, $fail) use ($userData) {
                    if (!Hash::check($value, $userData->password)) {
                        return $fail(__('Password salah.'));
                    }
                },
            ],
            'password' => 'required|confirmed',
        ], [
            'password_now.required' => ':Attribute harus diisi.',
            'password_now.valid' => 'Password salah.',
            'password.confirmed' => 'Password tidak cocok dengan konfirmasi.',
            'password.required' => ':Attribute harus diisi.',
            'password_confirmation.required' => 'Konfirmasi password harus diisi.',
        ]);
    
        $validator->setAttributeNames([
            'password_now' => 'Password Saat Ini',
            'password' => 'Password Baru',
            'password_confirmation' => 'Konfirmasi Password Baru',
        ]);
    
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
    
    
        $userData->password = bcrypt($request->password);
        $userData->save();

        Alert::success('Berhasil Diubah', 'Sandi Berhasil DIubah!.');
        return redirect()->route('profil.index');
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
            'nama_lengkap' => 'required',
            'username' => 'required',
            'kelamin' => 'required',
            'tanggal' => 'required',
            'telp' => 'required',
            'email' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        
        $user = User::find($id);
        $user->nama_lengkap = $request->nama_lengkap;
        $user->username = $request->username;
        $user->jenis_kelamin = $request->kelamin;
        $user->telp_user = $request->telp;
        $user->email = $request->email;
        $user->tanggal_lahir = $request->tanggal;

        if ($request->hasFile('foto')) {

            if ($user->encrypted_filename) {
                Storage::delete('public/files/' . $user->encrypted_filename);
            }
            $file = $request->file('foto');
            $originalFilename = $file->getClientOriginalName();
            $encryptedFilename = $file->hashName();

            $file->storeAs('public/files', $encryptedFilename);

            $user->original_filename = $originalFilename;
            $user->encrypted_filename = $encryptedFilename;
        }

        $user->save();
        Alert::success('Berhasil Diedit', 'Profil Berhasil Diedit!.');
        return redirect()->route('profil.index');

    }
    public function updateAlamat(Request $request)
    {
        $messages = [
            'required' => ':Attribute harus diisi.',
        ];
        $validator = Validator::make($request->all(), [
            'label' => 'required',
            'provinsi' => 'required',
            'kabupaten' => 'required',
            'kecamatan' => 'required',
            'nama_jalan' => 'required',
            'kodepos' => 'required',
            'penerima' => 'required',
            'telepon' => 'required',
        ], $messages);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $alamat =  Alamat::find($request->id);
        $alamat->label = $request->label;
        $alamat->kecamatan = $request->kecamatan;
        $alamat->kabupaten = $request->kabupaten;
        $alamat->provinsi = $request->provinsi;
        $alamat->nama_jalan = $request->nama_jalan;
        $alamat->kode_pos = $request->kodepos;
        $alamat->penerima = $request->penerima;
        $alamat->telepon = $request->telepon;
        $alamat->save();

        Alert::success('Berhasil Diedit', 'Alamat Berhasil Diedit!.');
        return redirect()->route('profil.index');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $deletedAlamat = Alamat::find($id);
        if ($deletedAlamat) {
            $deletedAlamat->delete();
        }

        // Update the properties of another Varian with the same $id_produk
            return redirect()->route('profil.index');
    }
}
