<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Levy extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name', 'amount', 'applies_to', 'due_date'
    ];

    // Relationships
    public function contributions() {
        return $this->hasMany(Contribution::class);
    }
}
