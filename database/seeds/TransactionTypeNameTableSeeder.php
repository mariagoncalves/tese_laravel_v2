<?php

use Illuminate\Database\Seeder;
use App\TransactionTypeName;

class TransactionTypeNameTableSeeder extends Seeder
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

            //Transações referentes ao concurso
        	[
        		'transaction_type_id' => '1',
        		'language_id'         => '1',
        		't_name'              => 'Gestão de concursos',
        		'rt_name'             => 'Gestão de concursos foi iniciada',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	],
        	[
        		'transaction_type_id' => '2',
        		'language_id'         => '1',
        		't_name'              => 'Abertura do concurso Funchal Cidade Florida',
        		'rt_name'             => 'Abertura do concurso Funchal Cidade Florida foi efetuada',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	],
        	[
        		'transaction_type_id' => '3',
        		'language_id'         => '1',
        		't_name'              => 'Admissão da candidatura ao concurso Funchal Cidade Florida',
        		'rt_name'             => 'Admissão da candidatura ao concurso Funchal Cidade Florida foi efetuada',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	],
            [
                'transaction_type_id' => '4',
                'language_id'         => '1',
                't_name'              => 'Avaliação de candidatura ao Funchal Cidade Florida',
                'rt_name'             => 'Avaliação de candidatura ao concurso Funchal Cidade Florida foi efetuada',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ],

            //Transação teste
            [
                'transaction_type_id' => '5',
                'language_id'         => '1',
                't_name'              => 'Transação teste',
                'rt_name'             => 'Transação teste foi efetuada',
                'updated_by'          => '1',
                'deleted_by'          => NULL
            ]
        ];

        foreach ($dados as $value) {
            TransactionTypeName::create($value);
        }
    }
}
