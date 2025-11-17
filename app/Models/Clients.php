<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Clients extends Model
{


     use HasFactory;

    protected $fillable = [
        'user_id',  
        'name',
        'company',
        'email',
        'phone',
        'address',
        'notes',
    ];

     public function user() {
        return $this->belongsTo(User::class);
    }
}
