<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Booking extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    function bedroom() {
        return $this->belongsTo(Bedroom::class);
    }

    function user() {
        return $this->belongsTo(User::class);
    }
}