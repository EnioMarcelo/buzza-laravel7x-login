<?php

namespace App\Http\Controllers\Usuarios;

use App\Http\Controllers\Controller;
use App\Http\Requests\UsuarioRequest;
use App\Models\Usuario;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class UsuarioController extends Controller
{

    public function __construct()
    {
        $this->title_icon = 'fa fa-user';
        $this->title_page = 'Usuário';
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return Factory|Response|View
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
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
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
        return view('admin.usuarios.create', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page
        ]);
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
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
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
            return redirect(session()->get('origin_ref'))->with("success", "Usuário atualizado com sucesso.");
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


        /**
         * DELETE PERMISSION SPATIE ACL USERS
         */
        DB::table('model_has_permissions')->where('model_id', $usuario->id)->delete();
        DB::table('model_has_roles')->where('model_id', $usuario->id)->delete();


        /**
         * DELETE USER
         */
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


    public function role(Usuario $usuario)
    {
        $this->title_icon = 'fa fa-stack-overflow';
        $this->title_page = 'Perfil do Usuário: ' . '<b>' . $usuario->name . '</b>';

        $roles = Role::all();
        $usuario = User::where('id', $usuario->id)->first();

        foreach ($roles as $role) {

            if ($usuario->hasRole($role->name)) {
                $role->can = true;
            } else {
                $role->can = false;
            }
        }


        return view('admin.usuarios.roles', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
            'roles' => $roles,
            'usuario' => $usuario
        ]);
    }


    public function roleSync(Request $request)
    {
        $usuarioId = $request->id;

        $rolesRequest = $request->except(['_token', '_method', 'url', 'id']);

        if (Auth::user()->hasRole('Super Administrator') && $usuarioId == Auth::user()->id) {
            $rolesRequest[1] = 'on';
        }

        foreach ($rolesRequest as $key => $value) {
            $roles[] = Role::where('id', $key)->first();
        }

        $usuario = User::where('id', $usuarioId)->first();

        if (!empty($roles)) {
            $usuario->syncRoles($roles);
        } else {
            $usuario->syncRoles(null);
        }

        return redirect()->route('admin.usuario.role', ['usuario' => $usuario->id]);
    }
}
