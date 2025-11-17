<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotation_items extends Model
{
    use HasFactory;

    // Explicitly define the table name
    protected $table = 'quotation_items';

    protected $fillable = [
        'quotation_id',
        'description',
        'qty',
        'unit_price',
        'tax',
        'discount',
        'total'
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
