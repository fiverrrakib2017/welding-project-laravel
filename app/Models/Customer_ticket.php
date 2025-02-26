<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_ticket extends Model
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
}
