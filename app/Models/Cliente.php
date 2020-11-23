<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'tipo_pessoa',
        'nome',
        'email'
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    static function listcli()
    {
        return Cliente::orderBy("nome", "asc")->get();
    }

    /**
     * Undocumented function
     *
     * @param [type] $value
     * @return void
     */
    public function setNomeAttribute($value): void
    {


        if (!empty(trim($value))) {

            $this->attributes['nome'] = strtoupper($value);
        }
    }


    /**
     * Undocumented function
     *
     * @param [type] $value
     * @return void
     */
    public function setEmailAttribute($value): void
    {


        if (!empty(trim($value))) {

            $this->attributes['email'] = strtolower($value);
        }
    }


    /**
     * Undocumented function
     *
     * @param [type] $value
     * @return void
     */
    public function setTipoPessoaAttribute($value): void
    {

        if (!empty(trim($value))) {

            $this->attributes['tipo_pessoa'] = strtoupper($value);
        } else {
        }
    }
}
