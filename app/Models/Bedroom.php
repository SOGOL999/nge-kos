<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bedroom extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function booking(){
        return $this->hasMany(Booking::class);
    }

    function user(){
        return $this->belongsTo(User::class);
    }
}
