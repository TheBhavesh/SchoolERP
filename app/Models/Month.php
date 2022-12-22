<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Month extends Model
{
    use HasFactory;
    

    public function fee_category(){
    	return $this->belongsToMany(FeeCategory::class);
    }
    public function transport_fee(){
    	return $this->belongsToMany(TransportFee::class)->withTimestamps();
    }
    public function fee_paid(){
    	return $this->belongsToMany(FeePaid::class)->withTimestamps();
    }



}
