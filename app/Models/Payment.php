<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = [
        'quotation_id',
        'amount',
        'payment_method',
        'status'
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotations::class, 'quotation_id');
    }
}
