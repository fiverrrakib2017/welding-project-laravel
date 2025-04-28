<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'nid_or_passport',
        'mobile_number',
        'permanent_address',
        'present_address',
        'course_id',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
