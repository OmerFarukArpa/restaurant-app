<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show(){
        $users = User::with('reservations')
            ->whereNot('role_id',1)
            ->orderBy('created_at','DESC')
            ->paginate(5);


        return view('admin.pages.users',compact('users'));
    }

    public function changeStatus(Request $request){
        $user = User::where('id',$request->id)->first();
        $user->status = !$user->status;
        $user->save();

        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $user->name . '</span> isimli kullanıcının durumu başarıyla değiştirildi</div>');
    }

    public function detail(Request $request){
        $user = User::with('reservations')->where('id',$request->id)->first();

        return response()->json($user);
    }
}
