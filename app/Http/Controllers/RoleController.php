<?php

namespace App\Http\Controllers;

use App\Http\Requests\RoleRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{

    public function __construct()
    {
        $this->title_icon = 'fas fa-id-card';
        $this->title_page = 'Perfil do Usuário';
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
            $roles = Role::where('name', 'LIKE', '%' . trim($request->search_for) . '%')
                ->orderBy('name')
                ->paginate($per_page)
                ->appends(['search_for' => trim($request->search_for), 'per_page' => $per_page]);
        } else {
            $roles = Role::orderBy('name')
                ->paginate($per_page);
        }

        return view('admin.roles.index', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
            'roles' => $roles,
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
        return view('admin.roles.create', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(RoleRequest $request)
    {
        $role = new Role();
        $role->name = $request->name;

        if ($role->save()) {
            return redirect()->back()->with("success", "Perfil do Usuário cadastrado com sucesso.");
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
     * @param Role $role
     * @return \Illuminate\Http\Response
     */
    public function edit(Role $role)
    {
        if ($role->id == 1) {
            return redirect(session()->get('origin_ref'))->with("warning", "Este Perfil do Usuário não pode ser editado.");
        }

        $role = Role::find($role->id);
        return view('admin.roles.edit', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
            'role' => $role
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param RoleRequest $request
     * @return \Illuminate\Http\Response
     */
    public function update(RoleRequest $request)
    {
        $role = Role::find($request->id);
        $role->name = $request->name;

        /**
         * PERFIL DO USUÁRIO SUPER ADMIN NÃO PODE SER EDITADO
         */
        if ($request->id == 1) {
            return redirect(session()->get('origin_ref'))->with("warning", "Este Perfil do Usuário não pode ser editado.");
        }

        /**
         * SAVE PERFIL
         */
        if ($role->save()) {
            return redirect(session()->get('origin_ref'))->with("success", "Perfil do Usuário atualizado com sucesso.");
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @return JsonResponse|Response
     *
     */
    public function destroy(Role $role)
    {

        /**
         * PERFIL SUPER ADMINISTRADTOR NÃO PODE SER DELETADO
         */
        if ($role->id == 1) {
            Session::flash('warning', 'Este Perfil do Usuário não pode ser deletado.');

            return response()->json([
                'warning' => 'Impossivel Deletar, Este Perfil do Usuário não pode ser deletado.'
            ]);
        }


        /**
         * CHECK IF THERE IS RELATIONSHIP WITH THE PERMISSIONS TABLE
         * AND EXISTING DOES NOT DELETE THE REGISTRATION
         */
        $permissionRoleUser = DB::table('model_has_roles')->where('role_id', $role->id)->first();

        if ($permissionRoleUser) {

            Session::flash('warning', 'Impossivel Deletar, Perfil do Usuário relacionado com Usuário.');

            return response()->json([
                'warning' => 'Impossivel Deletar, Perfil do Usuário relacionado com Usuário.'
            ]);
        }


        /**
         * DELETE ROLE BY ID
         */

        Role::find($role->id)->delete($role->id);

        Session::flash('success', 'Registro deletado com sucesso.');

        return response()->json([
            'success' => 'Registro deletado com sucesso.'
        ]);
    }


    public function permission(Role $role)
    {

        /**
         * AS PERMISSÕES DO PERFIL DO USUÁRIO SUPER ADMIN NÃO PODE SER EDITADO
         */
        if ($role->id == 1) {
            return redirect(session()->get('origin_ref'));
        }


        $this->title_icon = 'fa fa-stack-overflow';
        $this->title_page = 'Permissões para: ' . '<b>' . $role->name . '</b>';

        $permissions = Permission::where('id', '<>', 1)->get();

        foreach ($permissions as $permission) {
            if ($role->hasPermissionTo($permission->name)) {
                $permission->can = true;
            } else {
                $permission->can = false;
            }
        }

        return view('admin.roles.permissions', [
            'title_icon' => $this->title_icon,
            'title_page' => $this->title_page,
            'role' => $role,
            'permissions' => $permissions,
        ]);
    }


    public function permissionSync(Request $request)
    {

        $roleId = $request->id;

        $permissionsRequest = $request->except(['_token', '_method', 'url', 'id']);

        foreach ($permissionsRequest as $key => $value) {
            $permissions[] = Permission::where('id', $key)->first();
        }

        $role = Role::where('id', $roleId)->first();

        if (!empty($permissions)) {
            $role->syncPermissions($permissions);
        } else {
            $role->syncPermissions(null);
        }

        return redirect()->route('admin.role.permission', ['role' => $role->id]);
    }

}
