<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cable extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name'
    ];

    // public function location()
    // {
    //     return $this->belongsTo(Location::class);
    // }
}
