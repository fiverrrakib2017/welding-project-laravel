<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_attendance extends Model
{
    use HasFactory;
    protected $table = 'student_attendances';
    protected $guarded = [];
    public function student(){
        return $this->belongsTo(Student::class,'student_id', 'id');
    }
    
}
