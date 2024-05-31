<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    public function show() {
        $messages = Message::with(['user', 'topic'])
            ->whereHas('user', function($query) {
                $query->whereNot('role_id', 1);
            })
            ->orderBy('read_at', 'ASC')
            ->orderBy('created_at', 'DESC')
            ->paginate(5);

        return view('admin.pages.messages', compact('messages'));
    }


    public function detail(Request $request){
        $message = Message::with(['user','topic'])->where('id',$request->id)->first();

        if(!$message->read_at){
            $message->read_at = 1;
            $message->save();
        }
        return response()->json($message);
    }
}
