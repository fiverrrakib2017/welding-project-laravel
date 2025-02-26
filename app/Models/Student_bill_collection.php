<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_bill_collection extends Model
{
    use HasFactory;
    public function student(){
        return $this->belongsTo(Student::class);
    }
    public function items(){
        return $this->hasMany(Student_bill_collection_item::class, 'bill_collection_id', 'id');
    }
}
