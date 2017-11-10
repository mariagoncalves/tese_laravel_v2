<?php

use Illuminate\Database\Seeder;
use App\Value;
use App\ValueName;

class ValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*factory(Value::class, 5)->create()->each(function($new) {
            factory(ValueName::class, 1)->create([
                'value_id'   => $new->id, 
                'updated_by' => $new->updated_by,
            ]);
        });*/

        //Fazendo seeds ao modo antigo
        $dados = [


            //Values para a instancia de entidade transporte 1
            [
                'id'          => '1',
                'entity_id'   => '1',
                'property_id' => '2',
                'value'       => 'Transportação de crianças para o desporto escolar',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '2',
                'entity_id'   => '1',
                'property_id' => '3',
                'value'       => 'Professora Rita',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '3',
                'entity_id'   => '1',
                'property_id' => '4',
                'value'       => '963003009',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '4',
                'entity_id'   => '1',
                'property_id' => '5',
                'value'       => 'Desporto escolar',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '5',
                'entity_id'   => '1',
                'property_id' => '6',
                'value'       => 'Escola da levada',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
             [
                'id'          => '6',
                'entity_id'   => '1',
                'property_id' => '7',
                'value'       => 'Barreiros',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '7',
                'entity_id'   => '1',
                'property_id' => '8',
                'value'       => '23-06-2018',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '8',
                'entity_id'   => '1',
                'property_id' => '9',
                'value'       => '23-06-2018',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '9',
                'entity_id'   => '1',
                'property_id' => '10',
                'value'       => '19:00',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '10',
                'entity_id'   => '1',
                'property_id' => '11',
                'value'       => '24:00',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '11',
                'entity_id'   => '1',
                'property_id' => '12',
                'value'       => '4',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '12',
                'entity_id'   => '1',
                'property_id' => '13',
                'value'       => '50',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '13',
                'entity_id'   => '1',
                'property_id' => '14',
                'value'       => '0',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '14',
                'entity_id'   => '1',
                'property_id' => '15',
                'value'       => 'Sem observações',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade apoios 2
            [
                'id'          => '15',
                'entity_id'   => '2',
                'property_id' => '18',
                'value'       => 'Concerto de Verão',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '16',
                'entity_id'   => '2',
                'property_id' => '19',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '17',
                'entity_id'   => '2',
                'property_id' => '20',
                'value'       => 'Pagar artistas',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '18',
                'entity_id'   => '2',
                'property_id' => '21',
                'value'       => '10000',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '19',
                'entity_id'   => '2',
                'property_id' => '22',
                'value'       => '5000',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
             [
                'id'          => '20',
                'entity_id'   => '2',
                'property_id' => '23',
                'value'       => '50',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '21',
                'entity_id'   => '2',
                'property_id' => '24',
                'value'       => 'Qualquer pessoa',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '22',
                'entity_id'   => '2',
                'property_id' => '25',
                'value'       => '600',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '23',
                'entity_id'   => '2',
                'property_id' => '26',
                'value'       => 'Concerto cultural',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '24',
                'entity_id'   => '2',
                'property_id' => '27',
                'value'       => 'True',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '25',
                'entity_id'   => '2',
                'property_id' => '28',
                'value'       => 'True',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '26',
                'entity_id'   => '2',
                'property_id' => '29',
                'value'       => 'Social',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '27',
                'entity_id'   => '2',
                'property_id' => '30',
                'value'       => '5',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '28',
                'entity_id'   => '2',
                'property_id' => '31',
                'value'       => 'José Gomes',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '29',
                'entity_id'   => '2',
                'property_id' => '32',
                'value'       => '911300600',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '30',
                'entity_id'   => '2',
                'property_id' => '33',
                'value'       => 'joseg@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '31',
                'entity_id'   => '2',
                'property_id' => '34',
                'value'       => 'Entidade responsável....',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade concurso 3
            [
                'id'          => '32',
                'entity_id'   => '3',
                'property_id' => '16',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '33',
                'entity_id'   => '3',
                'property_id' => '17',
                'value'       => 'Hortas urbanas municipais',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],


            //Values para a instancia de entidade transporte 4
            [
                'id'          => '34',
                'entity_id'   => '1',
                'property_id' => '2',
                'value'       => 'Transporte para visita de estudo',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '35',
                'entity_id'   => '1',
                'property_id' => '3',
                'value'       => 'Professora Alice',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '36',
                'entity_id'   => '1',
                'property_id' => '4',
                'value'       => '913003009',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '37',
                'entity_id'   => '1',
                'property_id' => '5',
                'value'       => 'Visita de estudo',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '38',
                'entity_id'   => '1',
                'property_id' => '6',
                'value'       => 'Escola do maritimo',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
             [
                'id'          => '39',
                'entity_id'   => '1',
                'property_id' => '7',
                'value'       => 'Avenida do mar',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '40',
                'entity_id'   => '1',
                'property_id' => '8',
                'value'       => '26-06-2018',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '41',
                'entity_id'   => '1',
                'property_id' => '9',
                'value'       => '27-06-2018',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '42',
                'entity_id'   => '1',
                'property_id' => '10',
                'value'       => '09:00',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '43',
                'entity_id'   => '1',
                'property_id' => '11',
                'value'       => '08:00',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '44',
                'entity_id'   => '1',
                'property_id' => '12',
                'value'       => '2',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '45',
                'entity_id'   => '1',
                'property_id' => '13',
                'value'       => '15',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '46',
                'entity_id'   => '1',
                'property_id' => '14',
                'value'       => '0',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '47',
                'entity_id'   => '1',
                'property_id' => '15',
                'value'       => 'Sem observações',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade freguesia 5
            [
                'id'          => '48',
                'entity_id'   => '5',
                'property_id' => '35',
                'value'       => 'Santo António',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '49',
                'entity_id'   => '5',
                'property_id' => '36',
                'value'       => '5327',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '50',
                'entity_id'   => '5',
                'property_id' => '37',
                'value'       => '650000',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade freguesia 6
            [
                'id'          => '51',
                'entity_id'   => '6',
                'property_id' => '35',
                'value'       => 'Monte',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '52',
                'entity_id'   => '6',
                'property_id' => '36',
                'value'       => '353',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '53',
                'entity_id'   => '6',
                'property_id' => '37',
                'value'       => '54533',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade freguesia 7
            [
                'id'          => '54',
                'entity_id'   => '7',
                'property_id' => '35',
                'value'       => 'Sé',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '55',
                'entity_id'   => '7',
                'property_id' => '36',
                'value'       => '54332',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '56',
                'entity_id'   => '7',
                'property_id' => '37',
                'value'       => '544333',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],


            //Values para a instancia de entidade municipe 8
            [
                'id'          => '57',
                'entity_id'   => '8',
                'property_id' => '38',
                'value'       => 'Maria',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '58',
                'entity_id'   => '8',
                'property_id' => '39',
                'value'       => 'Rua das hortas nº90',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '59',
                'entity_id'   => '8',
                'property_id' => '40',
                'value'       => 'Sé',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '60',
                'entity_id'   => '8',
                'property_id' => '41',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '61',
                'entity_id'   => '8',
                'property_id' => '42',
                'value'       => '9000-060',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '62',
                'entity_id'   => '8',
                'property_id' => '43',
                'value'       => '123456789',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '63',
                'entity_id'   => '8',
                'property_id' => '44',
                'value'       => '99999999',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '64',
                'entity_id'   => '8',
                'property_id' => '45',
                'value'       => '911900900',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '65',
                'entity_id'   => '8',
                'property_id' => '46',
                'value'       => 'mariah@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '66',
                'entity_id'   => '8',
                'property_id' => '47',
                'value'       => 'Programador',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
        

            //Values para a instancia de entidade municipe 9
            [
                'id'          => '67',
                'entity_id'   => '9',
                'property_id' => '38',
                'value'       => 'Ines',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '68',
                'entity_id'   => '9',
                'property_id' => '39',
                'value'       => 'Rua das flores',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '69',
                'entity_id'   => '9',
                'property_id' => '40',
                'value'       => 'Santo António',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '70',
                'entity_id'   => '9',
                'property_id' => '41',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '71',
                'entity_id'   => '9',
                'property_id' => '42',
                'value'       => '9000-061',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '72',
                'entity_id'   => '9',
                'property_id' => '43',
                'value'       => '123456787',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '73',
                'entity_id'   => '9',
                'property_id' => '44',
                'value'       => '88888888',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '74',
                'entity_id'   => '9',
                'property_id' => '45',
                'value'       => '911900800',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '75',
                'entity_id'   => '9',
                'property_id' => '46',
                'value'       => 'ines@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '76',
                'entity_id'   => '9',
                'property_id' => '47',
                'value'       => 'Medica',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],



            //Values para a instancia de entidade municipe 10
            [
                'id'          => '77',
                'entity_id'   => '10',
                'property_id' => '38',
                'value'       => 'Maria',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '78',
                'entity_id'   => '10',
                'property_id' => '39',
                'value'       => 'Rua das rochas',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '79',
                'entity_id'   => '10',
                'property_id' => '40',
                'value'       => 'Monte',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '80',
                'entity_id'   => '10',
                'property_id' => '41',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '81',
                'entity_id'   => '10',
                'property_id' => '42',
                'value'       => '9000-066',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '82',
                'entity_id'   => '10',
                'property_id' => '43',
                'value'       => '123123123',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '83',
                'entity_id'   => '10',
                'property_id' => '44',
                'value'       => '77777777',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '84',
                'entity_id'   => '10',
                'property_id' => '45',
                'value'       => '916600600',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '85',
                'entity_id'   => '10',
                'property_id' => '46',
                'value'       => 'maria_monte@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '86',
                'entity_id'   => '10',
                'property_id' => '47',
                'value'       => 'Estudante',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade municipe 11
            [
                'id'          => '87',
                'entity_id'   => '11',
                'property_id' => '38',
                'value'       => 'Maria',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '88',
                'entity_id'   => '11',
                'property_id' => '39',
                'value'       => 'Rua almirante',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '89',
                'entity_id'   => '11',
                'property_id' => '40',
                'value'       => 'Sé',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '90',
                'entity_id'   => '11',
                'property_id' => '41',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '91',
                'entity_id'   => '11',
                'property_id' => '42',
                'value'       => '9000-069',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '92',
                'entity_id'   => '11',
                'property_id' => '43',
                'value'       => '111222333',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '93',
                'entity_id'   => '11',
                'property_id' => '44',
                'value'       => '66666666',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '94',
                'entity_id'   => '11',
                'property_id' => '45',
                'value'       => '919009009',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '95',
                'entity_id'   => '11',
                'property_id' => '46',
                'value'       => 'mariajose@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '96',
                'entity_id'   => '11',
                'property_id' => '47',
                'value'       => 'Advogado',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],


            //Values para a instancia de entidade municipe 12
            [
                'id'          => '97',
                'entity_id'   => '12',
                'property_id' => '38',
                'value'       => 'Ana',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '98',
                'entity_id'   => '12',
                'property_id' => '39',
                'value'       => 'Rua segunda',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '99',
                'entity_id'   => '12',
                'property_id' => '40',
                'value'       => 'Santo António',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '100',
                'entity_id'   => '12',
                'property_id' => '41',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '101',
                'entity_id'   => '12',
                'property_id' => '42',
                'value'       => '9000-070',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '102',
                'entity_id'   => '12',
                'property_id' => '43',
                'value'       => '111222444',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '103',
                'entity_id'   => '12',
                'property_id' => '44',
                'value'       => '55555555',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '104',
                'entity_id'   => '12',
                'property_id' => '45',
                'value'       => '913005005',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '105',
                'entity_id'   => '12',
                'property_id' => '46',
                'value'       => 'ana@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '106',
                'entity_id'   => '12',
                'property_id' => '47',
                'value'       => 'Professor',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade entidade 13
            [
                'id'          => '107',
                'entity_id'   => '13',
                'property_id' => '48',
                'value'       => 'Musica e Sons Lda',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '108',
                'entity_id'   => '13',
                'property_id' => '49',
                'value'       => '511511511',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '109',
                'entity_id'   => '13',
                'property_id' => '50',
                'value'       => 'Santo António',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '110',
                'entity_id'   => '13',
                'property_id' => '51',
                'value'       => '9000-087',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '111',
                'entity_id'   => '13',
                'property_id' => '52',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '112',
                'entity_id'   => '13',
                'property_id' => '53',
                'value'       => 'Santo António',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '113',
                'entity_id'   => '13',
                'property_id' => '54',
                'value'       => '912122122',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '114',
                'entity_id'   => '13',
                'property_id' => '55',
                'value'       => '291966966',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '115',
                'entity_id'   => '13',
                'property_id' => '56',
                'value'       => 'musicasesons@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade entidade 14
            [
                'id'          => '116',
                'entity_id'   => '14',
                'property_id' => '48',
                'value'       => 'Escola horacio bento',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '117',
                'entity_id'   => '14',
                'property_id' => '49',
                'value'       => '511511500',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '118',
                'entity_id'   => '14',
                'property_id' => '50',
                'value'       => 'Sé',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '119',
                'entity_id'   => '14',
                'property_id' => '51',
                'value'       => '9000-087',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '120',
                'entity_id'   => '14',
                'property_id' => '52',
                'value'       => 'Funchal',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '121',
                'entity_id'   => '14',
                'property_id' => '53',
                'value'       => 'Sé',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '122',
                'entity_id'   => '14',
                'property_id' => '54',
                'value'       => '912122133',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '123',
                'entity_id'   => '14',
                'property_id' => '55',
                'value'       => '291966999',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'id'          => '124',
                'entity_id'   => '14',
                'property_id' => '56',
                'value'       => 'escolahb@gmail.com',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade locais 15
            [
                'id'          => '125',
                'entity_id'   => '15',
                'property_id' => '1',
                'value'       => 'Escola da levada',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade locais 16
            [
                'id'          => '126',
                'entity_id'   => '16',
                'property_id' => '1',
                'value'       => 'Barreiros',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade locais 17
            [
                'id'          => '127',
                'entity_id'   => '17',
                'property_id' => '1',
                'value'       => 'Escola maritimo',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de entidade locais 18
            [
                'id'          => '128',
                'entity_id'   => '18',
                'property_id' => '1',
                'value'       => 'Avenida do mar',
                'relation_id' => NULL,
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],



            //Values para a instancia de relaçao 1
            [
                'id'          => '129',
                'entity_id'   => NULL,
                'property_id' => '57',
                'value'       => '18-08-2017',
                'relation_id' => '1',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de relaçao 2
            [
                'id'          => '130',
                'entity_id'   => NULL,
                'property_id' => '57',
                'value'       => '01-09-2017',
                'relation_id' => '2',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            //Values para a instancia de relaçao 3
            [
                'id'          => '131',
                'entity_id'   => NULL,
                'property_id' => '59',
                'value'       => '01-09-2017',
                'relation_id' => '3',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            //Values para a instancia de relaçao 4
            [
                'id'          => '132',
                'entity_id'   => NULL,
                'property_id' => '59',
                'value'       => '24-09-2017',
                'relation_id' => '4',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],

            //Values para a instancia de relaçao 5
            [
                'id'          => '133',
                'entity_id'   => NULL,
                'property_id' => '59',
                'value'       => '12-10-2017',
                'relation_id' => '5',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            //Values para a instancia de relaçao 1
            [
                'id'          => '134',
                'entity_id'   => NULL,
                'property_id' => '58',
                'value'       => '01-09-2017',
                'relation_id' => '6',
                'state'       => 'active',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            

        ];

        foreach ($dados as $value) {
            Value::create($value);
        }

    }
}
