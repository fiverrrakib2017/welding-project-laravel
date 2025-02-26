<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher_leave extends Model
{
    use HasFactory;
    public function teacher(){
        return $this->belongsTo(Teacher::class,'teacher_id','id');
    }
}
