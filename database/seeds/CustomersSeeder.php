<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create('pt_BR');

        for ($i = 0; $i < 100; $i++) :

            $_typePerson = mb_strtoupper($faker->randomElement($array = array ('FISICA','JURIDICA'), $count = 2));


            DB::table('clientes')
                ->insert([
                    'tipo_pessoa' => $_typePerson,
                    'nome' => mb_strtoupper($faker->name),
                    'cpf' => ($_typePerson == 'FISICA' ? $faker->cpf : ''),
                    'cnpj' => ($_typePerson == 'JURIDICA' ? $faker->cnpj : ''),
                    'email' => $faker->unique()->safeEmail,
                    'anotacoes' => $faker->paragraph,
                    'created_at' => $faker->dateTimeBetween('now', '+05 year'),
                    'updated_at' => $faker->dateTimeBetween('now', '+05 year'),
                ]);
        endfor;
    }
}
