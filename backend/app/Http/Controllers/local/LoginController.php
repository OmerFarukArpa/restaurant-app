<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(LoginRequest $request){
        $userName = $request->user_name;
        $password = $request->password;

        if(Auth::attempt(['user_name'=> $userName,'password' => $password])){
            return redirect()->route('index');
        }else{
            return redirect()->route('login_page')->withErrors(['message' => 'Bilgilerinizi kontrol edin']);
        }
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login_page');
    }
}
