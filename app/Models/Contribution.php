<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contribution extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'user_id', 'levy_id', 'campaign_id', 'amount', 
        'payment_gateway', 'transaction_reference', 'status'
    ];

    // Relationships
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function levy() {
        return $this->belongsTo(Levy::class);
    }

    public function campaign() {
        return $this->belongsTo(Campaign::class);
    }
}
