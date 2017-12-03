<?php

use Illuminate\Database\Seeder;
use App\Actor;
use App\ActorName;

class ActorTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Inserir Utilizadores - 5 Actor
        for($i = 0; $i < 5; $i++)
        {
            $actor = Actor::create();
        }

        //Inserir o Nome para os Actores
        $actor_name = array(
            array('actor_id' => '1','language_id' => '1','name' => 'Interessado'),
            array('actor_id' => '2','language_id' => '1','name' => 'Realizador da Obra'),
            array('actor_id' => '3','language_id' => '1','name' => 'Gestor dos elementos instrutórios'),
            array('actor_id' => '4','language_id' => '1','name' => 'Gestor do Projeto de Arquitetura'),
            array('actor_id' => '5','language_id' => '1','name' => 'Gestor do Projeto de Especialidades'),
        );

        $actor = ActorName::insert($actor_name);
    }
}
