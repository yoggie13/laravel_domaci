<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Booking;

class Location extends Model
{
    use HasFactory;


    public function arrangements(){
        return $this->hasMany(Arrangements::class);
    }
}
