<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_name' => 'required|unique:users',
            'email' => 'required|email|unique:users',
            'name'=>'required',
            'password' => 'required|min:8|regex:/^.*(?=.{7,})(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/',
        ], [
            'user_name.required' => 'Username alanı zorunludur.',
            'user_name.unique' => 'Kullanıcı adı zaten kullanılmakta',
            'email.email' => 'Email formatında bir değer giriniz',
            'email.required' => 'Email alanı zorunludur.',
            'email.unique' => 'Bu email zaten kullanılmakta',
            'name.required' => 'Ad alanı zorunludur.',
            'password.required' => 'Şifre alanı zorunludur.',
            'password.min' => 'Şifre alanı en az 8 karaktererden oluşmaldıır',
            'password.regex' => 'Şifreniz bir büyük bir küçük harf ve ifade içermelidir'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $user = new User();

        $user->name = $request->input('name');
        $user->user_name = $request->input('user_name');
        $user->email = $request->input('email');
        $user->password = Hash::make($request->input('password'));
        $user->save();

        $token = $user->createToken('login');
        return response()->json(['message' => 'User registered successfully', 'user' => $user, 'token' => $token->plainTextToken], 201);
    }
    public function login(Request $request)
    {

        $login = $request->input('login');
        $password = $request->input('password');

        if (Auth::attempt(['email' => $login, 'password' => $password]) || Auth::attempt(['user_name' => $login, 'password' => $password])) {
            $user = Auth::user();
            $token = $user->createToken('login');

            return response()->json(['user' => $user, 'token' => $token->plainTextToken])->setStatusCode(200);
        } else {
            return response()->json(['errors' => ['Email ve şifre uyuşmuyor']])->setStatusCode(401);
        }
    }
}
