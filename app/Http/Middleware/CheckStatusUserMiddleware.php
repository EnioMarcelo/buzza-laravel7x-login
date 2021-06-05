<?php

namespace App\Http\Middleware;

use Closure;

class CheckStatusUserMiddleware
{
    /**
     * VERIFICA SE A CONTA DO USUÁRIO ESTÁ ATIVO PARA FAZER O LOGIN OU
     * DESCONECTA O USUÁRIO DO SISTEMA SE ELE ESTIVER LOGADO E A CONTA FOR DESATIVADA.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = auth()->user();

        if (!$user->active) {
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            return redirect('/login')->with([
                'flash.message_title' => 'Acesso Negado!',
                'flash.message_text' => 'Sua conta de acesso foi bloqueada. Contacte o administrador do sistema.',
                'flash.message_class' => 'danger'
            ]);
        }

        return $next($request);
    }
}
