<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_log extends Model
{
    use HasFactory;
    public function user(){
        return $this->belongsTo(Admin::class,'user_id','id');
    }
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function course(){
        return $this->belongsTo(Course::class,'course_id','id');
    }
}
