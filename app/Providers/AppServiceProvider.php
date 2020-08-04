<?php

namespace App\Providers;

use App\Models\Cliente;
use App\User;
use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Events\Dispatcher;
use Illuminate\Support\Facades\Schema;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;


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
                    'active' => ['/','/home'],
                ],
                [
                    'text' => 'Clientes',
                    'url' => 'admin/clientes',
                    'icon' => 'far fa-fw fa-user ',
                    'label' => Cliente::count(),
                    'label_color' => $_label_color,
                    'active' => ['admin/cliente/*'],
                ]

            );

            $event->menu->add('CONFIGURAÇÃO DA CONTA');
            $event->menu->add(
                [
                    'text' => 'Perfil',
                    'url' => 'admin/usuario/perfil',
                    'icon' => 'fas fa-fw fa-user',
                    'active' => ['admin/usuario/perfil'],

                ],
                [
                    'text' => 'Alterar Senha',
                    'url' => 'admin/usuario/alterar-senha',
                    'icon' => 'fas fa-fw fa-unlock',
                    'active' => ['admin/usuario/alterar-senha'],
                ]
            );

            $event->menu->add('ADMINISTRAÇÃO');
            $event->menu->add(
                [
                    'text' => 'Usuários',
                    'url' => '/admin/usuarios',
                    'icon' => 'fas  fa-user',
                    'label' => User::count(),
                    'label_color' => $_label_color,
                    'active' => ['admin/usuarios/*'],

                ]
            );


        });
    }
}
