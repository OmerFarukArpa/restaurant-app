<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function getCompanyInfo(){
        $companyInfo = Setting::first(['company_name','info','image']);

        return response()->json($companyInfo);
    }
    public function getCompanyImage(){
        $companyImage = Setting::first(['image']);

        return response()->json($companyImage);
    }
}
