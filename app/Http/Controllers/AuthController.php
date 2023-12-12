<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Admin;

class AuthController extends Controller
{
    public function login()
    {
        return view('admin.loginadmin');
    }
    public function loginCustomer()
    {
        return view('customer.login');
    }

    public function processlogin(Request $request){
        // $email = Admin::where('email', $request->email)->first();
        // var_dump($email);
        // return;
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        
        if (Auth::guard('admin')->attempt($credentials)) {
            $request->session()->regenerate();
            $pageTitle = 'Dashboard';
            
            return redirect()->intended('dashboardadmin')->with( ['pageTitle' => $pageTitle] );
        }
        
        if (Auth::guard('web')->attempt($credentials)) {
            $request->session()->regenerate();
            $pageTitle = 'Dashboard';
            return redirect()->intended('dashboard')->with( ['pageTitle' => $pageTitle] );
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
            'password' => 'The provided credentials do not match our records.'
        ])->onlyInput('email');
    }
    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/loginadmin');
    }
    public function logoutuser(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/loginuser');
    }
}
?>