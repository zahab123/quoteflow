<?php

// In App/Models/QuotationStatusLog.php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Quotations;
class QuotationStatusLog extends Model
{
    use HasFactory;

    protected $table = 'quotation_status_logs';

    protected $fillable = [
        'quotation_id',
        'status',
        'changed_at',
        'remarks',
    ];

    public $timestamps = false;

    public function quotation()
    {
        return $this->belongsTo(Quotations::class, 'quotation_id');
    }
}