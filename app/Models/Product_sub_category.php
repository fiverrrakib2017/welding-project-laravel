<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_sub_category extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_id',
        'name',
    ];
    public function category(){
        return $this->belongsTo(Product_Category::class,'category_id');
    }
    public function child_category(){
        return $this->hasMany(Product_child_category::class, 'sub_cat_id');
    }
}
