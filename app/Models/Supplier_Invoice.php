<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier_Invoice extends Model
{
    use HasFactory;
    protected $fillable = ['supplier_id', 'total_amount', 'paid_amount', 'due_amount'];
    public function supplier()
    {
        return $this->belongsTo(Supplier::class ,'supplier_id', 'id');
    }
    public function items()
    {
        return $this->hasMany(Supplier_Invoice_Details::class,'invoice_id','id');
    }
}
