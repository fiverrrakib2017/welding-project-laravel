<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_class extends Model
{
    use HasFactory;
    public function section(){
        return $this->belongsTo(Section::class,'section_id','id');
    }
    public function sections()
    {
        return $this->hasMany(Section::class, 'class_id');
    }
    public function subjects()
    {
        return $this->hasMany(Student_subject::class, 'class_id');
    }
}
