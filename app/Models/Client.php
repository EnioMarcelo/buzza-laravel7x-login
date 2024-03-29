<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clientes';

    protected $fillable = [
        'tipo_pessoa',
        'nome',
        'email'
    ];

    protected $attributes = [
        'tipo_pessoa' => 'TIPO-PESSOA',
    ];

    /**
     * Undocumented function
     *
     * @return void
     */
    static function listcli()
    {
        return Client::orderBy("nome", "asc")->get();
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
        }
    }
}
