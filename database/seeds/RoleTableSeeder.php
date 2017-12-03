<?php

use Illuminate\Database\Seeder;
use App\Role;
use App\RoleName;
use App\RoleHasUser;
use App\RoleHasActor;

class RoleTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Inserir Utilizadores - 5 Roles
        for($i = 0; $i < 5; $i++)
        {
            $role = Role::create();
        }


        //Inserir Roles Names
        $role_name = array(
            array('role_id' => '1','language_id' => '1','name' => 'Munícipe'),
            array('role_id' => '2','language_id' => '1','name' => 'Rececionista'),
            array('role_id' => '3','language_id' => '1','name' => 'Arquiteto'),
            array('role_id' => '4','language_id' => '1','name' => 'Fiscal'),
            array('role_id' => '5','language_id' => '1','name' => 'Vereador'),
        );

        $roles = RoleName::insert($role_name);

        //RoleHasUser - Preencher a table
        $role_has_user = array(
            array('role_id' => '1','user_id' => '1'),
        );

        $role_has_users = RoleHasUser::insert($role_has_user);

        //RoleHasActor
        $role_has_actor = array(
            array('role_id' => '1','actor_id' => '1'),
            array('role_id' => '2','actor_id' => '3'),
            array('role_id' => '3','actor_id' => '4'),
            array('role_id' => '3','actor_id' => '5'),
            array('role_id' => '5','actor_id' => '2'),
        );

        $role_has_actors = RoleHasActor::insert($role_has_actor);
    }
}
