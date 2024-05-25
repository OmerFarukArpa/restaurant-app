<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class MessageController extends Controller
{
    public function send(Request $request){
        $validator = Validator::make($request->all(), [
            'topic_id' => 'required',
            'message' => 'required',
        ], [
            'topic_id.required' => 'Konu başlığı alanı zorunludur.',
            'message.required' => 'Mesaj alanı zorunludur.',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }

        $data=[
            'user_id' => $request->input('user_id'),
            'topic_id' => $request->input('topic_id'),
            'message' => $request->input('message')
        ];

        Message::create($data);
        return response()->json(['message' => 'success'])->setStatusCode(200);

    }
}
