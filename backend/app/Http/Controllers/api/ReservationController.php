<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReservationController extends Controller
{
    public function store(Request $request){
        $data =[
            'user_id' => $request->input('user_id'),
            'date' => $request->input('date'),
            'number_of_people' => $request->input('number_of_people')
        ];

        Reservation::create($data);
        return response()->json(['message' => 'success'])->setStatusCode(200);
    }

    public function getReservations(Request $request){
        $reservations = Reservation::where('user_id',$request->id)
            ->orderBy('created_at','DESC')
            ->get();

        return response()->json($reservations);
    }
}
