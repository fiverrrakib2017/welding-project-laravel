<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_exam_result extends Model
{
    use HasFactory;
    public function exam(){
        return $this->belongsTo(Student_exam::class,'exam_id','id');
    }
    public function student(){
        return $this->belongsTo(Student::class,'student_id','id');
    }
    public function subject(){
        return $this->belongsTo(Student_subject::class,'subject_id','id');
    }
    public function class(){
        return $this->belongsTo(Student_class::class,'class_id','id');
    }
    public function section(){
        return $this->belongsTo(Section::class,'section_id','id');
    }
    

}
