<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomForm;
use App\TransactionType;
use App\EntType;
use App\CustomFormName;
use App\TState;
use App\ProcessType;
use DB;
use Response;

class CustomFormManageController extends Controller
{
    public function index()
    {

        return view('customForm');
    }

    public function getAll($id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

            $costum_forms = DB::table('custom_form')
                ->leftjoin('custom_form_has_transaction_type', 'custom_form_has_transaction_type.custom_form_id', '=', 'custom_form.id')
                ->join('custom_form_name','custom_form.id','=','custom_form_name.custom_form_id')
                ->join('t_state','custom_form.t_state_id','=','t_state.id')
                ->join('t_state_name','t_state.id','=','t_state_name.t_state_id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'custom_form_name.language_id', '=', 'l2.id')
                ->select(
                    'custom_form.id as custom_form_id',
                    'custom_form_name.name as custom_form_name',
                    't_state_name.name as t_state_name',
                    'custom_form_has_transaction_type.transaction_type_id as transaction_type_id',
                    'custom_form_has_transaction_type.transaction_type_id as transaction_type_name',
                    'custom_form_has_transaction_type.transaction_type_id as transaction_type_state',
                    'custom_form_has_transaction_type.updated_at as transaction_type_updated_at',
                    'custom_form_has_transaction_type.mandatory_form as mandatory',
                    'custom_form_has_transaction_type.field_order as field_order',
                    'custom_form.deleted_at'
                )
                ->where('l2.slug','=',$url_text)
                ->where('l1.slug','=',$url_text)
                ->whereNull('custom_form.deleted_at')
                ->orderBy('field_order', 'asc')
                ->get();

            foreach ($costum_forms as $keyTransactionType => $valueTransactionType)
            {
                if ($valueTransactionType->transaction_type_name != "")
                {
                    $transaction_type =  DB::table('transaction_type')
                        ->join('transaction_type_name','transaction_type.id','=','transaction_type_name.transaction_type_id')
                        ->join('language as l1', 'transaction_type_name.language_id', '=', 'l1.id')
                        ->select('transaction_type_name.t_name as transaction_type_name',
                            'transaction_type.state as transaction_type_state',
                            'transaction_type.updated_at as transaction_type_updated_at')
                        ->where('l1.slug','=',$url_text)
                        ->where('transaction_type.id', '=', $valueTransactionType->transaction_type_name)
                        ->whereNull('transaction_type.deleted_at')
                        ->first();

                    $valueTransactionType->transaction_type_name = $transaction_type->transaction_type_name;
                    $valueTransactionType->transaction_type_state = $transaction_type->transaction_type_state;
                }
            }

            return response()->json($costum_forms);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function getSpec($id)
    {
        $url_text = 'PT';

        $costum_form = CustomForm::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes' => function($query) use ($url_text) {
            $query->orderBy('field_order', 'asc');
        }, 'transactionTypes.entType.properties.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);


        return response()->json($costum_form);
    }

    public function update(Request $request, $id)
    {
        try {
            $language_id = 1;
            $costum_form = CustomForm::find($id);

            //Actualizar o t_state
            $costum_form->update(['t_state_id' => $request->input('t_state_id') ]);

            //Actualizar o nome
            $costum_form->language()->updateExistingPivot($language_id, ['name' => $request->input('name')]);


            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
        }
    }

    public function updateOrderTransactionType(Request $request) {

        $dados = $request->all();
        if (is_array($dados) && count($dados) > 0) {

            //Get customForm_id form array Dados and fixing array
            $customForm_id = array_pop($dados);


            foreach ($dados as $key => $id) {
                $costum_forms = CustomForm::find($customForm_id);
                $costum_forms->transactionTypes()->updateExistingPivot($id, ['field_order' => ($key + 1)]);
            }
        }



        return response()->json();
    }

    public function getTransactionTypes()
    {
        $langid = 1;
        $cTransactionTypes = collect();
        $TransactionTypes = TransactionType::all();
        foreach ($TransactionTypes as $TransactionType) {
            if ($TransactionType->language) {
                if ($TransactionType->language->where('language_id', $langid)->first() != null) {
                    $TransactionType->name = $TransactionType->language->where('language_id', $langid)->first()->pivot->t_name;
                } else {
                    $TransactionType->name = $TransactionType->language->first()->pivot->t_name;
                }
            }
            if (!$TransactionType->name) {
                $TransactionType->name = "Undefined";
            }

            $sTransactionType =  array(
                "id" => $TransactionType->id,
                "name" => $TransactionType->name,
            );

            $cTransactionTypes->push($sTransactionType);


        }

        return $cTransactionTypes;
        //return response()->json($cTransactionTypes);
    }

    public function getSelTransactionTypes($id)
    {
        $langid = 1;

        $cTransactionTypes = collect();
        $transactionTypes = TransactionType::has('customForm')->get();

        foreach ($transactionTypes as $transactionType) {
            if ($transactionType->customForm->where('id', $id)->first() != null) {

                if ($transactionType->language) {
                    if ($transactionType->language->where('language_id', $langid)->first() != null) {
                        $transactionType->name = $transactionType->language->where('language_id', $langid)->first()->pivot->t_name;
                    } else {
                        $transactionType->name = $transactionType->language->first()->pivot->t_name;
                    }
                }

                if (!$transactionType->name) {
                    $transactionType->name = "Undefined";
                }

                $sTransactionType = array(
                    "id" => $transactionType->id,
                    "name" => $transactionType->name,
                );

                $cTransactionTypes->push($sTransactionType);
            }
        }

        return $cTransactionTypes;
        //return response()->json($cTransactionTypes);
    }

    public function updateTransactionTypes(Request $request, $id)
    {

        $sameActor = true;
        $sameProcessType = true;

        //Apagar todos os registos na tabela CustomFormHasEnt, de acordo um custom form
        $costum_form = CustomForm::find($id);
        $costum_form->transactionTypes()->detach();

        //Verificar se o request é null
        if(!empty($request->input('selectedTransactionTypes'))) {

            //Buscar todos os valores do request selectedTransactionTypes
            $input = $request->input('selectedTransactionTypes');

            //Verificar se Transaction_Types são iniciados ou executados pelo mesmo Actor, no certo T_State
            $sameActor = $this->sameActor($input, $id);

            //Verificar se os tipos de transações são do mesmo tipo de processo
            $sameProcessType = $this->sameProcessType($input);

            //Verificar se possui o mesmo tipo de processo e o mesmo Actor (Iniciator ou Executor)
            if($sameActor && $sameProcessType)
            {
                //Inserção na tabela Custom_Form_Has_Transaction_Types
                //Incrementar o field_order
                $field_order_number = 0;
                foreach($request->input('selectedTransactionTypes') as $stransactionTypes){
                    $field_order_number++;
                    $costum_form->transactionTypes()->attach($stransactionTypes['id'], ['field_order' =>  $field_order_number, 'mandatory_form' => 1]);
                }

                return Response::json(null, 200);
            }
            else
            {
                $returnDataError = array(
                    'sameActor' => $sameActor,
                    'sameProcess' => $sameProcessType
                );

                return Response::json($returnDataError, 400);
            }
        }
    }

    public function sameProcessType($input)
    {
        $url_text = 'PT';
        $sameProcessType = true;

        //Criar um array com todos os Ids das Transaction_Types
        $array_Trans_types_ids = array_column($input, 'id');

        //Buscar todas as Transaction_Types de acordo com os ids do $array_Trans_types_ids
        $transaction_Types = TransactionType::with(['language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'iniciatorActor' => function ($query) use ($url_text) {
        }])->whereHas('language', function ($query) use ($url_text) {
            return $query->where('slug', $url_text);
        })->whereIn('id', $array_Trans_types_ids)
            ->get();

        foreach ($transaction_Types as $transaction_type) {
            //Verificar o tipo de transação sempre pelo primeiro tipo de transação da coleção
            if ($transaction_type->process_type_id != $transaction_Types->first()->process_type_id) {
                $sameProcessType = false;
                break;
            }
        }

        return $sameProcessType;
    }

