<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    public function currentClass()
    {
        return $this->belongsTo(Student_class::class, 'current_class');
    }
    public function section(){
        return $this->belongsTo(Section::class, 'section_id','id');
    }
    public function previousClass()
    {
        return $this->belongsTo(Student_class::class, 'previous_class');
    }
}
