<?php

namespace App\Http\Controllers\local;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CategoryController extends Controller
{

    public function store(CategoryRequest $request){
        $data = [
            'name' => $request->category_name
        ];

        if($request->hasFile('category_image')){
            $imgFile = $request->file('category_image');
            $originalName = $imgFile->getClientOriginalName();
            $originalExtension = $imgFile->getClientOriginalExtension();
            $explodeName = explode('.',$originalName)[0];

            $fileName = Str::slug($explodeName) . '.' . $originalExtension;

            $publicPath = 'storage/categories/';
            $data['image'] = $publicPath . $fileName;
            $imgFile->storeAs('public/categories',$fileName);
        }


        Category::create($data);
        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $request->category_name . '</span> kategorisi başarıyla eklendi</div>');

    }

    public function delete(Request $request){
        $request->validate([
            'category_id' => 'required'
        ], [
            'category_id.required' => 'Bir seçim yapın'
        ]);
        $category = Category::where('id',$request->category_id)->first();
        $category->delete();

        return redirect()->back()->with('message', '<div><span class="fw-semibold text-danger">' . $category->name . '</span> kategorisi başarıyla silindi</div>');
    }

}
