<?php


namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class ClientController extends Controller
{

    public function __construct()
    {
        $this->title_icon = 'fa fa-user';
        $this->title_page = 'Clientes';
        $this->per_page = 5;
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
            $clientes = Client::where('tipo_pessoa', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('nome', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('cpf', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('cnpj', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('email', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orderBy('nome')
                ->paginate($per_page)
                ->appends(['search_for' => trim($request->search_for), 'per_page' => $per_page]);
        } else {
            $clientes = Client::orderBy('nome')->paginate($per_page);
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
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return void
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param Client $clientes
     * @param [type] $id
     * @return void
     *
     */
    public function show(Client $clientes, $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Client $clientes
     * @return Factory|Response|View
     */

    public function edit(Client $cliente)
    {
        echo 'Edit Clientes: ' . $cliente->id;

        $cliente = Client::find($cliente->id);
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
     * @param Client $clientes
     * @return void
     */
    public function update(Request $request, Client $clientes)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Client $clientes
     * @return void
     */
    public function destroy(Client $cliente)
    {

        /**
         * DELETE CLIENTE
         */
        Client::find($cliente->id)->delete($cliente->id);

        Session::flash('success', 'Registro deletado com sucesso.');

        return response()->json([
            'success' => 'Registro deletado com sucesso.'
        ]);
    }
}
