<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ledger extends Model
{
    use HasFactory;
    public function master_ledger(){
        return  $this->belongsTo(Master_Ledger::class);
    }
}