    public function sameActor($input, $id)
    {
        $url_text = 'PT';

        //Variaveis de actores iguais
        $sameActor = true;

        //Buscar o custom form
        $costum_form = CustomForm::find($id);

        //Criar um array com todos os Ids das Transaction_Types
        $array_Trans_types_ids = array_column($input, 'id');

        //Buscar todas as Transaction_Types de acordo com os ids do $array_Trans_types_ids
        $transaction_Types = TransactionType::with(['language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'iniciatorActor' => function ($query) use ($url_text) {
        }])->whereHas('language', function ($query) use ($url_text) {
            return $query->where('slug', $url_text);
        })->whereIn('id', $array_Trans_types_ids)
            ->get();

        switch ($costum_form->t_state_id) {
            //Verificar pelo iniciator (Pedido, Aceitação)
            case 1:
            case 5:
                //Buscar de iniciatesActors da primeira transação
                //Criar um array só com os ids dos actores
                $firstActors = $transaction_Types->first();
                $array_actor_id = [];
                foreach ($firstActors->iniciatorActor as $actor) {
                    array_push($array_actor_id, $actor->pivot->actor_id);
                }

                foreach ($transaction_Types as $transaction_type) {
                    $sameActor_Aux = false;
                    foreach ($transaction_type->iniciatorActor as $actor) {
                        //Verifica se o id do iniciator existe no array $array_actor_id
                        if (in_array($actor->pivot->actor_id, $array_actor_id)) {
                            $sameActor_Aux = true;
                            break;
                        }
                    }

                    //Caso não possui um actor iniciator comun em todas as Transaction_Types, actualizar a variavel  $sameActor = false
                    if (!$sameActor_Aux) {
                        $sameActor = false;
                    }
                }
                break;

            //Verificar pelo iniciator executor (Promesa, Execução, Estado)
            case 2:
            case 3:
            case 4:

                foreach ($transaction_Types as $transaction_type) {
                    if ($transaction_type->executer != $transaction_Types->first()->executer) {
                        $sameActor = false;
                        break;
                    }
                }
                break;
        }

