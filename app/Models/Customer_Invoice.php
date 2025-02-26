<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer_Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['customer_id', 'total_amount', 'paid_amount', 'due_amount'];
    public function customer()
    {
        return $this->belongsTo(Customer::class ,'customer_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(Customer_Invoice_Details::class,'invoice_id','id');
    }
}
