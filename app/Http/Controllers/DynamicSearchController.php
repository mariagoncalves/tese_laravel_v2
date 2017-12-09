<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\EntType;
use App\PropAllowedValue;
use App\Property;
use App\RelType;
use App\Entity;
use App\Value;
use App\Relation;
use App\Query;
use App\Operator;
use App\Condition;
use App\PropertyCanReadResult;

class DynamicSearchController extends Controller
{
    public function index() {

        return view('dynamicSearch');
    }

    public function getEntities() {

    	$url_text = 'PT';

        $ents = EntType::with(['language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])->get();

        return response()->json($ents);
    }

    public function getEntitiesDetails(Request $request, $id) {

        $dataRequest = $request->all();
        \Log::debug("RESULTADOOO");
        //\Log::debug($dataRequest['pesquisa']);

        $data = ['id' => $id];

        if (isset($dataRequest['query']) && $dataRequest['query'] != "") {

            $data['queryId'] = $dataRequest['query'];

            if (isset($dataRequest['pesquisa']) && $dataRequest['pesquisa'] != "") {

                $data['pesquisa'] = $dataRequest['pesquisa'];

            }
        }

    	return view('entitiesDetails')->with($data);
    }

    public function getEntitiesData($id) {

    	//\Log::debug($id);

    	$url_text = 'PT';

        $ents = EntType::with(['language' => function($query) use ($url_text)  {
        						$query->where('slug', $url_text);
        					}])
        				->with(['properties' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->with(['properties.propAllowedValues.language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->with('properties.fkProperty.values')
        				->with(['properties.language' => function($query) use ($url_text) {
        						$query->where('slug', $url_text);
        					}])->find($id)->toArray();

        \Log::debug("Dados das entidades properties");
        \Log::debug($ents);

        //REVER (quando uma prop ref aponta pra um enum) -- não faz sentido uma prop ref apontar para uma prop enum
        /*foreach ($ents['properties'] as $key => $prop) {
            $propsVal = [];
            if($prop['fk_property_id'] != NULL || $prop['fk_property_id'] != '') {
                foreach ($prop['fk_property']['values'] as $key2 => $value) {

                    if (in_array($value['value'], $propsVal)) {
                        unset($ents['properties'][$key]['fk_property']['values'][$key2]);
                    } else {
                        $propsVal[] = $value['value'];
                        $dataPropAll = PropAllowedValue::with(['language' => function($query) use ($url_text)  {
                                                $query->where('slug', $url_text);
                                            }])->find($value['value']);


                       $ents['properties'][$key]['fk_property']['values'][$key2]['value'] = $dataPropAll->language[0]->pivot->name;
                        //$ents['properties'][$key]['fk_property']['values'][$key2]['value'] = $dataPropAll['language'][0]['pivot']['name'];
                    }
                }
            }
        }*/

        return response()->json($ents);
    }

    public function getOperators() {

        $dataOperators = Operator::all();

        return response()->json($dataOperators);
   }

    public function getEnumValues($id) {

   		$url_text = 'PT';

        $propAllowedValues = PropAllowedValue::with(['language' => function ($query) use ($url_text) {
        											$query->where('slug', $url_text);
        										}])
        									->where('prop_allowed_value.property_id', $id)
        									->get();

        //\Log::debug($propAllowedValues);

        return response()->json($propAllowedValues);
    }

    public function getEntityInstances($entId, $propId) {

        $url_text = 'PT';

        $fkEnt = Property::with(['fkEntType.entity.language' => function($query) use ($url_text) {
        						$query->where('slug', $url_text);
        					}])
        					->where('ent_type_id' , $entId)
        					->where('value_type', 'ent_ref')
        				    ->where('id', $propId)
        				    ->get();

        //\Log::debug($fkEnt);

        return response()->json($fkEnt);
    }

    public function getEntRefs($idEntity) {

        $url_text = 'PT';

        $entRefs = Property::with(['entType.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->where('property.value_type', 'ent_ref')
                            ->where('property.fk_ent_type_id', $idEntity)
                            ->get()->toArray();

        $count        = 0;
        $dadosEntRefs = [];
        foreach ($entRefs as $entRef) {
            $dadosEntRef = $entRef;
            $dadosEntRef['properties'] = [];

            $propsOfEnts = Property::with(['language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->where('ent_type_id', $entRef['ent_type_id'])
                            ->where('value_type', '!=', 'ent_ref') //Evita a verificação na vista
                            ->where('value_type', '!=', 'prop_ref')
                            ->get()->toArray();

            foreach ($propsOfEnts as $key => $prop) {
                $dadosProp = $prop;
                $dadosProp['key'] = $count;
                $dadosEntRef['properties'][] = $dadosProp;

                $count = $count + 1;
            }

            $dadosEntRefs[] = $dadosEntRef;
        }

        return response()->json($dadosEntRefs);
    }

    public function getPropRefs($idEntityType) {

        $propsId      = Property::where('ent_type_id', $idEntityType)->get(['id']);
        $arrayPropsId = [];
        foreach ($propsId as $propId) {
            $arrayPropsId[] = $propId->id;
        }

        \Log::debug("TESTEEEEEEEEEE 1");
        \Log::debug($arrayPropsId);

        $url_text = 'PT';

        $propRefs = Property::with(['entType.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->where('property.value_type', 'prop_ref')
                            ->whereIn('property.fk_property_id', $arrayPropsId)
                            ->get()->toArray();

        \Log::debug("TESTEEEEEEEEEE 2");
        \Log::debug($propRefs);

        $count        = 0;
        $dadosPropRefs = [];
        foreach ($propRefs as $entRef) {
            $dadosPropRef = $entRef;
            $dadosPropRef['properties'] = [];

            $propsOfEnts = Property::with(['language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with(['propAllowedValues.language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->where('ent_type_id', $entRef['ent_type_id'])
                            ->where('value_type', '!=', 'ent_ref') //Evita a verificação na vista
                            ->where('value_type', '!=', 'prop_ref')
                            ->get()->toArray();

            foreach ($propsOfEnts as $key => $prop) {
                $dadosProp = $prop;
                $dadosProp['key'] = $count;
                $dadosPropRef['properties'][] = $dadosProp;

                $count = $count + 1;
            }

            $dadosPropRefs[] = $dadosPropRef;
        }

        return response()->json($dadosPropRefs);
        //return response()->json($propRefs);
    }

    public function getRelsWithEnt($id) {

        $url_text = 'PT';

        $relsWithEnt = RelType::with(['language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->with(['properties' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->with(['properties.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->with(['properties.propAllowedValues.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->with('properties.fkProperty.values')
                        ->with(['ent1.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->with(['ent2.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                        ->where(function($query) use ($id){
                            $query->where('ent_type1_id', $id)->orWhere('ent_type2_id', $id);
                        })
                        ->get()
                        ->toArray();

        $count = 0;
        foreach ($relsWithEnt as $key => $rel) {

            foreach ($rel['properties'] as $key1 => $prop) {
                $relsWithEnt[$key]['properties'][$key1]['key'] = $count;
                $count++;
            }
        }

        return response()->json($relsWithEnt);
    }

    public function getEntsRelated($idRelType, $idEntType) {
        $url_text = 'PT';

        $entsRelated = RelType::where(function ($query) use ($idEntType) {
                                $query->where('ent_type1_id', $idEntType)->orWhere('ent_type2_id', $idEntType);
                            })
                            ->with(['language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with(['ent1.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with(['ent2.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->get()
                            ->toArray();

        $newKey = 0;
        foreach ($entsRelated as $key => $value) {
            $ent_type_id = '';
            if ($value['ent_type1_id'] == $idEntType) {
                $ent_type_id = $value['ent_type2_id'];
            } else {
                $ent_type_id = $value['ent_type1_id'];
            }

            $properties = Property::with(['language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with(['propAllowedValues.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with('fkProperty.values')
                            ->where('ent_type_id', $ent_type_id)
                            ->with('entType')
                            ->get()->toArray();

            foreach ($properties as $key1 => $value) {
                $properties[$key1]['key'] = $newKey;
                $newKey++;
            }

            $entsRelated[$key]['properties'] = $properties;
        }

        //\Log::debug($entsRelated);
        return response()->json($entsRelated);
    }

    /*public function createCondition($idQuery, $idProperty, $type, $position, $data) {

        $property = $this->getPropertyData($idProperty);
        $valueType = $property->value_type;

        $idOperator = Operator::where('operator_type', '=')
                                ->select(['id'])
                                ->first();

        $valueQuery    = '';
        $idVal         = NULL;
        $operatorQuery = $idOperator->id;

        if ($valueType == "int") {
            $valueQuery    = $data['int'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
        }  else if ($valueType == "double") {
            $valueQuery    = $data['double'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
        } else  if ($valueType == "text") {
            $valueQuery = $data['text'.$type.$position];
        } else  if ($valueType == "enum") {
            
            $idVal = $data['select'.$type.$position];

            $url_text = 'PT';

            $dataPropAllowed = PropAllowedValue::with(['language' => function ($query) use ($url_text) {
                                                    $query->where('slug', $url_text);
                                                }])->find($idVal);

            $valueQuery = $dataPropAllowed['language'][0]['pivot']['name'];

        } else  if ($valueType == "bool") {
            if (!isset($data['radio'.$type.$position])) {
                $valueQuery = '';
            } else {

                $idVal = $data['radio'.$type.$position];

                if ($idVal == '1') {
                    $valueQuery = "Sim";
                } else {
                    $valueQuery = "Não";
                }
            }
        } else if ($valueType == "prop_ref") {
            $idVal = $data['propRef'.$type.$position];

            $dataVal = Value::find($idVal);
            $valueQuery = $dataVal['value'];
        } else if ($valueType == "file") {

            $idVal = NULL;
            $valueQuery = $data['file'.$type.$position];
            \Log::debug("VALOR QUANDO É FILE");
            //\Log::debug($valueQuery);
        }

        if($operatorQuery == "") {

            $operatorQuery = $idOperator->id;
        }

        $data1 = array(
            'query_id'    => $idQuery,
            'operator_id' => $operatorQuery,
            'property_id' => $idProperty,
            'table_type'  => $type,
            'value'       => $valueQuery,
            'id_values'   => $idVal
        );

        $dataCondition = Condition::create($data1);

        $dataPropertyResult = array(
            'reading_property' => $idProperty,
            'providing_result' => $idQuery,
            'output_type'      => 'accordion',
            );

        $dataPropertyReadResult = PropertyCanReadResult::create($dataPropertyResult);

    }*/

    public function createCondition($idQuery, $idProperty, $type, $position, $data) {

        $property = $this->getPropertyData($idProperty);
        $valueType = $property->value_type;

        $idOperator = Operator::where('operator_type', '=')
                                ->select(['id'])
                                ->first();

        $valueQuery    = NULL;
        $idVal         = NULL;
        $idPropAllowed = NULL;
        $operatorQuery = $idOperator->id;

        if ($valueType == "int") {
            $valueQuery    = $data['int'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
        }  else if ($valueType == "double") {
            $valueQuery    = $data['double'.$type.$position];
            $operatorQuery = $data['operators'.$type.$position];
        } else  if ($valueType == "text") {
            $valueQuery = $data['text'.$type.$position];
        } else  if ($valueType == "enum") {

            $idPropAllowed = $data['select'.$type.$position];
            $idVal         = NULL;

            $url_text = 'PT';

            $dataPropAllowed = PropAllowedValue::with(['language' => function ($query) use ($url_text) {
                                                    $query->where('slug', $url_text);
                                                }])->find($idPropAllowed);

            $valueQuery = $dataPropAllowed['language'][0]['pivot']['name'];

        } else  if ($valueType == "bool") {
            if (!isset($data['radio'.$type.$position])) {
                $valueQuery = NULL;
            } else {

                $radioVal = $data['radio'.$type.$position];
                \Log::debug("Valor do radio");
                \Log::debug($radioVal);

                if ($radioVal == '1') {
                    $valueQuery = 1;
                } else {
                    $valueQuery = 0;
                }
            }
        } else if ($valueType == "prop_ref") {
            $idVal = $data['propRef'.$type.$position];
            $dataVal = Value::find($idVal);
            $valueQuery = $dataVal['value'];
        } else if ($valueType == "file") {

            $idVal = NULL;
            $valueQuery = $data['file'.$type.$position];
            \Log::debug("VALOR QUANDO É FILE");
            //\Log::debug($valueQuery);
        }

        if($operatorQuery == "") {

            $operatorQuery = $idOperator->id;
        }

        $data1 = array(
            'query_id'    => $idQuery,
            'operator_id' => $operatorQuery,
            'property_id' => $idProperty,
            'table_type'  => $type,
            'value'       => $valueQuery,
            //'id_values'   => $idVal,
            'value_id'    => $idVal,
            'prop_allowed_value_id' => $idPropAllowed
            
        );

        $dataCondition = Condition::create($data1);

        $dataPropertyResult = array(
            'reading_property' => $idProperty,
            'providing_result' => $idQuery,
            'output_type'      => 'accordion',
            );

        $dataPropertyReadResult = PropertyCanReadResult::create($dataPropertyResult);

    }

    public function saveSearch (Request $request, $idEntityType) {

        \Log::debug("Tá a chegar ao método");
        $data = $request->all();
        \Log::debug("Teste ao salvar pesquisa");
        \Log::debug($data);

        $data1 = array(
                'name'      => $data['query_name'],
                'ent_type_id' => $idEntityType
            );

        $dataQuery = Query::create($data1);
        $idQuery   = $dataQuery->id;

        for ($i=0; $i < $data['numTableET']; $i++) {
            if (isset($data['checkET'.$i])) {
                $this->createCondition($idQuery, $data['checkET'.$i], 'ET', $i, $data);
            }
        }

        for ($i = 0; $i < $data['numTableVT']; $i++) {
            if (isset($data['checkVT'.$i])) {
                $this->createCondition($idQuery, $data['checkVT'.$i], 'VT', $i, $data);
            }
        }

        for ($i = 0; $i < $data['numTableRL']; $i++) {
            if (isset($data['checkRL'.$i])) {
                $this->createCondition($idQuery, $data['checkRL'.$i], 'RL', $i, $data);
            }
        }

        for ($i = 0; $i < $data['numTableER']; $i++) {
            if (isset($data['checkER'.$i])) {
                $this->createCondition($idQuery, $data['checkER'.$i], 'ER', $i, $data);
            }
        }
    }

    public function search(Request $request, $idEntityType) {
        $data        = $request->all();
        $generalData = [
            'table1' => ['select' => false, 'properties' => [], 'resultEntities' => [], 'relTable2' => [], 'relTable3' => [], 'relTable4' => []],
            'table2' => ['select' => false, 'properties' => [], 'resultEntities' => []],
            'table3' => ['select' => false, 'properties' => [], 'resultRelation' => []],
            'table4' => ['select' => false, 'properties' => [], 'resultEntities' => []]
        ];
        $url_text    = 'PT';
        $result      = [];
        $query       = [];

        /*if (isset($data['query_name']) && $data['query_name'] != "") {
            $this->registarQueryPesquisa($data, $idEntityType);
        }*/

        //Formar a frase e realizar pesquisa de acordo com a pesquisa..
        $phrase = $this->formPhraseAndQuery($idEntityType, $data, $generalData);
        $result['phrase'] = $phrase;

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (GERAL PESQUISA): ");

        $resultsTables['result1'] = [];
        if ($generalData['table1']['select']) {
            $resultsTables['result1'] = $this->getValuesEntitiesTables($generalData['table1']['properties'], $generalData['table1']['resultEntities']);
        }

        $resultsTables['result2'] = [];
        if ($generalData['table2']['select']) {
            $resultsTables['result2'] = $this->getValuesEntitiesTables($generalData['table2']['properties'], $generalData['table2']['resultEntities']);
        }

        $resultsTables['result3'] = [];
        if ($generalData['table3']['select']) {
            $resultsTables['result3'] = $this->getValuesRelationTables($generalData['table3']['properties'], $generalData['table3']['resultRelation']);
        }

        $resultsTables['result4'] = [];
        if ($generalData['table4']['select']) {
            $resultsTables['result4'] = $this->getValuesEntitiesTables($generalData['table4']['properties'], $generalData['table4']['resultEntities']);
        }

        \Log::debug($generalData);
        $result['result'] = $this->organizeDataTable($generalData, $resultsTables);

        \Log::debug("Dados enviados para a vista");
        \Log::debug($result);
        return response()->json($result);
    }

    public function organizeDataTable($generalData, $resultsTables) {
        $resultFinal = [];
        if ($generalData['table1']['select'] && $generalData['table4']['select']) { // Tabela 1 e 4
            // Percorrer as entidades da tabela 1
            foreach ($resultsTables['result1'] as $entity) {

                //$relations = $generalData['table1']['relTable4'][$entity['id']] ?? [];
                $relations = isset($generalData['table1']['relTable4'][$entity['id']]) ? $generalData['table1']['relTable4'][$entity['id']] : [];
                foreach ($relations as $idRelation) {
                    $valuesDataResult = [];
                    // Cada value da entidade da tabela 1
                    foreach ($entity['values'] as $valueData) {
                        $valuesDataResult[] = $valueData;
                    }

                    // Percorrer as relacoes da tabela 4
                    foreach ($resultsTables['result4'] as $dataRelation) {
                        if ($dataRelation['id'] == $idRelation) {
                            // Cada value da relação da tabela 3
                            foreach ($dataRelation['values'] as $valueData2) {
                                $valuesDataResult[] = $valueData2;
                            }
                        }
                    }

                    $resultFinal[] = $valuesDataResult;
                }
            }
        } else if ($generalData['table1']['select'] && $generalData['table3']['select']) { // Tabela 1 e 3
            // Percorrer as entidades da tabela 1
            foreach ($resultsTables['result1'] as $entity) {

                //$relations = $generalData['table1']['relTable3'][$entity['id']] ?? [];
                $relations = isset($generalData['table1']['relTable3'][$entity['id']]) ? $generalData['table1']['relTable3'][$entity['id']] : [];
                foreach ($relations as $idRelation) {
                    $valuesDataResult = [];
                    // Cada value da entidade da tabela 1
                    foreach ($entity['values'] as $valueData) {
                        $valuesDataResult[] = $valueData;
                    }

                    // Percorrer as relacoes da tabela 3
                    foreach ($resultsTables['result3'] as $dataRelation) {
                        if ($dataRelation['id'] == $idRelation) {
                            // Cada value da relação da tabela 3
                            foreach ($dataRelation['values'] as $valueData2) {
                                $valuesDataResult[] = $valueData2;
                            }
                        }
                    }

                    //Porque não tava a vir o cabeçalho da tabela
                    if (count($valuesDataResult) > 0) {
                        $resultFinal[] = $valuesDataResult;
                    }
                }
            }
        } else if ($generalData['table1']['select'] && $generalData['table2']['select']) { // Tabela 1 e 2
            // Percorrer as entidades da tabela 1
            foreach ($resultsTables['result1'] as $entity) {

                //$relations = $generalData['table1']['relTable2'][$entity['id']] ?? [];
                $relations = isset($generalData['table1']['relTable2'][$entity['id']]) ? $generalData['table1']['relTable2'][$entity['id']] : [];
                foreach ($relations as $idEntityRelation) {
                    $valuesDataResult = [];
                    // Cada value da entidade da tabela 1
                    foreach ($entity['values'] as $valueData) {
                        $valuesDataResult[] = $valueData;
                    }

                    // Percorrer as entidades da tabela 2
                    foreach ($resultsTables['result2'] as $entity2) {
                        if ($entity2['id'] == $idEntityRelation) {
                            // Cada value da entidade da tabela 2
                            foreach ($entity2['values'] as $valueData2) {
                                $valuesDataResult[] = $valueData2;
                            }
                        }
                    }

                    //Porque não tava a vir o cabeçalho da tabela
                    if (count($valuesDataResult) > 0) {
                        $resultFinal[] = $valuesDataResult;
                    }
                }
            }
        } else if ($generalData['table1']['select']) { // Tabela 1

            \Log::debug("DADOS DA 1º TABELA");
            \Log::debug($resultsTables['result1']);
            // Percorrer as entidades
            foreach ($resultsTables['result1'] as $entity) {
                $valuesDataResult = [];
                // Cada value da entidade
                foreach ($entity['values'] as $valueData) {
                    $valuesDataResult[] = $valueData;
                }

                //Porque não tava a vir o cabeçalho da tabela
                if (count($valuesDataResult) > 0) {
                    $resultFinal[] = $valuesDataResult;
                }
            }
        }

        return $resultFinal;
    }

    public function getValuesEntitiesTables($properties, $entities) {

        \Log::debug("PROPRIEDADES VALORES");
        \Log::debug($properties);


        $url_text = 'PT';
        $result = Entity::with('values')
                        ->with(['values.property.language' => function($query) use ($url_text) {
                            $query->where('slug', $url_text);
                        }])
                        ->with(['values' => function($qu1) use ($properties) {
                            $qu1->whereIn('property_id', $properties);
                        }])->OrWhere(function($q3) use ($entities) {
                            $q3->whereIn('id', $entities);
                        })->get()->toArray();

        \Log::debug("RESULTADO METODOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOOO");
        \Log::debug($result);

        $resultFinal = $this->getNames($result);

        return $resultFinal;
    }

    //Para aparecer o nome em vez do id
    public function getNames($result) {

        $url_text = 'PT';

        foreach ($result as $key => $entity) {
            foreach ($entity['values'] as $key1 => $value) {

                if ($value['property']['value_type'] == 'enum') {

                    $dataProp = PropAllowedValue::with(['language' => function($query) use ($url_text) {
                                                    $query->where('slug', $url_text);
                                                }])
                                                ->find($value['value']);

                    $result[$key]['values'][$key1]['value'] = $dataProp['language'][0]['pivot']['name'];

                } else if ($value['property']['value_type'] == 'prop_ref') {

                    $dataProp = Value::find($value['value']);

                    $result[$key]['values'][$key1]['value'] = $dataProp['value'];

                } else if ($value['property']['value_type'] == 'bool') {

                    if ($value['value'] == '1') {
                        $result[$key]['values'][$key1]['value'] = trans("dynamicSearch/messages.TRUE");
                    } else {
                        $result[$key]['values'][$key1]['value'] = trans("dynamicSearch/messages.FALSE");
                    }
                }
            }
        }

        return $result;
    }

    public function getValuesRelationTables($properties, $relations) {
        $url_text = 'PT';
        $result = Relation::with('values')
                        ->with(['values.property.language' => function($query) use ($url_text) {
                            $query->where('slug', $url_text);
                        }])
                        ->with(['values' => function($qu1) use ($properties) {
                            $qu1->whereIn('property_id', $properties);
                        }])->OrWhere(function($q3) use ($relations) {
                            $q3->whereIn('id', $relations);
                        })->get()->toArray();

        $resultFinal = $this->getNames($result);

        return $resultFinal;
    }

    public function formPhraseAndQuery($idEntityType, $data, &$generalData) {
        $url_text = 'PT';

        $ent = EntType::with(['language' => function($q) use ($url_text) {
                        $q->where('slug', $url_text);
                    }])->find($idEntityType);

        $phrase[] = trans("dynamicSearch/messages.SEARCH_PHRASE_GEN")." ".$ent->language->first()->pivot->name;

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 1): ");

        // Formar a frase da tabela 1 e pesquisar de acordo com a pesquisa efetuada na tabela 1
        $queryTable1 = new Entity;
        for ($i=0; $i < $data['numTableET']; $i++) {
            if (isset($data['checkET'.$i])) {
                $generalData['table1']['select']       = true;
                $generalData['table1']['properties'][] = $data['checkET'.$i];
                $phrase = $this->formPhraseTableType($data, $data['checkET'.$i], 'ET', $i, $phrase);

                $this->formQueryTable($data, $data['checkET'.$i], 'ET', $i, $queryTable1);
            }
        }

        if ($generalData['table1']['select']) {
            $resultTable1 = $queryTable1->where('ent_type_id', $idEntityType)->distinct('id')->get(['id'])->toArray();
            $generalData['table1']['resultEntities'] = $this->formatArrayData($resultTable1, 'id');
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 2): ");

        // Formar a frase da tabela 2
        $queryTable2 = new Entity;
        for ($i = 0; $i < $data['numTableVT']; $i++) {
            if (isset($data['checkVT'.$i])) {
                $generalData['table2']['select']       = true;
                $generalData['table2']['properties'][] = $data['checkVT'.$i];
                $phrase = $this->formPhraseTableType($data, $data['checkVT'.$i], 'VT', $i, $phrase);

                $this->formQueryTable($data, $data['checkVT'.$i], 'VT', $i, $queryTable2);
            }
        }

        if ($generalData['table2']['select']) {
            $propertiesTable1 = $this->getPropertiesEntities($generalData['table1']['resultEntities']);

            $relacaoEntreTable1e2 = [];
            $resultTable2 = $queryTable2->distinct('id')->get(['id'])->toArray();

            $entitiesIdsTable2 = $this->formatArrayData($resultTable2, 'id');

            foreach ($entitiesIdsTable2 as $key => $id_entity2) {

                $values = Value::with('property')->where('entity_id', $id_entity2)->get();

                \Log::debug("VALORESSSSSS TESTEEEEEEEEEEEEEEEEEEE");
                \Log::debug($values);

                foreach ($values as $valueData) {
                    if (in_array($valueData->property->fk_property_id, $propertiesTable1)) {

                        foreach ($generalData['table1']['resultEntities'] as $id_entity1) {

                            $textValue = Value::find($valueData->value)->value;

                            $values = Value::where('entity_id', $id_entity1)
                                        ->where('value', $textValue)
                                        ->where('property_id', $valueData->property->fk_property_id)
                                        ->count();

                            if ($values > 0) {
                                $generalData['table1']['relTable2'][$id_entity1][] = $id_entity2;
                                $generalData['table2']['resultEntities'][] = $id_entity2;
                            }
                        }
                    }
                }
            }
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 3): ");

        $queryTable3 = new Relation;
        // Formar a frase da tabela 3
        for ($i=0; $i < $data['numTableRL']; $i++) {
            if (isset($data['checkRL'.$i])) {
                $generalData['table3']['select'] = true;
                $generalData['table3']['properties'][] = $data['checkRL'.$i];
                $phrase = $this->formPhraseTableType($data, $data['checkRL'.$i], 'RL', $i, $phrase);

                $this->formQueryTable($data, $data['checkRL'.$i], 'RL', $i, $queryTable3);
            }
        }

        if ($generalData['table3']['select']) {
            //Trazia todos os dados da relaçlão mas especifiquei que só quero o entity1_id e entity2_id
            $resultTable3 = $queryTable3->distinct('id')->get(['id', 'entity1_id', 'entity2_id'])->toArray();

            $entitiesIdsTable3 = [];
            foreach ($resultTable3 as $key => $value) {
                $generalData['table3']['resultRelation'][] = $value['id'];
                //Para não meter valores repetidos no array
                if(!in_array($value['entity1_id'], $entitiesIdsTable3)) {
                    $entitiesIdsTable3[] = ['id_entity' => $value['entity1_id'], 'id_relation' => $value['id']];
                }

                if(!in_array($value['entity2_id'], $entitiesIdsTable3)) {
                    $entitiesIdsTable3[] = ['id_entity' => $value['entity2_id'], 'id_relation' => $value['id']];
                }
            }

            if ($generalData['table1']['select']) {
                $newIdsTable1 = [];
                foreach ($entitiesIdsTable3 as $dataRel) {
                    if (in_array($dataRel['id_entity'], $generalData['table1']['resultEntities'])) {
                        $newIdsTable1[] = $dataRel['id_entity'];
                        $generalData['table1']['relTable3'][$dataRel['id_entity']][] = $dataRel['id_relation'];
                    }
                }
                $generalData['table1']['resultEntities'] = $newIdsTable1;
            }
        }

        \Log::debug("DADOS TESEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEEE (TABELA 4): ");

        $queryTable4 = new Entity;
        // Formar a frase da tabela 4
        for ($i=0; $i < $data['numTableER']; $i++) {
            if (isset($data['checkER'.$i])) {
                $generalData['table4']['select'] = true;
                $generalData['table4']['properties'][] = $data['checkER'.$i];
                $phrase = $this->formPhraseTableType($data, $data['checkER'.$i], 'ER', $i, $phrase);

                $this->formQueryTable($data, $data['checkER'.$i], 'ER', $i, $queryTable4);

                if (isset($data['idEntTypeER'.$i])) {
                    $queryTable4 = $queryTable4->where('ent_type_id', $data['idEntTypeER'.$i]);
                }
            }
        }

        if ($generalData['table4']['select']) {
            //\Log::debug($generalData['table1']['resultEntities']);
            //Trazia todos os dados da entidade mas especifiquei que só quero o id
            $resultTable4     = $queryTable4->distinct('id')->get(['id'])->toArray();
            $entitiesIdsTable4 = $this->formatArrayData($resultTable4, 'id');

            //\Log::debug("TESTEE FINAL 1122: ");
            //\Log::debug($entitiesIdsTable4);

            $newIdsTable1 = [];
            $newIdsTable4 = [];
            foreach ($generalData['table1']['resultEntities'] as $entity1) {

                foreach ($entitiesIdsTable4 as $entity2) {
                    $relation = Relation::where(function($qy) use ($entity1, $entity2) {
                                            $qy->where('entity1_id', $entity1)->where('entity2_id', $entity2);
                                        })->OrWhere(function($qy) use ($entity1, $entity2) {
                                            $qy->where('entity1_id', $entity2)->where('entity2_id', $entity1);
                                        })->first();

                    if ($relation) {
                        $newIdsTable1[] = $entity1;
                        if (isset($generalData['table1']['relTable4'][$entity1])) {
                            if (!in_array($relation->id, $generalData['table1']['relTable4'][$entity1])) {
                                $generalData['table1']['relTable4'][$entity1][] = $entity2;
                            }
                        } else {
                            $generalData['table1']['relTable4'][$entity1][] = $entity2;
                        }
                        $newIdsTable4[] = $entity2;
                    }
                }
            }
            $generalData['table1']['resultEntities'] = $newIdsTable1;
            $generalData['table4']['resultEntities'] = $newIdsTable4;
        }

        return $phrase;
    }

    public function formPhraseTableType($data, $idProperty, $type, $position, $phrase) {
        $property = $this->getPropertyData($idProperty);

        $nameProp  = $property->language->first()->pivot->name;
        $valueType = $property->value_type;

        if ($type == 'ET') {
            $auxPhrase  = trans("dynamicSearch/messages.SEARCH_PHRASE_T1")." ".$nameProp." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T1_A")." ";
        } elseif ($type == 'VT') {
            $nameEntity = $property->entType->language->first()->pivot->name;
            $auxPhrase = trans("dynamicSearch/messages.SEARCH_PHRASE_T2")." ".$nameEntity." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T2_A")." ".$nameProp." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T1_A")." ";
        } else {
            if ($property->relType) {
                $nameEntType1 = $this->getNameEntType($property->relType->ent_type1_id);
                $nameEntType2 = $this->getNameEntType($property->relType->ent_type2_id);

                if ($type == 'RL') {
                    $auxPhrase = trans("dynamicSearch/messages.SEARCH_PHRASE_T3")." ".$nameEntType1." - ".$nameEntType2." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T2_A")." ".$nameProp." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T1_A")." ";

                } else {
                    $auxPhrase = trans("dynamicSearch/messages.SEARCH_PHRASE_T4")." ".$nameEntType2." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T2_A")." ".$nameProp." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T1_A")." ";

                }
            } else {
                $auxPhrase  = trans("dynamicSearch/messages.SEARCH_PHRASE_T4_A")." ".$nameProp." ".trans("dynamicSearch/messages.SEARCH_PHRASE_T1_A")." ";
            }
        }

        //Construir a frase conforme o value_type
        $valueQuery    = '';

        if(isset($data['operators'.$type.$position]) && $data['operators'.$type.$position] != "" ) {
            $operatorQuery = $this->getOperatorSymbol($data['operators'.$type.$position]);
        } else {
            $operatorQuery = '=';
        }

        if ($valueType == "int") {
            $valueQuery    = $data['int'.$type.$position];
            // Formar a frase
            $phrase[] = $auxPhrase . ($valueQuery == '' ? trans("dynamicSearch/messages.ANY") : $operatorQuery.' '.$valueQuery).';';
        }  else if ($valueType == "double") {
            $valueQuery    = $data['double'.$type.$position];
            // Formar a frase
            $phrase[] = $auxPhrase . ($valueQuery == '' ? trans("dynamicSearch/messages.ANY") : $operatorQuery.' '.$valueQuery) . ';';
        } else  if ($valueType == "text") {
            $valueQuery = $data['text'.$type.$position];
            // Formar a frase
            $phrase[] = $auxPhrase . ($valueQuery == '' ? trans("dynamicSearch/messages.ANY") : $valueQuery).';';
        } else  if ($valueType == "enum") {
            //$valueQuery = $data['select'.$type.$position];

            $idPropAllowedValue = $data['select'.$type.$position];

            $url_text = 'PT';

            $propAllowed = PropAllowedValue::with(['language' => function($query) use ($url_text) {
                                                    $query->where('slug', $url_text);
                                                }])
                                                ->find($idPropAllowedValue);

            $valueQuery = $propAllowed['language'][0]['pivot']['name'];

            // Formar a frase
            $phrase[] = $auxPhrase . ($valueQuery == '' ? trans("dynamicSearch/messages.ANY") : $valueQuery).';';
        } else  if ($valueType == "bool") {

            if(!isset($data['radio'.$type.$position])) {
                $valueQuery = '';
            } else {

                $valueRadio = $data['radio'.$type.$position];
                \Log::debug("Valor do radio 2");
                \Log::debug($valueRadio);

                if ($valueRadio == 0) {
                    $valueQuery = trans("dynamicSearch/messages.FALSE");
                } else {
                    $valueQuery = trans("dynamicSearch/messages.TRUE");
                }
            }
            // Formar a frase
            $phrase[] = $auxPhrase . ($valueQuery == '' ? trans("dynamicSearch/messages.ANY") : $valueQuery).';';
        } else if ($valueType == "prop_ref") {


            $idValue = $data['propRef'.$type.$position];

            \Log::debug( $idValue);
            $dataVal = Value::find($idValue);
            $valueQuery = $dataVal['value'];
            // Formar a frase
            $phrase[] = $auxPhrase . ($valueQuery == '' ? trans("dynamicSearch/messages.ANY") : $valueQuery).';';
        }

        return $phrase;
    }

    public function formQueryTable($data, $idProperty, $type, $position, &$queryTable1) {
        $url_text = 'PT';

        $property  = $this->getPropertyData($idProperty);
        $valueType = $property->value_type;

        $valueQuery    = '';
        $operatorQuery = '=';
        if ($valueType == "int") {
            $valueQuery    = $data['int'.$type.$position];
            $operatorQuery = $this->getOperatorSymbol($data['operators'.$type.$position]);
        }  else if ($valueType == "double") {
            $valueQuery    = $data['double'.$type.$position];
            $operatorQuery = $this->getOperatorSymbol($data['operators'.$type.$position]);
        } else  if ($valueType == "text") {
            $operatorQuery = 'LIKE';
            $valueQuery = '%'.$data['text'.$type.$position].'%';
        } else  if ($valueType == "enum") {
            $valueQuery = $data['select'.$type.$position];
            \Log::debug("Valor colocado no enum");
            \Log::debug($valueQuery);
        } else  if ($valueType == "bool") {
            if(!isset($data['radio'.$type.$position])) {
                $valueQuery = '';
            } else {
                $valueQuery = $data['radio'.$type.$position];
            }
        } else if ($valueType == "prop_ref") {
             \Log::debug("VALOR DO PROP REF QUERY");
            \Log::debug($data['propRef'.$type.$position]);
            $valueQuery    = $data['propRef'.$type.$position];
        }

        if ($operatorQuery == '~') {
            $operatorQuery = 'LIKE';
            $valueQuery = '%'.$valueQuery.'%';
        }

        if($valueQuery != "") {
            $queryTable1 = $queryTable1->whereHas('values', function($q) use ($idProperty, $operatorQuery, $valueQuery) {
                                        $q->where('property_id', $idProperty)->where('value', $operatorQuery, $valueQuery);
                                    });
        }
    }

    /*public function getPropAllowedValueName($idPropAllowed) {

        $url_text = 'PT';

        $namePropAllowed = PropAllowedValue::with(['language' => function($query) use ($url_text) {
                                                $query->where('slug', $url_text);
                                            }])
                                            ->find($idPropAllowed)
                                            ->toArray();

        \Log::debug("VALOR DO propAllowedValue");
        \Log::debug($namePropAllowed);

        return $namePropAllowed;
    }*/

    public function getOperatorSymbol($idOperator) {
        $operatorSymbol = Operator::where('id', $idOperator)
                                    ->select(['operator_type'])
                                    ->first();

        if ($operatorSymbol) {
            return $operatorSymbol->operator_type;
        } else {
            return '=';
        }
   }

    public function formatArrayData($data, $keySelect) {
        $array = [];
        foreach ($data as $value) {
            $array[] = $value[$keySelect];
        }

        return $array;
    }

    public function getPropertiesEntities($idsEntities = []) {
        $result = [];
        if (is_array($idsEntities) && count($idsEntities) > 0) {
            foreach ($idsEntities as $idEntity) {
                $properties = Value::where('entity_id', $idEntity)
                                    ->select(['property_id'])
                                    ->get();

                foreach ($properties as $property) {
                    if (!in_array($property->property_id, $result)) {
                        $result[] = $property->property_id;
                    }
                }
            }
        }

        return $result;
    }

    public function getPropertyData($idProperty) {
        $url_text = 'PT';

        $property = Property::with(['language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with(['entType' => function($query) use ($url_text) {
                                $query->with(['language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }]);
                            }])
                            ->with(['relType' => function($query) use ($url_text) {
                                $query->with(['language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }]);
                            }])
                            ->find($idProperty);

        return $property;
    }

    public function getNameEntType($idEntType) {
        $url_text = 'PT';

        $entType = EntType::with(['language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->find($idEntType);

        return $entType->language->first()->pivot->name;
    }

    public function inactiveActive ($idEntity) {

        \Log::debug($idEntity);

        $stateEntity = Entity::where('id', $idEntity)->select(['state'])->first();
        \Log::debug($stateEntity->state);

        /*$stateEntity = Entity::where('id', $idEntity)->get();
        \Log::debug($stateEntity);
        $state = $stateEntity->first()->state;
        \Log::debug($state);*/

        if ($stateEntity->state == 'active') {

            Entity::where('id', $idEntity)
                    ->update(['state' => 'inactive']);
        } else {

           Entity::where('id', $idEntity)
                   ->update(['state' => 'active']);
        }

        return response()->json([$stateEntity->state]);
    }

    public function showSavedSearches () {

        return view('showSavedSearches');
    }

    public function getSavedQueries () {

        $url_text = 'PT';

        $dataQuery = Query::with(['entType.language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with('conditions')
                            ->with(['conditions.property.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with('conditions.operator')
                            ->get();

        \Log::debug($dataQuery);

        return response()->json($dataQuery);
    }

    public function getPropertiesQuery($idQuery, $tableType) {

        \Log::debug("id da query:" .$idQuery. " e " .$tableType);

        $dataCondition = Condition::with('property')
                        ->where('table_type', $tableType)
                        ->where('query_id', $idQuery)
                        ->get();

        \Log::debug("Dados do condition:" .$dataCondition);

        return response()->json($dataCondition);

    }

    //testes ng table saved queries
    public function getAllSavedsQueries(Request $request, $id = null) {

        /*$url_text = 'PT';

        $dataQuery = Query::with(['entType.language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with('conditions')
                            ->with(['conditions.property.language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with('conditions.operator')
                            ->get();

        \Log::debug($dataQuery);

        return response()->json($dataQuery);*/

        \Log::debug("Tou a chegar ao metodoodd");

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

        $dataSavedQuery = Query::leftJoin('ent_type', function($query) {
                                    $query->on('ent_type.id', '=', 'query.ent_type_id');
                                })
                                ->leftJoin('ent_type_name', function($query) {
                                    $query->on('ent_type.id', '=', 'ent_type_name.ent_type_id')->where('ent_type_name.language_id', 1);
                                })
                                ->leftJoin('condition', function($query) {
                                    $query->on('query.id', '=', 'condition.query_id');
                                })
                                ->leftJoin('property', function($query){
                                    $query->on('condition.property_id', '=', 'property.id');
                                })
                                ->leftJoin('property_name', function($query){
                                    $query->on('property.id', '=', 'property_name.property_id')->where('property_name.language_id', 1);;
                                })
                                ->leftJoin('operator', function($query){
                                    $query->on('condition.operator_id', '=', 'operator.id');
                                })
                                ->select([
                                    'query.name AS query_name',
                                    'query.id AS query_id',
                                    'query.created_at AS created_at',
                                    'ent_type.id AS ent_type_id',
                                    'ent_type_name.name AS entity_name',
                                    'operator.operator_type AS operator_type',
                                    'condition.value AS value',
                                    'property_name.name AS property_name'
                                ])
                                ->searchSavedQueries($id, $data)
                                ->orderBy($colSorting, $typeSorting)
                                ->paginate($count)
                                ->toArray();

        \Log::debug("Dados saved queries");
        \Log::debug($dataSavedQuery);

        return response()->json($dataSavedQuery);

    }

}
