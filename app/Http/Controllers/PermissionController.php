<?php

namespace App\Http\Controllers;

use App\Http\Requests\PermissionRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{

    public function __construct()
    {
        $this->title_icon = 'fa fa-stack-overflow';
        $this->title_page = 'Permissões do Perfil';
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
            $Permissions = Permission::where('name', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orderBy('name')
                ->paginate($per_page)
                ->appends(['search_for' => trim($request->search_for), 'per_page' => $per_page]);
        } else {
            $Permissions = Permission::orderBy('name')
                ->paginate($per_page);
        }

        return view('admin.permissions.index', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
            'permissions' => $Permissions,
            'page' => (empty($request->page) ? 1 : $request->page),
            'per_page' => $per_page,
            'search_for' => $request->search_for
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.permissions.create', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param PermissionRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PermissionRequest $request)
    {
        $permission = new Permission();
        $permission->name = $request->name;

        if ($permission->save()) {
            return redirect()->back()->with("success", "Permissão do Usuário cadastrado com sucesso.");
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     */
    public function edit(Permission $permission)
    {
        if ($permission->id == 1) {
            return redirect(session()->get('origin_ref'))->with("warning", "Esta Permissão do Perfil do Usuário não pode ser editado.");
        }

        $permission = Permission::find($permission->id);
        return view('admin.permissions.edit', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
            'permission' => $permission
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function update(PermissionRequest $request)
    {
        $permission = Permission::find($request->id);
        $permission->name = $request->name;

        /**
         * PERMISSÃO DO PERFIL SUPER ADMIN NÃO PODE SER EDITADO
         */
        if( $request->id == 1 ){
            return redirect(session()->get('origin_ref'))->with("warning", "Esta Permissão do Perfil do Usuário não pode ser editado.");
        }

        if ($permission->save()) {
            return redirect(session()->get('origin_ref'))->with("success", "Permissão do Usuário atualizado com sucesso.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Permission $permission
     * @return \Illuminate\Http\Response
     * @return JsonResponse|Response
     */
    public function destroy(Permission $permission)
    {
        /**
         * PERMISSÃO DO PERFIL SUPER ADMINISTRADTOR NÃO PODE SER DELETADO
         */
        if( $permission->id == 1 ){
            Session::flash('warning', 'Estea Permissão do Perfil do Usuário não pode ser deletado.');

            return response()->json([
                'warning' => 'Impossivel Deletar, Este Perfil do Usuário não pode ser deletado.'
            ]);
        }


        /**
         * CHECK IF THERE IS RELATIONSHIP WITH THE ROLES TABLE
         * AND EXISTING DOES NOT DELETE THE REGISTRATION
         */
        $role = DB::table('role_has_permissions')->where('permission_id', $permission->id)->first();

        if ($role) {

            Session::flash('warning', 'Impossivel Deletar , Permissão relacionado com Perfil do Usuário.');

            return response()->json([
                'warning' => 'Impossivel Deletar , Permissão relacionado com Perfil do Usuário.'
            ]);
        }


        /**
         * DELETE PERMISSION BY ID
         */

        Permission::find($permission->id)->delete($permission->id);

        Session::flash('success', 'Registro deletado com sucesso.');

        return response()->json([
            'success' => 'Registro deletado com sucesso.'
        ]);
    }
}
