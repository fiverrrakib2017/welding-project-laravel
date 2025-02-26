<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student_bill_collection_item extends Model
{
    use HasFactory;
    public function fees_type(){
        return $this->belongsTo(Student_fees_type::class, 'fees_type_id', 'id');
    }
}
