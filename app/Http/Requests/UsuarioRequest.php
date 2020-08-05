<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class UsuarioRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        switch ($this->method()) {
            case 'POST':
            {
                return [
                    'name' => 'required',
                    'email' => "required|email|unique:users,email,$this->id,id"
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'name' => 'required',
                    'email' => "required|email|unique:users,email,$this->id,id",
                ];
            }
            default:
                break;
        }

    }

    public function attributes()
    {
        return [
            'name' => 'NOME',
            'email' => 'E-MAIL',
        ];
    }
}
