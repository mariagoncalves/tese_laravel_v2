<?php

use Illuminate\Database\Seeder;
use App\Relation;
use App\RelationName;

class RelationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(Relation::class, 6)->create()->each(function($new) {
            factory(RelationName::class, 1)->create([
                'relation_id' => $new->id, 
                'updated_by'  => $new->updated_by,
            ]);
        });*/

        //Fazendo seeds ao modo antigo
        $dados = [
            [
                'id'                   => '1',
                'rel_type_id'          => '1',
                'entity1_id'           => '13',
                'entity2_id'           => '1',
                'transaction_state_id' => '1',
                'state'                => 'active',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [
                'id'                   => '2',
                'rel_type_id'          => '1',
                'entity1_id'           => '4',
                'entity2_id'           => '14',
                'transaction_state_id' => '1',
                'state'                => 'active',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [
                'id'                   => '3',
                'rel_type_id'          => '3',
                'entity1_id'           => '3',
                'entity2_id'           => '8',
                'transaction_state_id' => '1',
                'state'                => 'active',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [
                'id'                   => '4',
                'rel_type_id'          => '3',
                'entity1_id'           => '9',
                'entity2_id'           => '3',
                'transaction_state_id' => '1',
                'state'                => 'active',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [
                'id'                   => '5',
                'rel_type_id'          => '3',
                'entity1_id'           => '10',
                'entity2_id'           => '3',
                'transaction_state_id' => '1',
                'state'                => 'active',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ],
            [
                'id'                   => '6',
                'rel_type_id'          => '2',
                'entity1_id'           => '13',
                'entity2_id'           => '2',
                'transaction_state_id' => '1',
                'state'                => 'active',
                'updated_by'           => '1',
                'deleted_by'           => NULL
            ]
        ];

        foreach ($dados as $value) {
            Relation::create($value);
        }
    }
}
