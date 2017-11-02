<?php

use Illuminate\Database\Seeder;
use App\TStateName;

class TStateNameTableSeeder extends Seeder
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
        		't_state_id'  => '1',
        		'language_id' => '1',
        		'name'        => 'Pedido',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	't_state_id'  => '2',
        		'language_id' => '1',
        		'name'        => 'Promessa',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	't_state_id'  => '3',
        		'language_id' => '1',
        		'name'        => 'Execução',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		't_state_id'  => '4',
        		'language_id' => '1',
        		'name'        => 'Afirmação',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[	't_state_id'  => '5',
        		'language_id' => '1',
        		'name'        => 'Aceitação',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        ];

        foreach ($dados as $value) {
            TStateName::create($value);
        }
    }
}
