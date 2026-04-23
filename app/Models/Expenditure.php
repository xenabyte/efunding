<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Expenditure extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'project_id',
        'purpose',
        'amount',
        'date_spent',
        'receipt_image'
    ];

    // Relationships
    public function project()
    {
        return $this->belongsTo(Project::class);
    }
}
