<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Project extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title', 'description', 'target_amount', 'status'
    ];

    // Relationships
    public function campaigns() {
        return $this->hasMany(Campaign::class);
    }

    public function expenditures() {
        return $this->hasMany(Expenditure::class);
    }
}
