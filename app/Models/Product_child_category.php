<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product_child_category extends Model
{
    use HasFactory;
    protected $fillable=[
        'category_id',
        'sub_cat_id',
        'name',
    ];
    public function category(){
        return $this->belongsTo(Product_Category::class);
    }
    public function sub_category(){
        return $this->belongsTo(Product_sub_category::class, 'sub_cat_id');
    }
    
}
