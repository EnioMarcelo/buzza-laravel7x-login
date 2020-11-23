<?php


namespace App\Http\Controllers;

use App\Models\Cliente;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     * @param Request $request
     * @return Factory|View
     */
    public function index(Request $request)
    {
        /**
         * QUANTIADADE DE REGISTROS POR PÁGINA
         */
        $per_page = $this->per_page;


        if (trim($request->search_for)) {
            $clientes = Cliente::
            where('tipo_pessoa', 'LIKE', '%' . trim($request->search_for) . '%')
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
        // $cliente = new Clientes();

        // $cliente->tipo_pessoa = "PESSOA";
        // $cliente->nome = "cds csdcsdcscsc csdcds";
        // $cliente->cpf = "2343";
        // $cliente->rg = "32323/SEJUSPMS";
        // $cliente->email = "d222scsdcs@bol.com.br";
        // $cliente->anotacoes = "cdscds cdsc sdc sdcsd cdscdscdscsdcsd csdcds ";

        $_r['tipo_pessoa'] = 'PESSOA';
        $_r['nome'] = 'sdcsdc csdsc scds';
        $_r['cpf'] = '583233';
        $_r['email'] = '583cdcscssccd@gmail.com';

        $createCliente = Cliente::create($_r);

        // dd($createCliente);
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
     * @return void
     */
    public function edit(Cliente $clientes)
    {
        //
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
    public function destroy(Cliente $clientes)
    {
        //
    }
}
