<?php

namespace App\Http\Controllers;

//Bibliotecas para usar o validator
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\MessageBag;

use Illuminate\Http\Request;
use App\Property;
use App\PropertyName;
use App\PropUnitType;
use App\RelType;
use Illuminate\Support\Facades\Log;

class PropertiesOfRelationsController extends Controller {

    public function getAllPropertiesOfRelations() {

        return view('propertiesOfRelations');
    }

    public function insertPropsRel(Request $request) {

        try {
            $data = $request->all();

            $propertyFieldSize = '';
            if(isset($data["property_fieldType_rel"])) {
                if ($data["property_fieldType_rel"] === "text") {
                    $propertyFieldSize = 'required|integer';
                } else if ($data["property_fieldType_rel"] === "textbox") {
                    $propertyFieldSize = 'required|regex:[[0-9]{2}x[0-9]{2}]';
                }
            }

            $rulesFieldType = ['required'];

            if(isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'text') {
                $rulesFieldType = ['required', Rule::in(['text','textbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'bool') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'enum') {
                $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'ent_ref') {
                $rulesFieldType = ['required', Rule::in(['selectbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'prop_ref') {
                $rulesFieldType = ['required', Rule::in(['selectbox']),];
            } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'file') {
                $rulesFieldType = ['required', Rule::in(['file']),];
            }else {
                $rulesFieldType = ['required', Rule::in(['number']),];
            }

            $rules = [
                'relation_type'           => ['required', 'integer'],
                'property_name_rel'       => ['required', 'string'],
                'property_valueType_rel'  => ['required'],
                'property_fieldType_rel'  => $rulesFieldType,
                'property_mandatory_rel'  => ['required'],
                'units_name'              => ['integer'],
                'property_fieldSize_rel'  => $propertyFieldSize,
                'property_state_rel'      => ['required'],
            ];

            $err = Validator::make($data, $rules);
            // Verificar se existe algum erro.
            if ($err->fails()) {
                // Se existir, então retorna os erros
                $result = $err->errors()->messages();
                return response()->json(['error' => $result], 400);
            }

            if(!isset($data['units_name']) || (isset($data['units_name']) && $data['units_name'] == "0")) {
                $data['units_name'] = NULL;
            }

            //Buscar o nr de propriedades de uma relação, porque o form_field_size vai ser o nr de props que tem +1
            $countPropRel = Property::where('rel_type_id', '=', $data['relation_type'])->count();

            $data1 = array(
                'rel_type_id'      => $data['relation_type'          ],
                'value_type'       => $data['property_valueType_rel' ],
                'form_field_type'  => $data['property_fieldType_rel' ],
                'unit_type_id'     => $data['units_name'             ],
                'form_field_order' => $countPropRel + 1,
                'form_field_size'  => $data['property_fieldSize_rel' ],
                'mandatory'        => $data['property_mandatory_rel' ],
                'state'            => $data['property_state_rel'     ],
                'can_edit'         => '1'
            );

            $newProp   = Property::create($data1);
            // pegar o id da nova propriedade inserida
            $idNewProp = $newProp->id;

            //Criar o form_field_name
            //Obter o nome da relação onde a propriedade vai ser inserida
            $relation        = RelType::find($data['relation_type']);
            $relationName    = $relation->language->first()->pivot->name;


            $rel             = substr($relationName, 0 , 3);
            $dash            = '-';
            $fieldName       = preg_replace('/[^a-z0-9_ ]/i', '', $data['property_name_rel']);
            // Substituimos todos pos espaços por underscore
            $fieldName       = str_replace(' ', '_', $fieldName);
            $form_field_name = $rel.$dash.$data['relation_type'].$dash.$fieldName;


            // inserir o nome da propriedade e o nome do campo form_field_name
            $data = [
                'property_id'     => $idNewProp,
                'language_id'     => 1,
                'name'            => $data['property_name_rel'],
                'form_field_name' => $form_field_name
            ];
            PropertyName::create($data);

            return response()->json([]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred. Try later.'], 500);
        }

    }

    public function updatePropsRel(Request $request, $id) {

        $data = $request->all();

        $propertyFieldSize = '';
        if(isset($data["property_fieldType_rel"])) {
            if ($data["property_fieldType_rel"] === "text") {
                $propertyFieldSize = 'required|integer';
            } else if ($data["property_fieldType_rel"] === "textbox") {
                $propertyFieldSize = 'required|regex:[[0-9]{2}x[0-9]{2}]';
            }
        }

        $rulesFieldType = ['required'];

        if(isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'text') {
            //$rulesFieldType = 'required|regex:((text)|(textbox))';
            $rulesFieldType = ['required', Rule::in(['text','textbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'bool') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'enum') {
            $rulesFieldType = ['required', Rule::in(['radio','selectbox', 'checkbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'ent_ref') {
            $rulesFieldType = ['required', Rule::in(['selectbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'prop_ref') {
            $rulesFieldType = ['required', Rule::in(['selectbox']),];
        } else if (isset($data['property_valueType_rel']) && $data['property_valueType_rel'] == 'file') {
            $rulesFieldType = ['required', Rule::in(['file']),];
        }else {
            $rulesFieldType = ['required', Rule::in(['number']),];
        }

        $rules = [
            'property_name_rel'       => ['required','string' , /*Rule::unique('property_name' , 'name')->where('language_id', '1')->ignore($id, 'property_id')*/],
            'property_state_rel'      => ['required'],
            'property_valueType_rel'  => ['required'],
            'property_fieldType_rel'  => $rulesFieldType,
            'property_mandatory_rel'  => ['required'],
            'units_name'              => ['integer'],
            'property_fieldSize_rel'  => $propertyFieldSize
        ];

        $err = Validator::make($data, $rules);
        // Verificar se existe algum erro.
        if ($err->fails()) {
            // Se existir, então retorna os erros
            $resultado = $err->errors()->messages();
            return response()->json(['error' => $resultado], 400);
        }

        if(!isset($data['units_name']) || (isset($data['units_name']) && $data['units_name'] == "0")) {
            $data['units_name'] = NULL;
        }

        $data1 = array(
            'value_type'       => $data['property_valueType_rel' ],
            'form_field_type'  => $data['property_fieldType_rel' ],
            'unit_type_id'     => $data['units_name'             ],
            'form_field_size'  => $data['property_fieldSize_rel' ],
            'mandatory'        => $data['property_mandatory_rel' ],
            'state'            => $data['property_state_rel'     ]
        );

        Property::where('id', $id)
                ->update($data1);


        $dataName = [
            'name' => $data['property_name_rel'],
        ];

        PropertyName::where('property_id', $id)
                    ->where('language_id', 1)
                    ->update($dataName);

        return response()->json([]);
    }

    //Drag and drop methods
    public function getPropsRelations($id) {

        $url_text = 'PT';

        $propsRel = RelType::with(['properties.language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }])
                            ->with(['properties' => function($query) {
                                    $query->orderBy('form_field_order', 'asc');
                                }])
                            ->find($id);

        return response()->json($propsRel);
    }

    public function updateOrderProps(Request $request) {

        $content = $request->all();
        \Log::debug($content);

        if (is_array($content) && count($content) > 0) {
            foreach ($content as $key => $id) {
                Property::where('id', $id)->update(['form_field_order' => ($key + 1)]);
            }
        }

        return response()->json();
    }

    public function getRelations() {

        $url_text = 'PT';

        $allRels = RelType::with(['language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->get();

        \Log::debug("TODAS AS RELAÇÕES");
        \Log::debug($allRels);

        return response()->json($allRels);
    }

    public function remove(Request $request, $idPropRelationType) {

        $property = Property::find($idPropRelationType)->delete();
        if ($property) {
            $result = PropertyName::where('property_id', $idPropRelationType)->delete();
            if ($result) {
                return response()->json();
            }
        }

        return response()->json(['error' => 'An error occurred. Try later.'], 500);
    }


    public function getAll_test(Request $request, $id = null) {

        $data  = $request->all();
        $count = 5;

        // É de acordo com a váriavel 'count' que será apresentado o número de 'rel_types'.
        // Caso seja o 'count' 5, então será apresentado 5 'rel_types' na tabela.
        if (isset($data['count']) && $data['count'] != "") {
            $count = $data['count'];
        }

        // As váriaveis 'colSorting' e 'typeSorting' são utilizadas para ordenar os dados.
        // Por defeito, é ordenado pelo o 'created_at' e por ordem 'desc'.
        $colSorting  = 'created_at';
        $typeSorting = 'desc';
        if (isset($data['colSorting']) && $data['colSorting'] != "" && isset($data['typeSorting']) && $data['typeSorting'] != "") {
            $colSorting  = $data['colSorting'];
            $typeSorting = $data['typeSorting'];
        }

        $dataPropsRel = RelType::leftJoin('rel_type_name', function($query) {
                                    $query->on('rel_type.id', '=', 'rel_type_name.rel_type_id')->where('rel_type_name.language_id', 1);
                                })
                                ->leftJoin('property', function($query) {
                                    $query->on('rel_type.id', '=', 'property.rel_type_id');
                                })
                                ->leftJoin('property_name', function($query){
                                    $query->on('property.id', '=', 'property_name.property_id');
                                })
                                ->leftJoin('prop_unit_type', function($query) {
                                    $query->on('property.unit_type_id', '=', 'prop_unit_type.id');
                                })
                                ->leftJoin('prop_unit_type_name', function($query) {
                                    $query->on('prop_unit_type.id', '=', 'prop_unit_type_name.prop_unit_type_id');
                                })

                                ->select([
                                    'rel_type.id AS rel_id',
                                    'rel_type_name.name AS relation_name',
                                    'property.*',
                                    'property_name.name AS property_name',
                                    'property_name.form_field_name AS form_field_name',
                                    'prop_unit_type.id AS id_unit',
                                    'prop_unit_type_name.name AS unit_name',
                                ])
                                ->searchPropsRel($id, $data)
                                ->orderBy($colSorting, $typeSorting)
                                ->paginate($count)
                                ->toArray();

        \Log::debug($dataPropsRel);

        return response()->json($dataPropsRel);
    }
}
