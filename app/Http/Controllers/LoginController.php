<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function loginView(){
        return $this->view('auth.login');
    }

    public function login(Request $request){
        $request->validate([
            'email' => ['required'],
            'password' => ['required']
        ]);

        $field = filter_var($request->email, FILTER_VALIDATE_EMAIL) ? 'email' : 'nip';
        $email = $request->email;
        $password = $request->password;

        try{
            if(Auth::attempt([
                $field => $email,
                'password' => $password
            ])){
                $request->session()->regenerate();
    
                return redirect()->route('dashboard');
            }
        }catch(Exception $e){
            dd($e->getMessage());
        }
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
