<?php

namespace App\Models;

use App\User;

class Usuario extends User
{
    protected $table = 'users';
    protected $keyType = 'string';

    public function setNameAttribute($value): void
    {
        if (!empty(trim($value))) {
            $this->attributes['name'] = mb_strtoupper($value);
        }
    }

    public function getNameAttribute($value)
    {
        return strtoupper($value);
    }

    public function setEmailAttribute($value): void
    {
        if (!empty(trim($value))) {
            $this->attributes['email'] = mb_strtolower($value);
        }
    }

    public function setActiveAttribute($value): void
    {
        if ($value == 'on') {
            $this->attributes['active'] = 1;
        } else {
            $this->attributes['active'] = 0;
        }
    }

    public function setPasswordAttribute($value): void
    {
        if (empty(trim($value))) {
            $this->attributes['password'] = bcrypt(date('dmyHis'));
        }
    }

    public function getCreatedAtAttribute($value)
    {
        return date('d/m/Y', strtotime($value));
    }
}
