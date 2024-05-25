<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function getTopics(){
        $topics = Topic::all();
        return response()->json($topics);
    }
}
