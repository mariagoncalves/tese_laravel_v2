<?php

use Illuminate\Database\Seeder;
use App\Property;
use App\PropertyName;


class PropertyTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*$datas = ['Nome', 'Rua'];
        foreach ($datas as $data) {
            $new = factory(Property::class, 1)->create(['value_type' => 'text']);

            factory(PropertyName::class, 1)->create([
                'property_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        $datas = ['Numero de Pessoas', 'Objetivo', 'Área', 'Preço', 'Quantidade'];
        foreach ($datas as $data) {
            $new = factory(Property::class, 1)->create();

            factory(PropertyName::class, 1)->create([
                'property_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }

        $datas = ['Idade', 'Profissão'];
        foreach ($datas as $data) {
            $new = factory(Property::class, 1)->create(['value_type' => 'enum']);

            factory(PropertyName::class, 1)->create([
                'property_id' => $new->id, 
                'name'        => $data,
                'language_id' => App\Language::where('slug', 'pt')->first()->id,
                'updated_by'  => $new->updated_by,
            ]);
        }*/

        //Fazendo seeds ao modo antigo
        $dados = [

            //Propriedades da entidade local (7)
            [
                'id'               => '1',
                'ent_type_id'      => '7',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades de transporte (1)
            [
                'id'               => '2',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '3',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '4',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '9',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '5',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '6',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'prop_ref',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '5',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => '1',
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '7',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'prop_ref',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '6',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => '1',
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '8',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '7',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '9',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '8',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '10',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '9',
                'mandatory'        => '0',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '11',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '10',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '12',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '11',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '2',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '13',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '12',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '2',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '14',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '13',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '2',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '15',
                'ent_type_id'      => '1',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'textbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '14',
                'mandatory'        => '0',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '50x50',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades de concurso (candidatura) (2)
            [
                'id'               => '16',
                'ent_type_id'      => '2',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '17',
                'ent_type_id'      => '2',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'enum',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades de apoios (3)
            [
                'id'               => '18',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '1',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '19',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '20',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '21',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => '5',
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
             [
                'id'               => '22',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => '5',
                'form_field_order' => '5',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '23',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '6',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '3',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '24',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '7',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '25',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '8',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '26',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'textbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '9',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '50x50',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '27',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'bool',
                'form_field_type'  => 'radio',
                'unit_type_id'     => NULL,
                'form_field_order' => '10',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '28',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'bool',
                'form_field_type'  => 'radio',
                'unit_type_id'     => NULL,
                'form_field_order' => '11',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '29',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'enum',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '12',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '30',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '13',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '5',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '31',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '14',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '32',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '15',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '9',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '33',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '16',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '34',
                'ent_type_id'      => '3',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'textbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '17',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100x100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades de freguesia (5)
            [
                'id'               => '35',
                'ent_type_id'      => '5',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '36',
                'ent_type_id'      => '5',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '37',
                'ent_type_id'      => '5',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '5',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

             //Propriedades de pessoa (4)
            [
                'id'               => '38',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '39',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '40',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'prop_ref',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => '35',
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '41',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '42',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '5',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '8',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '43',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '6',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '9',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '44',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                'value_type'       => 'int',
                't_state_id'       => '1',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '7',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '8',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '45',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '8',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '9',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '46',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '9',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '47',
                'ent_type_id'      => '4',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '10',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades da entidade entidade (6)
            [
                'id'               => '48',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '49',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '50',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [
                'id'               => '51',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '4',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '8',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '52',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '5',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '53',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'prop_ref',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '6',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => '35',
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '54',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '7',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '9',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '55',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '8',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '56',
                'ent_type_id'      => '6',
                'rel_type_id'      => NULL,
                't_state_id'       => '1',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '9',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades da relação Entidade transporte??
            [

                'id'               => '57',
                'ent_type_id'      => NULL,
                'rel_type_id'      => '1',
                't_state_id'       => '3',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades da relação Entidade apoios??
            [

                'id'               => '58',
                'ent_type_id'      => NULL,
                'rel_type_id'      => '2',
                't_state_id'       => '3',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '59',
                'ent_type_id'      => NULL,
                'rel_type_id'      => '3',
                't_state_id'       => '3',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '10',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],

            //Propriedades de concurso (abertura)
            [

                'id'               => '60',
                'ent_type_id'      => '8',
                'rel_type_id'      => NULL,
                't_state_id'       => '3',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '61',
                'ent_type_id'      => '8',
                'rel_type_id'      => NULL,
                't_state_id'       => '3',
                'value_type'       => 'text',
                'form_field_type'  => 'text',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '100',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],



            //Propriedades de concurso (avaliação)
            [

                'id'               => '62',
                'ent_type_id'      => '9',
                'rel_type_id'      => NULL,
                't_state_id'       => '3',
                'value_type'       => 'bool',
                'form_field_type'  => 'radio',
                'unit_type_id'     => NULL,
                'form_field_order' => '2',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '63',
                'ent_type_id'      => '9',
                'rel_type_id'      => NULL,
                't_state_id'       => '3',
                'value_type'       => 'int',
                'form_field_type'  => 'number',
                'unit_type_id'     => NULL,
                'form_field_order' => '1',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => '1',
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ],
            [

                'id'               => '64',
                'ent_type_id'      => '9',
                'rel_type_id'      => NULL,
                't_state_id'       => '3',
                'value_type'       => 'enum',
                'form_field_type'  => 'selectbox',
                'unit_type_id'     => NULL,
                'form_field_order' => '3',
                'mandatory'        => '1',
                'state'            => 'active',
                'fk_ent_type_id'   => NULL,
                'fk_property_id'   => NULL,
                'form_field_size'  => NULL,
                'can_edit'         => '1',
                'updated_by'       => '1',
                'deleted_by'       => NULL

            ]
        ];

        foreach ($dados as $value) {
            Property::create($value);
        }
    }
}
