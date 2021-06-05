<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Rules\MatchOldPassword;
use App\User;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ChangePassController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return Factory|Response|View
     */
    public function index()
    {
        return view('admin.usuarios.changepass',[
            'user_email' => Auth::user()->email,
            'user_name' => Auth::user()->name
        ]);
    }

    /**
     * Undocumented function
     *
     * @param Request $request
     * @return RedirectResponse|void
     */
    public function changePassword(Request $request)
    {

        $request->validate(
            [
                'current_password' => ['required', new MatchOldPassword],
                'new_password' => 'required|alpha_dash|min:6|different:current_password',
                'new_confirm_password' => ['same:new_password', 'required', 'alpha_dash']
            ],
            [],
            [
                'current_password' => 'SENHA ATUAL',
                'new_password' => 'NOVA SENHA',
                'new_confirm_password' => 'CONFIRME NOVA SENHA'
            ]
        );

        User::find(auth()->user()->id)->update(['password'=> Hash::make($request->new_password)]);

        return redirect()->back()->with("success","Senha alterada com sucesso.");

    }
}
