<?php

namespace App\Providers;

use App\Models\Client;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use \Illuminate\Support\Facades\Auth;


class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(Dispatcher $events)
    {
        //https://github.com/jeroennoten/Laravel-AdminLTE/wiki/8.-Menu-Configuration

        Schema::defaultStringLength(191);
        setlocale(LC_TIME, 'pt_BR', 'pt_BR.utf-8', 'pt_BR.utf-8', 'portuguese');
        date_default_timezone_set('America/Cuiaba');

        $events->listen(BuildingMenu::class, function (BuildingMenu $event) {

            $_label_color = 'light';

            $event->menu->add('MENU PRINCIPAL');
            $event->menu->add(
                [
                    'text' => 'Dashboard',
                    'url' => '/admin',
                    'icon' => 'fa fa-fw fa-tachometer',
                    'label_color' => $_label_color,
                    'active' => ['/', '/home']
                ],
                [
                    'text' => 'Clientes',
                    'url' => 'clientes',
                    'icon' => 'far fa-fw fa-user ',
                    'label' => Client::count(),
                    'label_color' => $_label_color,
                    'active' => ['cliente/*'],
                    'can' => ['Super Administrator', 'Clientes - ALL', 'Clientes - SEARCH'],
                ]

            );

            $event->menu->add('CONFIGURAÇÃO DA CONTA');
            $event->menu->add(
                [
                    'text' => 'Perfil',
                    'url' => 'usuario/perfil',
                    'icon' => 'fas fa-fw fa-user',
                    'active' => ['usuario.perfil'],

                ],
                [
                    'text' => 'Alterar Senha',
                    'url' => 'usuario/alterar-senha',
                    'icon' => 'fas fa-fw fa-unlock',
                    'active' => ['usuario.alterar-senha'],
                ]
            );

            if (Auth::user()->hasRole('Super Administrator')) {
                $event->menu->add('ADMINISTRAÇÃO');

                $event->menu->add(
                    [
                        'text' => 'Usuários',
                        'url' => '/admin/usuario',
                        'icon' => 'fas fa-fw fa-user',
                        'label' => User::count(),
                        'label_color' => $_label_color,
                        'active' => ['admin.usuario.*'],
                        'can' => ['Super Administrator'],

                    ],
                    [
                        'text' => 'Perfil do Usuário',
                        'url' => '/admin/role',
                        'icon' => 'fas fa-fw fa-id-card',
                        'label' => Role::count(),
                        'label_color' => $_label_color,
                        'active' => ['admin/role/*'],
                        'can' => ['Super Administrator'],

                    ],
                    [
                        'text' => 'Permissões do Perfil',
                        'url' => '/admin/permission',
                        'icon' => 'fa fa-fw fa-stack-overflow',
                        'label' => Permission::count(),
                        'label_color' => $_label_color,
                        'active' => ['admin/permission/*'],
                        'can' => ['Super Administrator'],

                    ]
                );
            }


        });
    }
}
