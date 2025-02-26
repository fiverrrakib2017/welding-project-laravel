<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Section extends Model
{
    use HasFactory;
    public function studentClass()
    {
        return $this->belongsTo(student_class::class, 'class_id');
    }
}
