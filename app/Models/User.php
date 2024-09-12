<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use OwenIt\Auditing\Contracts\Auditable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements Auditable
{
    use HasFactory,
    Notifiable, 
    HasApiTokens, 
    \OwenIt\Auditing\Auditable,
    HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $auditInclude = [
        'name',
        'email',
        'remark',
        'status'
    ];

    // protected $auditExclude = [
    //     'password',
    // ];


    const STATUS_BARU = 'new';
    const STATUS_LULUS = 'approved';
    const STATUS_TOLAK = 'rejected';
    const STATUS_DALAM_SEMAKAN = 'processing';

    protected $guard_name = ['web', 'admin', 'sanctum', 'api'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
