<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Http\Requests\MealRequest;
use App\Models\Category;
use App\Models\Meal;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class MealController extends Controller
{
    public function show($id){
        $categoryId = $id;
        $category = Category::where('id',$categoryId)->first();
        $meals = Meal::where('category_id',$categoryId)->with('getCountry')->paginate(5);
        return view('admin.pages.foods',compact('category','meals'));
    }

    public function store(MealRequest $request){

        if($request->hasFile('image')){
            $imgFile = $request->file('image');
            $originalName = $imgFile->getClientOriginalName();
            $originalExtension = $imgFile->getClientOriginalExtension();
            $explodeName = explode('.',$originalName)[0];

            $fileName = Str::slug($explodeName) . '.' . $originalExtension;

            $publicPath = 'storage/meals/';

            $data = $request->except('_token');
            $data['image'] = $publicPath . $fileName;
            $data['status'] = isset($data['status']) ? 0 : 1;
            $imgFile->storeAs('public/meals',$fileName);
        }else{
            return redirect()->withErrors(['image'=>'Bu alan zorunludur']);
        }

        Meal::create($data);

        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $request->name . '</span> isimli gıda başarıyla eklendi</div>');

    }

    public function changeStatus(Request $request){
        $food = Meal::where('id',$request->id)->first();
        $food->status = !$food->status ;
        $status = $food->status ? 'Aktif' : 'Pasif';
        $food->save();
        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $food->name . '</span> isimli gıdasının durumu başarıyla ' . '<span class="fw-semibold text-danger">' . $status .'</span> hale getitildi</div>');
    }

    public function edit(Request $request){
        $meal = Meal::with(['getCountry'])->where('id',$request->id)->first();
        return response()->json($meal);
    }

    public function update(MealRequest $request){
        $meal = Meal::where('id',$request->id)->first();

        $meal->name = $request->name;
        $meal->description = $request->description;
        $meal->price = $request->price;
        $meal->status = isset($request->status) ? 0 : 1;

        if($request->hasFile('image')){
            $imgFile = $request->file('image');
            $originalName = $imgFile->getClientOriginalName();
            $originalExtension = $imgFile->getClientOriginalExtension();
            $explodeName = explode('.',$originalName)[0];
            $fileName = Str::slug($explodeName) . '.' . $originalExtension;
            $publicPath = 'storage/meals/';
            $meal['image'] = $publicPath . $fileName;
            $imgFile->storeAs('public/meals',$fileName);
        }
        $meal->save();

        return redirect()->back()->with('message', '<div>Gıda başarıyla güncellendi</div>');
    }

    public function detail(Request $request){
        $meal = Meal::with(['getCountry','getCategory'])->where('id',$request->id)->first();

        return response()->json($meal);
    }

    public function delete(Request $request){
        $meal = Meal::where('id',$request->id)->first();
        $meal->delete();
        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $meal->name . '</span> isimli gıda başarıyla silindi</div>');
    }

}
