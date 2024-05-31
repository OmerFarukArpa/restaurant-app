<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Http\Requests\SettingRequest;
use App\Models\Category;
use App\Models\Setting;
use App\Models\Topic;
use Illuminate\Support\Str;

class SettingController extends Controller
{
    public function show(){
        $setting = Setting::with('user')->first();
        $categories = Category::orderBy('created_at','desc')->get();
        $topics = Topic::orderBy('created_at','desc')->get();
        return view('admin.pages.settings',compact('setting','categories','topics'));
    }

    public function update(SettingRequest $request){
        $setting = Setting::with('user')->first();
        $data = $request->except('_token');
        $setting->company_name = $data['company_name'];
        $setting->user->name = $data['name'];
        $setting->user->email = $data['email'];
        $setting->info = $data['info'];



        if($request->hasFile('image')){
            $imgFile = $request->file('image');
            $originalName = $imgFile->getClientOriginalName();
            $originalExtension = $imgFile->getClientOriginalExtension();
            $explodeName = explode('.',$originalName)[0];
            $fileName = Str::slug($explodeName) . '.' . $originalExtension;
            $publicPath = 'storage/settings/';
            $data['image'] = $publicPath . $fileName;
            $setting['image'] = $data['image'];
            $imgFile->storeAs('public/settings',$fileName);
        }
        $setting->user->save();
        $setting->save();


        return redirect()->back()->with('message', 'Ayarlar başarıyla güncellendi.');
    }
}
