<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Power extends Model
{
    use HasFactory;

    protected $fillable = [
        'fl_name',
        'cl_name',
        'code'
    ];

    // public function location()
    // {
    //     return $this->belongsTo(Location::class);
    // }
}
