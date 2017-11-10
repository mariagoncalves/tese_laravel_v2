<?php

use Illuminate\Database\Seeder;
use App\ActorName;

class ActorNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Atores do gestão de concursos
        $dados = [
        	[
        		'actor_id'    => '1',
        		'language_id' => '1',
        		'name'        => 'Gestor de concursos',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	'actor_id'    => '2',
        		'language_id' => '1',
        		'name'        => 'Responsável por abrir concursos',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'actor_id'    => '3',
        		'language_id' => '1',
        		'name'        => 'Candidato',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
            [
                'actor_id'    => '4',
                'language_id' => '1',
                'name'        => 'Admissor de candidatura',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            ActorName::create($value);
        }
    }
}
