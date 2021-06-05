<?php

namespace App;

use App\Notifications\meuResetDeSenha;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable, HasRoles;

    protected $table = 'users';
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    /**
     * @return string
     */
    public function adminlte_image()
    {
        return 'https://picsum.photos/300/300';
    }

    /**
     * @return string
     */
    public function adminlte_profile_url()
    {
        return route('usuario.perfil');
    }

    /**
     * @param $value
     */
    public function setNameAttribute($value): void
    {
        if (!empty(trim($value))) {
            $this->attributes['name'] = mb_strtoupper($value);
        }
    }

    /**
     * @param $value
     * @return false|string|string[]
     */
    public function getNameAttribute($value)
    {
        return mb_strtoupper($value);
    }

    /**
     * @param $value
     */
    public function setEmailAttribute($value): void
    {
        if (!empty(trim($value))) {
            $this->attributes['email'] = mb_strtolower($value);
        }
    }

    /**
     * @param $value
     */
    public function setActiveAttribute($value): void
    {
        if ($value == 'on') {
            $this->attributes['active'] = 1;
        } else {
            $this->attributes['active'] = 0;
        }

    }

    /**
     * @param $value
     */
    public function setPasswordAttribute($value): void
    {
        if (empty(trim($value))) {
            $this->attributes['password'] = bcrypt(date('dmyHis'));
        } else {
            $this->attributes['password'] = $value;
        }
    }

    /**
     * @param $value
     * @return false|string
     */
    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }

    /**
     * @param string $token
     */
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new meuResetDeSenha($token));
    }

}
