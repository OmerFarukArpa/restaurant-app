<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Meal;
use Illuminate\Http\Request;

class MealController extends Controller
{
    public function getMeals(Request $request){
        $meals = Meal::where('category_id',$request->id)->get();

        return response()->json($meals);
    }
    public function getMeal(Request $request){
        $meals = Meal::where('id',$request->id)->get();

        return response()->json($meals);
    }
}
