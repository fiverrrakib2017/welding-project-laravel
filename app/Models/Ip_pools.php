<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ip_pools extends Model
{
    use HasFactory;
    public function router(){
        return $this->belongsTo(Router::class,'router_id');
    }
}
