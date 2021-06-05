<?php

use App\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    public function run()
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'Super Administrator']);
//        Permission::create(['name' => 'View']);
//        Permission::create(['name' => 'Add']);
//        Permission::create(['name' => 'Edit']);
//        Permission::create(['name' => 'Delete']);
//        Permission::create(['name' => 'Print']);

        // create roles and assign created permissions

        // this can be done as separate statements
        // $role = Role::create(['name' => 'Super Administrator']);
//         $role->givePermissionTo('Super Administrator');

        $role = Role::create(['name' => 'Super Administrator']);
//         $role->givePermissionTo(Permission::all());
        $role->givePermissionTo('Super Administrator');

        $usuario = User::create(
            [
                'id' => random_int(100000000, 999999999) . random_int(100000000, 999999999),
                'name' => 'Enio Marcelo Buzaneli',
                'email' => 'eniomarcelo@gmail.com',
                'password' => bcrypt('123456'),
                'active' => 'on',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );

        $usuario->assignRole('Super Administrator');



        $usuario = User::create(
            [
                'id' => random_int(100000000, 999999999) . random_int(100000000, 999999999),
                'name' => 'José das Coves Buzaneli',
                'email' => 'eniomarcelo@al.ms.gov.br',
                'password' => bcrypt('123456'),
                'active' => 'on',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]
        );


    }
}
