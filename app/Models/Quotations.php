<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quotations extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'client_id',
        'title',
        'total',
        'tax',
        'discount',
        'status',
        'pdf_path',
        'sent_at',
        'viewed_at',
        'accepted_at',
        'declined_at',
    ];
    public function client()
    {
        return $this->belongsTo(Clients::class, 'client_id');
    }

    public function Quotatioitems()
    {
        return $this->hasMany(Quotationitems::class, 'quotation_id');
    }
}
