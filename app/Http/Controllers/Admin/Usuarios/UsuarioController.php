<?php

namespace App\Http\Controllers;

use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;

class UsuarioController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|Response|View
     */
    public function index(Request $request)
    {
        setcookie('origin_ref', $request->fullUrl());

        /**
         * QUANTIADADE DE REGISTROS POR PÁGINA
         */
        $per_page = $this->per_page;

        if (trim($request->search_for)) {
            $usuarios = Usuario::where('name', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orWhere('email', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orderBy('name')
                ->paginate($per_page)
                ->appends(['search_for' => trim($request->search_for), 'per_page' => $per_page]);
        } else {
            $usuarios = Usuario::orderBy('name')
                ->paginate($per_page);
        }

        return view('admin.usuarios.index', [
            'usuarios' => $usuarios,
            'page' => (empty($request->page) ? 1 : $request->page),
            'per_page' => $per_page,
            'search_for' => $request->search_for
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Factory|Response|View
     */
    public function create()
    {
        return view('admin.usuarios.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UsuarioRequest $request
     * @return RedirectResponse|Response
     */
    public function store(UsuarioRequest $request)
    {
        $usuario = new Usuario();
        $usuario->id = random_int(100000000, 999999999) . random_int(100000000, 999999999);
        $usuario->name = $request->name;
        $usuario->email = $request->email;
        $usuario->active = $request->active;
        $usuario->password = '';

        if ($usuario->save()) {
            return redirect()->back()->with("success", "Usuário cadastrado com sucesso.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Usuario $usuario
     * @return void
     */
    public function show(Usuario $usuario)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Usuario $usuario
     * @return Factory|Response|View
     */
    public function edit(Usuario $usuario)
    {
        $usuario = Usuario::find($usuario->id);
        return view('admin.usuarios.edit', [
            'usuario' => $usuario
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UsuarioRequest $request
     * @return RedirectResponse|Response|Redirector
     */
    public function update(UsuarioRequest $request)
    {
        $usuario = Usuario::find($request->id);
        $usuario->name = $request->name;
        $usuario->email = $request->email;

        if (Auth::user()->id <> $request->id) {
            $usuario->active = (bool)$request->active;
        }

        if ($usuario->save()) {
            return redirect( $_COOKIE['origin_ref'] )->with("success", "Usuário atualizado com sucesso.");
        }

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Usuario $usuario
     * @return JsonResponse|Response
     */
    public function destroy(Usuario $usuario)
    {
        if (Auth::user()->id == $usuario->id) {
            Session::flash('warning', 'Você não pode deletar o próprio cadastro.');
            return response()->json([
                'warning' => 'Você não pode deletar o próprio cadastro.'
            ]);
        }

        Usuario::find($usuario->id)->delete($usuario->id);

        Session::flash('success', 'Registro deletado com sucesso.');

        return response()->json([
            'success' => 'Registro deletado com sucesso.'
        ]);
    }


    /**
     * Undocumented function
     *
     * @param Usuario $usuario
     * @return Factory|JsonResponse|Response|View
     */
    public function btnActive(Usuario $usuario)
    {
        if (Auth::user()->id == $usuario->id) {
            return response()->json([
                'warning' => 'Você não pode alerar o status do próprio cadastro.'
            ]);
        } else {

            $usuario = Usuario::find($usuario->id);
            $usuario->active = (bool)$usuario->active ? 1 : 0;

            if ($usuario->save()) {

                \App\Models\Session::where('user_id', $usuario->id)->delete();

                return response()->json([
                    'success' => 'Status do Usuário atualizado com sucesso.'
                ]);
            }
        }
    }
}
