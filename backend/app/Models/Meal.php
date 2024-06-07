<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    use HasFactory;

    protected $table = 'meals';

    protected $guarded = [];

    public function getCountry(){
        return $this->belongsTo(Country::class,'country_id');
    }

    public function getCategory(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
