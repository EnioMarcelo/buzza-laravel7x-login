<?php

namespace App\Http\Livewire;

use App\Models\Client;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Class ClientesShow
 * @package App\Http\Livewire
 */
class ClientesShow extends Component
{

    use WithPagination;

    protected $listeners = ['delete_confirmed' => 'destroy'];
    protected $paginationTheme = 'bootstrap';

    public $type_screen = 'show';

    public $title_icon = 'fa fa-user';
    public $title_page = 'Clientes';

    public $message_type = null;
    public $message_text = null;

    public $data = null;
    public $search_for = null;
    public $per_page = 15;

    public $_id = null;
    public $_destroyId = null;

    public $nome = null;
    public $email = null;
    public $tipo_pessoa = 'TESTE';


    public function mount()
    {
        /**
         * SET SESSION FULL URL ORIGIN CALL
         */
        session()->put('origin_ref', redirect()->back()->getTargetUrl());

        $this->per_page = 12;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function render()
    {
        $searchTerm = '%' . $this->search_for . '%';

        return view('livewire.clientes-show', [
            'clientes' => Client::where('nome', 'like', $searchTerm)
                ->orWhere('email', 'like', $searchTerm)
                ->orWhere('tipo_pessoa', 'like', $searchTerm)
                ->paginate($this->per_page),
        ]);
    }

    /**
     * @param $screen
     * @param null $id
     */
    public function set_screen($screen, $id = null)
    {
        if ($screen == 'add') {
            $this->reset_input_fields();
        } else if ($screen == 'edit') {
            $this->reset_errors();
            $this->edit($id);
        } else if ($screen == 'show') {
            $this->message_type = null;
            $this->type_screen = 'show';
        }

        $this->title_icon = 'fa fa-user';
        $this->title_page = 'Clientes';

        $this->type_screen = $screen;
    }

    public function store()
    {
        $validatedDate = $this->validate([
            'nome' => 'required',
            'email' => "required|email|unique:clientes,email,$this->id,id",
        ]);

        if (Client::create($validatedDate)) {
            $this->reset_input_fields();
            // Set Flash Message
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => "Registro cadastrado com sucesso!!"
            ]);
        } else {
            // Set Flash Message
            /*$this->dispatchBrowserEvent('alert', [
                'type' => 'error',
                'message' => "Erro ao gravar registro no banco de dados!!"
            ]);*/
            $this->unexpected_error();
            return;
        }

    }

    /**
     * @param $id
     */
    public function edit($id)
    {
        $this->data = Client::find($id);
        if (!$this->data) {
            $this->reset_input_fields();
            $this->unexpected_error();
        } else {
            $this->_id = $this->data->id;
            $this->nome = $this->data->nome;
            $this->email = $this->data->email;
        }
    }

    /**
     * @param $id
     */
    public function update($id)
    {
        $validatedDate = $this->validate([
            'nome' => 'required',
            'email' => "required|email|unique:clientes,email,$id,id",
        ]);

        $cliente = Client::find($id);

        if (!$cliente) {
            $this->unexpected_error();
            $this->data = null;
            return;
        }

        $cliente->nome = $this->nome;
        $cliente->email = $this->email;

        if ($cliente->save()) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => "Registro atualizado com sucesso !!!"
            ]);
        } else {
            $this->unexpected_error();
            return;
        }

        $this->type_screen = 'show';

    }

    public function reset_pagination()
    {
        $this->gotoPage(1);
    }

    /**
     * @param $id
     */
    public function confirm_delete($id)
    {
        $this->_destroyId = $id;

        $this->dispatchBrowserEvent('swa_confirm_delete',
            [
                'message' => 'Deseja excluir este cliente ?',
                'text' => '',
                'trid' => 'trid-' . $id
            ]);

    }

    public function destroy()
    {
        if (Client::destroy($this->_destroyId)) {
            $this->dispatchBrowserEvent('alert', [
                'type' => 'success',
                'message' => "Registro deletado com sucesso !!!"
            ]);
        }
    }

    private function reset_errors()
    {
        $this->resetErrorBag();
        $this->resetValidation();
    }

    private function reset_input_fields()
    {
        $this->reset_errors();

        $this->nome = null;
        $this->email = null;
        $this->tipo_pessoa = 'TESTE';
    }

    private function unexpected_error()
    {
        $this->message_type = 'danger';
        $this->message_text = 'Um erro inesperado ocorreu.';

    }


}
