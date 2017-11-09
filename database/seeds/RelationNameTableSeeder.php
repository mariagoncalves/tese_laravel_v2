<?php

use Illuminate\Database\Seeder;
use App\RelationName;

class RelationNameTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Fazendo seeds ao modo antigo
        $dados = [
        	[
        		'relation_id' => '1',
                'language_id' => '1',
                'name'        => 'Entidade 1 pede transporte crianças escola',
                'updated_by'  => '1',
                'deleted_by'  => NULL

        	],
            [
                'relation_id' => '2',
                'language_id' => '1',
                'name'        => 'Entidade 2 pede transporte escolar 2017',
                'updated_by'  => '1',
                'deleted_by'  => NULL

            ],
            [
                'relation_id' => '3',
                'language_id' => '1',
                'name'        => 'Municipe nº 1234 participa em concurso Funchal Cidade Florida 2017',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'relation_id' => '4',
                'language_id' => '1',
                'name'        => 'Municipe nº 1235 participa em concurso Funchal Cidade Florida 2017',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'relation_id' => '5',
                'language_id' => '1',
                'name'        => 'Municipe nº 500 participa em concurso Funchal Cidade Florida 2017',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            RelationName::create($value);
        }
    }
}
