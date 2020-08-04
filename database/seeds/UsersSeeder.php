<?php

use Faker\Factory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $faker = Factory::create('pt_BR');


        DB::table('users')
            ->insert([
                'name' => 'Enio Marcelo Buzaneli',
                'email' => 'eniomarcelo@gmail.com',
                'password' => '$2y$10$laqD/Nuk/7Ln1bIi1YlgAOtk1Ba/VRG12MQAvDnl6POhRSJEKr/RS',
                'active' => '1',
                'created_at' => date('Y-m-d H:i:s'),
                'updated_at' => date('Y-m-d H:i:s'),
            ]);


        for ($i = 0; $i < 100; $i++) :

            $_active = mb_strtoupper($faker->randomElement($array = array('0', '1'), $count = 2));

            DB::table('users')
                ->insert([
                    'name' => mb_strtoupper($faker->name),
                    'email' => $faker->unique()->safeEmail,
                    'password' => $faker->password(),
                    'active' => $_active,
                    'created_at' => $faker->dateTimeBetween('now', '+05 year'),
                    'updated_at' => $faker->dateTimeBetween('now', '+05 year'),
                ]);
        endfor;
    }
}
