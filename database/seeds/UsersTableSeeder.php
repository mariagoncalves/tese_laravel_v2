<?php

use Illuminate\Database\Seeder;
use App\Users;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user_data = array(
            array('name' => 'Guilherme', 'email' => 'guineves@gmail.com', 'password' => '123','language_id' => '1','user_name' => 'Guineves','user_type' => 'internal','entity_id' => null),
        );


        //Inserir Utilizadores
        $user = Users::insert($user_data);
    }
}
