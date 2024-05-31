<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Http\Requests\TopicRequest;
use App\Models\Topic;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    public function store(TopicRequest $request){
        $topicName = [
            'name' => $request->topic_name
        ];
        Topic::create($topicName);

        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $request->topic_name . '</span> konusu başarıyla eklendi</div>');
    }

    public function delete(Request $request){
        $request->validate([
           'topic_id' => 'required'
        ], [
            'topic_id.required' => 'Bir seçim yapın'
        ]);
        $topic = Topic::where('id',$request->topic_id)->first();
        $topic->delete();

        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $topic->name . '</span> konusu başarıyla silindi</div>');
    }
}
