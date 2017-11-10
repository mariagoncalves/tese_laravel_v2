<?php

use Illuminate\Database\Seeder;
use App\TransactionType;
use App\TransactionTypeName;

class TransactionTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$datas = [
            ['Decisao sobre cedencia de transporte', 'Decisao sobre cedencia de transporte foi efetuada'],
            ['Decisão sobre apoios', 'Decisão sobre apoios foi efetuada'],
            ['Solicitação de pedido', 'Solicitação de pedido foi efetuada']
        ];

        foreach ($datas as $data) {
            $new = factory(TransactionType::class, 1)->create();

            factory(TransactionTypeName::class, 1)->create([
                'transaction_type_id' => $new->id,
                'language_id' => App\Language::where('slug', 'pt')->first()->id, 
                't_name'      => $data[0],
                'rt_name'     => $data[1],
                'updated_by'  => $new->updated_by,
            ]);
        }*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'              => '1',
                'state'           => 'active',
                'process_type_id' => '2',
                'init_proc'       => '1',
                'executer'        => '1',
                'auto_activate'   => '1',
                'freq_activate'   => '1 ano',
                'when_activate'   => '00:00:00',
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [   'id'              => '2',
                'state'           => 'active',
                'process_type_id' => '2',
                'init_proc'       => '1',
                'executer'        => '2',
                'auto_activate'   => '0',
                'freq_activate'   => NULL,
                'when_activate'   => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [   'id'              => '3',
                'state'           => 'active',
                'process_type_id' => '2',
                'init_proc'       => '2',
                'executer'        => '3',
                'auto_activate'   => '0',
                'freq_activate'   => NULL,
                'when_activate'   => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [   'id'              => '4',
                'state'           => 'active',
                'process_type_id' => '2',
                'init_proc'       => '3',
                'executer'        => '4',
                'auto_activate'   => '0',
                'freq_activate'   => NULL,
                'when_activate'   => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Transaçao teste
            [   'id'              => '5',
                'state'           => 'active',
                'process_type_id' => '1',
                'init_proc'       => '3',
                'executer'        => '4',
                'auto_activate'   => '0',
                'freq_activate'   => NULL,
                'when_activate'   => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ]
        ];

        foreach ($dados as $value) {
            TransactionType::create($value);
        }
    }
}
