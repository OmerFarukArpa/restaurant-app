<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\Reservation;
use Illuminate\Http\Request;

class ReservationController extends Controller
{
    public function show(){
        $reservations = Reservation::with(['user','reservationStatus'])
            ->orderBy('created_at','DESC')
            ->paginate(5);

        return view('admin.pages.reservation',compact('reservations'));
    }

    public function detail(Request $request){
        $reservation = Reservation::with(['user','reservationStatus'])->where('id',$request->id)->first();

        return response()->json($reservation);
    }

    public function invoiceEntry(Request $request){
        $request->validate([
            'amount' => 'required'
        ],[
            'amount.required' => 'Hesap alanı boş geçilemez'
        ]);
        $reservation = Reservation::with('user')->where('id',$request->reservation_id)->first();
        $reservation->pay_status = 1;
        $reservation->amount = $request->amount;
        $reservation->save();


        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $reservation->user->name . '</span> isimli kullanıcının hesap tutarı başarıyla girildi</div>');
    }

    public function reservationApproval(Request $request){
        $reservation = Reservation::where('id', $request->reservation_id)->with('user')->first();
        $reservation->reservation_status_id = 2;
        $reservation->save();

        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $reservation->user->name . '</span> isimli kullanıcının rezervasyonu ' .'<span class="fw-semibold text-danger">onaylandı<span/></div>');
    }

    public function reservationCancel(Request $request){
        $reservation = Reservation::where('id', $request->reservation_id)->with('user')->first();
        $reservation->reservation_status_id = 3;
        $reservation->save();

        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $reservation->user->name . '</span> isimli kullanıcının rezervasyonu ' . '<span class="fw-semibold text-danger">iptal edildi<span/></div>');
    }



}
