<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    public function customer(){
        return $this->belongsTo(Customer::class);
    }
    public function assign(){
        return $this->belongsTo(Ticket_assign::class,'ticket_assign_id','id');
    }
    public function complain_type(){
        return $this->belongsTo(Ticket_complain_type::class,'ticket_complain_id','id');
    }
    public function pop(){
        return $this->belongsTo(Pop_branch::class,'pop_id','id');
    }
    public function area(){
        return $this->belongsTo(Pop_area::class,'area_id','id');
    }
}
