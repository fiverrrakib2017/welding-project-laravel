<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_class_routine extends Model
{
    use HasFactory;
    public function class(){
        return $this->belongsTo(Student_class::class, 'class_id', 'id'); 
    }
    public function teacher(){
        return $this->belongsTo(Teacher::class, 'teacher_id', 'id'); 
    }
    public function subject(){
        return $this->belongsTo(Student_subject::class, 'subject_id', 'id'); 
    }
}
