<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Account_transaction extends Model
{
    use HasFactory;
    public function ledger()
    {
        return $this->belongsTo(Ledger::class, 'ledger_id');
    }
    public function sub_ledger(){
        return $this->belongsTo(Sub_ledger::class, 'sub_ledger_id');
    }
    public function master_ledger(){
        return $this->belongsTo(Master_Ledger::class, 'master_ledger_id');
    }
}
