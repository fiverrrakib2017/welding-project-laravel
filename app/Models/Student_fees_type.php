<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_fees_type extends Model
{
    use HasFactory;
    public function class(){
        return $this->belongsTo(Student_class::class,'class_id','id');
    }

}
