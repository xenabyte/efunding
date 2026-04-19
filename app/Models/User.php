<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guard = 'user';

    protected $fillable = ['name', 'email', 'phone', 'member_id_code', 'member_type', 'role', 'password'];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function contributions() {
        return $this->hasMany(Contribution::class);
    }

    public function auditLogs() {
        return $this->hasMany(AuditLog::class);
    }
}