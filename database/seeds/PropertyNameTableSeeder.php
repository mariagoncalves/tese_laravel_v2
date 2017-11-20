<?php

use Illuminate\Database\Seeder;
use App\PropertyName;

class PropertyNameTableSeeder extends Seeder
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

            //Propriedades da entidade local (7)

            [
                'property_id'     => '1',
                'language_id'     => '1',
                'name'            => 'Nome',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades de transporte (1)
        	[
        		'property_id'     => '2',
        		'language_id'     => '1',
        		'name'            => 'Qualidade em que faz o pedido',
        		'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
            [
                'property_id'     => '3',
                'language_id'     => '1',
                'name'            => 'Pessoa responsável',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '4',
                'language_id'     => '1',
                'name'            => 'Contacto pessoa responsável',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
        	[
        		'property_id'     => '5',
                'language_id'     => '1',
                'name'            => 'Tipo de evento',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
            [
                'property_id'     => '6',
                'language_id'     => '1',
                'name'            => 'Local de partida',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '7',
                'language_id'     => '1',
                'name'            => 'Local de chegada',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '8',
                'language_id'     => '1',
                'name'            => '1º opção de data pretendida',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '9',
                'language_id'     => '1',
                'name'            => '2º opção de data pretendida',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '10',
                'language_id'     => '1',
                'name'            => 'Hora de início',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '11',
                'language_id'     => '1',
                'name'            => 'Hora de fim',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '12',
                'language_id'     => '1',
                'name'            => 'Nº adultos',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '13',
                'language_id'     => '1',
                'name'            => 'Nº crianças',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '14',
                'language_id'     => '1',
                'name'            => 'Nº acompanhantes',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '15',
                'language_id'     => '1',
                'name'            => 'Observações',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades de concurso (2)
            [
                'property_id'     => '16',
                'language_id'     => '1',
                'name'            => 'Localização do espaço',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '17',
                'language_id'     => '1',
                'name'            => 'Modalidade em que concorre',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades de apoios
            [
        		'property_id'     => '18',
                'language_id'     => '1',
                'name'            => 'Descrição da atividade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
        	[
        		'property_id'     => '19',
                'language_id'     => '1',
                'name'            => 'Localidade onde irá se desenvolver a atividade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
        	],
            [
                'property_id'     => '20',
                'language_id'     => '1',
                'name'            => 'Destino a dar ao subsídio',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '21',
                'language_id'     => '1',
                'name'            => 'Orçamento total da atividade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '22',
                'language_id'     => '1',
                'name'            => 'Valor subsídio financeiro requerido',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '23',
                'language_id'     => '1',
                'name'            => '% apoio solicitado',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '24',
                'language_id'     => '1',
                'name'            => 'Tipo de público beneficiário',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '25',
                'language_id'     => '1',
                'name'            => 'Nº de público de beneficiários',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '26',
                'language_id'     => '1',
                'name'            => 'Fundamentação do interesse das atividades para o município do Funchal',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '27',
                'language_id'     => '1',
                'name'            => 'Pessoa coletiva de utilidade pública?',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '28',
                'language_id'     => '1',
                'name'            => 'Possui a situação regularizada face à Administração Fiscal, à segurança social e ao município do Funchal?',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '29',
                'language_id'     => '1',
                'name'            => 'Tipo de Entidade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '30',
                'language_id'     => '1',
                'name'            => 'Nº sócios filiados',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '31',
                'language_id'     => '1',
                'name'            => 'Nome do representante da entidade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '32',
                'language_id'     => '1',
                'name'            => 'Telefone do representante da entidade ',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '33',
                'language_id'     => '1',
                'name'            => 'Email do representante da entidade ',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '34',
                'language_id'     => '1',
                'name'            => 'Historial resumido da entidade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades de freguesia (5)
            [
                'property_id'     => '35',
                'language_id'     => '1',
                'name'            => 'Nome',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '36',
                'language_id'     => '1',
                'name'            => 'Nº de habitantes',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '37',
                'language_id'     => '1',
                'name'            => 'Área',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades de pessoa (4)
            [
                'property_id'     => '38',
                'language_id'     => '1',
                'name'            => 'Nome',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '39',
                'language_id'     => '1',
                'name'            => 'Morada',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '40',
                'language_id'     => '1',
                'name'            => 'Freguesia',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '41',
                'language_id'     => '1',
                'name'            => 'Concelho',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '42',
                'language_id'     => '1',
                'name'            => 'Código Postal',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '43',
                'language_id'     => '1',
                'name'            => 'NIF',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '44',
                'language_id'     => '1',
                'name'            => 'Nº cartão de cidadão',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '45',
                'language_id'     => '1',
                'name'            => 'Contacto',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '46',
                'language_id'     => '1',
                'name'            => 'Email',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '47',
                'language_id'     => '1',
                'name'            => 'Profissão',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades da entidade entidade (6)

            [
                'property_id'     => '48',
                'language_id'     => '1',
                'name'            => 'Designação da entidade',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '49',
                'language_id'     => '1',
                'name'            => 'NIF',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '50',
                'language_id'     => '1',
                'name'            => 'Sede',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '51',
                'language_id'     => '1',
                'name'            => 'Código Postal',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '52',
                'language_id'     => '1',
                'name'            => 'Concelho',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '53',
                'language_id'     => '1',
                'name'            => 'Freguesia',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '54',
                'language_id'     => '1',
                'name'            => 'Telefone',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '55',
                'language_id'     => '1',
                'name'            => 'Fax',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '56',
                'language_id'     => '1',
                'name'            => 'Email',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades da relação Entidade transporte??
            [
                'property_id'     => '57',
                'language_id'     => '1',
                'name'            => 'Data',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            //Propriedades da relação Entidade apoios??
            [
                'property_id'     => '58',
                'language_id'     => '1',
                'name'            => 'Data',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            //Propriedades da relação pessoa concurso??
            [
                'property_id'     => '59',
                'language_id'     => '1',
                'name'            => 'Data',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],

            //Propriedades de concurso (abertura)
            [
                'property_id'     => '60',
                'language_id'     => '1',
                'name'            => 'Nome do concurso',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ],
            [
                'property_id'     => '61',
                'language_id'     => '1',
                'name'            => 'Prazo de candidatura',
                'form_field_name' => NULL,
                'updated_by'      => '1',
                'deleted_by'      => NULL
            ]
        ];

        foreach ($dados as $value) {
            PropertyName::create($value);
        }
    }
}
