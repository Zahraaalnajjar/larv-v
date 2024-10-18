<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Tymon\JWTAuth\Contracts\JWTSubject;

class Share extends Model implements JWTSubject
{
    use HasFactory;

    protected $primaryKey = 'id';

    protected $fillable = ['id', 'x', 'y','last_login_at', 'login_count','active_login_status'];
    protected $casts = [
        'login_count' => 'integer',
        'last_login_at' => 'datetime',

            'active_login_status' => 'integer',

    ];


    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}