        return $sameActor;
    }

    public function insert(Request $request)
    {
        DB::beginTransaction();
        try {
            $costum_form = new CustomForm;
            $costum_form_name = new CustomFormName;

            $costum_form->state = $request->input('state');
            $costum_form->t_state_id = $request->input('t_state_id');
            $costum_form->save();

            $costum_form_name->custom_form_id = $costum_form->id;
            $costum_form_name->language_id = 1;
            $costum_form_name->name = $request->input('name');
            $costum_form_name->save();

            DB::commit();
            // all good
            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $success = false;
        }

        $returnData = array(
            'message' => 'An error occurred!'
        );

        if ($success) {
            return Response::json(null,200);
        }
        else
        {
            return Response::json($returnData, 400);
        }
    }

    public function removeTransactionTypes(Request $request)
    {

        DB::beginTransaction();

        $custom_form_id = $request->input('custom_form_id');
        $field_order_number = 0;

        try {
            //Apagar o registo
            $costum_forms = CustomForm::find($custom_form_id);
            $costum_forms->transactionTypes()->detach($request->input('transaction_type_id'));

            //Corrigir os valores do field_order
            $transaction_types = $costum_forms->transactionTypes()->orderBy('field_order','asc')->get();
            foreach($transaction_types as $transaction_type){
                $field_order_number++;
                $transaction_type->customForm()->updateExistingPivot($custom_form_id, ['field_order' => $field_order_number]);
            }

            DB::commit();
            // all good
            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $success = false;
        }
    }

    public function getAllTSate ()
    {
        $url_text = 'PT';

        $tStates = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->get();

        return response()->json($tStates);
    }

    public function updateMandatory (Request $request)
    {
        $t_id = $request->input('transaction_type_id');
        $c_id = $request->input('custom_form_id');

        try {

            //buscar o valor anterior do mandatory
            $custom_forms = CustomForm::find($c_id);
            $mandatoryUpdate = 0;
            foreach ($custom_forms->transactionTypes as $custom_form_t)
            {
                if($custom_form_t->pivot->transaction_type_id == $t_id)
                    $mandatoryUpdate =  $custom_form_t->pivot->mandatory_form ? 0 : 1;
            }

            $custom_forms->transactionTypes()->updateExistingPivot($t_id, ['mandatory_form' => $mandatoryUpdate]);

            DB::commit();
            // all good
            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            $success = false;
        }
    }

    public function addTransactioType($id)
    {
        //Buscar todos os tipos de Processo
        $process_types = $this->getAllProcessType();

        //Buscar o custom Form
        $costum_form = $this->getCustomForm($id);

        //Buscar Todos os Tipos de transações
        $transaction_types = $this->getTransactionTypes();

        //Buscar os Tipos de transações selecionados
        $transaction_types_sel = $this->getSelTransactionTypes($id);

        //Criar o array dos dados para enviar
        $returnData = array(
            'process_types' => $process_types,
            'custom_form' => $costum_form,
            'transactio_types' => $transaction_types,
            'transaction_types_sel' => $transaction_types_sel,
            'process_type_id' => $this->getProcessTypeId($transaction_types_sel->first())
        );

        return response()->json($returnData);
    }

    public function getProcessTypeId($transaction_type)
    {
        $process_type_id = null;

        //Verificar se tem transaction_type
        if(!empty($transaction_type))
            //Buscar o id da Process pelo 1º tipo de transação selecionado
            $process_type_id = TransactionType::find($transaction_type['id'])->process_type_id;

        //Retornar o id do tipo de processo
        //Caso não existe nenhum tipo de transação, $process_type_id = NULL
        return $process_type_id;
    }

    public function getAllProcessType()
    {
        $url_text = 'PT';

        $process_type = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->get();

        return $process_type;
    }

    public function getCustomForm($id)
    {
        $url_text = 'PT';

        $costum_form = CustomForm::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes' => function($query) use ($url_text) {
            $query->orderBy('field_order', 'asc');
        }, 'transactionTypes.entType.properties.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);


        return $costum_form;
    }

    public function getTransactionTypesByProcessType($id)
    {
        $langid = 1;

        $cTransactionTypes = collect();
        $TransactionTypes = TransactionType::all()->where('process_type_id',$id);

        foreach ($TransactionTypes as $TransactionType) {
            if ($TransactionType->language) {
                if ($TransactionType->language->where('language_id', $langid)->first() != null) {
                    $TransactionType->name = $TransactionType->language->where('language_id', $langid)->first()->pivot->t_name;
                } else {
                    $TransactionType->name = $TransactionType->language->first()->pivot->t_name;
                }
            }
            if (!$TransactionType->name) {
                $TransactionType->name = "Undefined";
            }

            $sTransactionType =  array(
                "id" => $TransactionType->id,
                "name" => $TransactionType->name,
            );

            $cTransactionTypes->push($sTransactionType);
        }

        return $cTransactionTypes;
    }

    public function remove(Request $request)
    {
        try {

            $custom_form = CustomForm::find($request->input('id'))->delete();

            //Apagar os Nomes do $prop_allowed_value

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return Response::json(null,400);
        }

        //Sucesso
        return Response::json(null,200);
    }
}
