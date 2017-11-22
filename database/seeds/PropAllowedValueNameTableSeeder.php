<?php

use Illuminate\Database\Seeder;
use App\PropAllowedValueName;

class PropAllowedValueNameTableSeeder extends Seeder
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
        		'p_a_v_id'    => '1',
        		'language_id' => '1',
        		'name'        => 'Social',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
            [
                'p_a_v_id'    => '2',
                'language_id' => '1',
                'name'        => 'Cultural',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '3',
                'language_id' => '1',
                'name'        => 'Desportiva',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '4',
                'language_id' => '1',
                'name'        => 'Ambiente e património cultural',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '5',
                'language_id' => '1',
                'name'        => 'Promoção da saúde e prevenção de doenças',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '6',
                'language_id' => '1',
                'name'        => 'Proteção civil',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '7',
                'language_id' => '1',
                'name'        => 'Informação e defesa dos interesses dos cidadãos',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
        	[
                'p_a_v_id'    => '8',
                'language_id' => '1',
                'name'        => 'Educativa',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
        	[
        		'p_a_v_id'    => '9',
        		'language_id' => '1',
        		'name'        => 'Recreativa',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
        	[
        		'p_a_v_id'    => '10',
        		'language_id' => '1',
        		'name'        => 'Promoção do desenvolvimento economico',
                'updated_by'  => '1',
                'deleted_by'  => NULL
        	],
            [
                'p_a_v_id'    => '11',
                'language_id' => '1',
                'name'        => 'Promoção da igualdade de género',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '12',
                'language_id' => '1',
                'name'        => 'Promoção da cidadania e dos direitos humanos',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '13',
                'language_id' => '1',
                'name'        => 'Hortas urbanas municipais',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '14',
                'language_id' => '1',
                'name'        => 'Hortas urbanas sociais',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '15',
                'language_id' => '1',
                'name'        => 'Jardins de habitação social',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '16',
                'language_id' => '1',
                'name'        => 'Jardins unifamiliares',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '17',
                'language_id' => '1',
                'name'        => 'Varandas, balcões, terraços e escadarias',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '18',
                'language_id' => '1',
                'name'        => 'Unidades hoteleiras',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],



            //Prop allowed values para a prop prémio da entidade avaliação de candidatura
            [
                'p_a_v_id'    => '19',
                'language_id' => '1',
                'name'        => '500',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '20',
                'language_id' => '1',
                'name'        => '250',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '21',
                'language_id' => '1',
                'name'        => '150',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '22',
                'language_id' => '1',
                'name'        => '1500',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '23',
                'language_id' => '1',
                'name'        => '1000',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ],
            [
                'p_a_v_id'    => '24',
                'language_id' => '1',
                'name'        => 'Galardão de qualidade',
                'updated_by'  => '1',
                'deleted_by'  => NULL
            ]
        ];

        foreach ($dados as $value) {
            PropAllowedValueName::create($value);
        }
    }
}
