<?php


namespace App\Http\Controllers\Clientes;

use App\Http\Controllers\Controller;
use App\Models\Cliente;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ClienteController extends Controller
{

    public function __construct()
    {
        $this->title_icon = 'fa fa-user';
        $this->title_page = 'Clientes';
    }

    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        /**
         * SET SESSION FULL URL ORIGIN CALL
         */
        session()->put('origin_ref', $request->fullUrl());

        /**
         * QUANTIADADE DE REGISTROS POR PÁGINA
         */
        $per_page = $this->per_page;


        if (trim($request->search_for)) {
            $clientes = Cliente::where('tipo_pessoa', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('nome', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('cpf', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('cnpj', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('email', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orderBy('nome')
                ->paginate($per_page)
                ->appends(['search_for' => trim($request->search_for), 'per_page' => $per_page]);
        } else {
            $clientes = Cliente::orderBy('nome')->paginate($per_page);
        }

        return view('admin.clientes.index', [
            'clientes' => $clientes,
            'page' => (empty($request->page) ? 1 : $request->page),
            'per_page' => $per_page,
            'search_for' => $request->search_for
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return void
     */
    public function create(Request $request)
    {
        echo 'Novo Usuário - Create';
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        dd($request);
    }

    /**
     * Display the specified resource.
     *
     * @param Cliente $clientes
     * @param [type] $id
     * @return void
     *
     */
    public function show(Cliente $clientes, $id)
    {


        $_r = Cliente::where('id', $id)->pluck('nome');


        dd($_r, $id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Cliente $clientes
     * @return Factory|Response|View
     */

    public function edit(Cliente $cliente)
    {
        echo 'Edit Clientes: ' . $cliente->id;

        $cliente = Cliente::find($cliente->id);
        return view('admin.clientes.edit', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
            'cliente' => $cliente
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Cliente $clientes
     * @return void
     */
    public function update(Request $request, Cliente $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Cliente $clientes
     * @return void
     */
    public function destroy(Cliente $cliente)
    {

        /**
         * DELETE CLIENTE
         */
        Cliente::find($cliente->id)->delete($cliente->id);

        Session::flash('success', 'Registro deletado com sucesso.');

        return response()->json([
            'success' => 'Registro deletado com sucesso.'
        ]);
    }
}
