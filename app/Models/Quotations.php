<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\QuotationItems; 
use App\Models\QuotationStatusLog;
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

    public function items()
    {
        return $this->hasMany(QuotationItems::class, 'quotation_id'); 
    }
    
     
    public function statusLogs()
    {
        return $this->hasMany(QuotationStatusLog::class, 'quotation_id');
    }

    public function latestStatus()
    {
        return $this->hasOne(QuotationStatusLog::class, 'quotation_id')->latestOfMany('changed_at');
    }



}
