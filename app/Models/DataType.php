<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DataType extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'current_balance',
        'charged_earned'
    ];
    
    
    public function user()
    {
        return $this->belongsTo(User::class);
    }




}
