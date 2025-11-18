<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItems extends Model
{
    use HasFactory;

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
        return $this->belongsTo(Quotations::class, 'quotation_id');
    }
}
