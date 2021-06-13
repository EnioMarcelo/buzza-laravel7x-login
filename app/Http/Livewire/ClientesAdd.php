<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;


class ClientesAdd extends Component
{
    public $title_icon = 'fa fa-user';
    public $title_page = 'Clientes ADD';

    public $nome;
    public $email;
    public $tipo_pessoa;


    public function mount()
    {

        $this->resetInputFields();

    }

    public function render()
    {
        return view('livewire.clientes-add');
    }

    private function resetInputFields()
    {
        $this->nome = null;
        $this->email = null;
        $this->tipo_pessoa = 'TESTE';
    }

    public function store()
    {

        $validatedDate = $this->validate([
            'nome' => 'required',
            'email' => "required|email|unique:clientes,email,$this->id,id",
        ]);

        $cliente = new Client();
        $cliente->nome = $this->nome;
        $cliente->email = $this->email;
        $cliente->tipo_pessoa = $this->tipo_pessoa;

        if ($cliente->save()) {

            $this->resetInputFields();

            // Set Flash Message
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => "Registro cadastrado com sucesso!!"

            ]);

        } else {

            // Set Flash Message
            $this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "Erro ao gravar registro no banco de dados!!"
            ]);

        }

    }
}
