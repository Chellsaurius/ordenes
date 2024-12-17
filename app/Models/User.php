<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

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
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function RUC() : BelongsToMany {
        return $this->belongsToMany( comisions::class, 'records', 'comision_id', 'user_id');
    }

    // public function RUserPos() : BelongsToMany {
    //     return $this->belongsToMany( positions::class, 'records', 'position_id', 'user_id');
    // }

    public function RUrecords()
    {
        return $this->hasMany(records::class, 'id', 'user_id');
    }

    public function RRolUsers()
    {
        return $this->belongsTo(rols::class, 'rol_id', 'rol_id');
    }

    // public function RPosUsers()
    // {
    //     return $this->belongsTo(positions::class, 'position_id', 'position_id');
    // }

    public function RPartyUsers()
    {
        return $this->belongsTo(parties::class, 'party_id', 'party_id');
    }

    public function RUserOrders()
    {
        return $this->hasMany( orders::class, 'order_createdBy', 'id' );
    }

}
