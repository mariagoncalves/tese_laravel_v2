<?php

use Illuminate\Database\Seeder;
use App\WaitingLink;

class WaitingLinkTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $dados = [
        	[
        		'id'                  => '1',
                'waited_t'            => '2',
                'waited_fact'         => '5',
                'waiting_fact'        => '3',
                'waiting_t'           => '1',
                'min'                 => '1',
                'max'                 => '*',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	],
        	[
        		'id'                  => '2',
                'waited_t'            => '4',
                'waited_fact'         => '5',
                'waiting_fact'        => '3',
                'waiting_t'           => '3',
                'min'                 => '0',
                'max'                 => '*',
                'updated_by'          => '1',
                'deleted_by'          => NULL
        	]
        ];

        foreach ($dados as $value) {
            WaitingLink::create($value);
        }
    }
}
