<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Message;
use App\Models\Reservation;

class DashboardController extends Controller
{
    public function show(){
        $messages = Message::with('topic')->orderBy('created_at', 'desc')->take(5)->whereHas('user', function($query) {
            $query->whereNot('role_id'  , 1);
        })->get();
        $totalPrice = Reservation::pluck('amount')->sum();
        return view('admin.pages.index',compact('messages','totalPrice'));
    }
}
