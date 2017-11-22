<?php

namespace App\Http\Controllers;

use App\CausalLink;
use App\Entity;
use App\Process;
use App\ProcessType;
use App\ProcessName;
use App\ProcessTypeName;
use App\Property;
use App\PropertyCanReadEntType;
use App\PropertyCanReadProperty;
use App\Transaction;
use App\TransactionAck;
use App\TransactionType;
use App\TransactionTypeName;
use App\TransactionState;
use App\Users;
use App\WaitingLink;
use App\User;
use App\EntityName;
use App\Value;
use App\EntType;
use App\RelType;
use App\Relation;
use App\RelationName;
use App\Language;
use App\TStateName;
use App\PropertyName;
use App\CustomForm;
use App\Actor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Response;
use Exception;
use Config;

class DashboardController extends Controller
{
    //
    private $url_text;
    private $user_id;

    public function __construct()
    {
        $this->url_text = Config::get('config_app.url_text');
        $this->user_id = Config::get('config_app.user_id');
    }

    public function getAllInicExecTrans()
    {
        $returnData = array(
            'InicTrans' => $this->getAllInicTrans(),
            'ExecTrans' => $this->getAllExecTrans()
        );

        return response()->json($returnData);
    }

    private function getAllInicTrans()
    {
            $url_text = $this->url_text;
            $user_id = $this->user_id;

            $get_user = Users::find($user_id);
            $get_lang_id = Language::where('slug', '=', $url_text)->first()->id;

            /*$all = Transaction::with(['process.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'process.processType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionType.iniciatorActor.role.user' => function($query) use ($user_id) {
                $query->where('id', $user_id);
            }, 'transactionStates.tState.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('process.language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->whereHas('process.processType.language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->whereHas('transactionType.language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->whereHas('transactionStates.tState.language', function ($query) use ($url_text){
                return $query->where('slug', $url_text);
            })->whereHas('transactionType.iniciatorActor.role.user', function ($query) use ($user_id) {
                return $query->where('id', $user_id);
            })
                ->get();*/

        /*select process.id as process_id,transaction.id as transaction_id,transaction.updated_by,group_concat(t_state_name.name ORDER BY t_state_name.t_state_id ASC SEPARATOR '->') as t_state_name,transaction_type.id as transaction_type_id from transaction
inner join transaction_state on transaction_state.transaction_id=transaction.id
inner join t_state on t_state.id=transaction_state.t_state_id
inner join t_state_name on t_state.id=t_state_name.t_state_id
inner join process on transaction.process_id=process.id
inner join process_type on process_type.id=process.process_type_id
inner join transaction_type on transaction_type.id=transaction.transaction_type_id
inner join actor_iniciates_t on actor_iniciates_t.transaction_type_id=transaction_type.id
where t_state_name.language_id = 1 AND (actor_iniciates_t.actor_id = 2) AND process.updated_by IN (SELECT users.id FROM users WHERE users.entity_id = 30)
GROUP BY transaction_type_id, transaction_id, process_id;*/

            $iniciatorTransactions = DB::table('transaction')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('process', 'transaction.process_id', '=', 'process.id')
                ->join('process_type', 'process_type.id', '=', 'process.process_type_id')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('actor_iniciates_t', 'actor_iniciates_t.transaction_type_id', '=', 'transaction_type.id')
                ->select('process_type.id as process_type_id','process.id as process_id','transaction.id as transaction_id',DB::raw('group_concat(t_state_name.name ORDER BY t_state_name.t_state_id ASC SEPARATOR \'->\') as t_state_name'),'transaction_type.id as transaction_type_id',DB::raw("'Iniciator' as Type"))
                ->where('t_state_name.language_id','=', $get_lang_id)
                ->whereIn('actor_iniciates_t.actor_id', function ($query) use ($user_id) {
                    $query->select('actor_id')->from('role_has_actor')
                        ->whereIn('role_id',function ($query) use ($user_id) {
                            $query->select('role_id')->from('role_has_user')
                                ->where('user_id', '=', $user_id);
                        });
                });

            if ($get_user->user_type === "external" && $get_user->entity_id !== "null")
            {
                $entity_id = $get_user->entity_id;
                $iniciatorTransactions = $iniciatorTransactions->whereIn('process.updated_by', function ($query) use ($entity_id) {
                    $query->select('users.id')->from('users')->where('users.entity_id', '=', $entity_id);
                });
            }
            $iniciatorTransactions =  $iniciatorTransactions->groupBy('transaction_type_id','transaction_id','process_id','process_type_id')
                ->get();

            foreach($iniciatorTransactions as $iniciatorTransaction)
            {
                $iniciatorTransaction->process_type_name = ProcessTypeName::where('process_type_id','=',$iniciatorTransaction->process_type_id)->where('language_id','=',1)->first()->name;
                $iniciatorTransaction->process_name = ProcessName::where('process_id','=',$iniciatorTransaction->process_id)->where('language_id','=',1)->first()->name;
                $iniciatorTransaction->t_name = TransactionTypeName::where('transaction_type_id','=',$iniciatorTransaction->transaction_type_id)->where('language_id','=',1)->first()->t_name;
            }

            /*$iniciatorTransactions = DB::table('transaction')
                ->join('process', 'transaction.process_id', '=', 'process.id')
                ->join('process_type', 'process_type.id', '=', 'process.process_type_id')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('actor_iniciates_t', 'actor_iniciates_t.transaction_type_id', '=', 'transaction_type.id')
                ->join('actor', 'actor.id', '=', 'actor_iniciates_t.actor_id')
                ->join('role_has_actor', 'actor.id', '=', 'role_has_actor.actor_id')
                ->join('role', 'role.id', '=', 'role_has_actor.role_id')
                ->join('role_has_user', 'role.id', '=', 'role_has_user.role_id')
                ->join('users', 'users.id', '=', 'role_has_user.user_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('process_name', 'process_name.process_id', '=', 'process.id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->join('language as l4', 'process_name.language_id', '=', 'l4.id')
                //->join('users as userUpdatedBy', 'userUpdatedBy.id', '=', 'transaction.updated_by')
                ->join('users as processUpdatedBy', 'processUpdatedBy.id', '=', 'process.updated_by')
                ->select('process_type_name.name as process_type_name','process.id as process_id','process_name.name as process_name','transaction.id as transaction_id','transaction.updated_by',DB::raw('group_concat(t_state_name.name ORDER BY t_state_name.t_state_id ASC SEPARATOR \'->\') as t_state_name'),'transaction_type.id as transaction_type_id','transaction_type_name.t_name',DB::raw("'Iniciator' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',2);

                if ($get_user->user_type === "external" && $get_user->entity_id !== "null")
                {
                    $iniciatorTransactions = $iniciatorTransactions->where('processUpdatedBy.entity_id', '=', $get_user->entity_id);
                }
                $iniciatorTransactions =  $iniciatorTransactions->groupBy('transaction_type_id','transaction_id','process_type_name','process_id','process_name','t_name')
                    ->get();*/

                return $iniciatorTransactions;
    }

    private function getAllExecTrans()
    {
            $url_text = $this->url_text;
            $user_id = $this->user_id;

            $get_user = Users::find($user_id);
            $get_lang_id = Language::where('slug', '=', $url_text)->first()->id;

            $executerTransactions = DB::table('transaction')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('process', 'transaction.process_id', '=', 'process.id')
                ->join('process_type', 'process_type.id', '=', 'process.process_type_id')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->select('process_type.id as process_type_id','process.id as process_id','transaction.id as transaction_id',DB::raw('group_concat(t_state_name.name ORDER BY t_state_name.t_state_id ASC SEPARATOR \'->\') as t_state_name'),'transaction_type.id as transaction_type_id',DB::raw("'Executer' as Type"))
                ->where('t_state_name.language_id','=', $get_lang_id)
                ->whereIn('transaction_type.executer', function ($query) use ($user_id) {
                    $query->select('actor_id')->from('role_has_actor')
                        ->whereIn('role_id',function ($query) use ($user_id) {
                            $query->select('role_id')->from('role_has_user')
                                ->where('user_id', '=', $user_id);
                        });
                });

            if ($get_user->user_type === "external" && $get_user->entity_id !== "null")
            {
                $entity_id = $get_user->entity_id;
                $executerTransactions = $executerTransactions->whereIn('process.updated_by', function ($query) use ($entity_id) {
                    $query->select('users.id')->from('users')->where('users.entity_id', '=', $entity_id);
                });
            }
            $executerTransactions =  $executerTransactions->groupBy('transaction_type_id','transaction_id','process_id','process_type_id')
                ->get();

            foreach($executerTransactions as $executerTransaction)
            {
                $executerTransaction->process_type_name = ProcessTypeName::where('process_type_id','=',$executerTransaction->process_type_id)->where('language_id','=',1)->first()->name;
                $executerTransaction->process_name = ProcessName::where('process_id','=',$executerTransaction->process_id)->where('language_id','=',1)->first()->name;
                $executerTransaction->t_name = TransactionTypeName::where('transaction_type_id','=',$executerTransaction->transaction_type_id)->where('language_id','=',1)->first()->t_name;
            }

            /*$executerTransactions = DB::table('transaction')
                ->join('process', 'transaction.process_id', '=', 'process.id')
                ->join('process_type', 'process_type.id', '=', 'process.process_type_id')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('actor', 'actor.id', '=', 'transaction_type.executer')
                ->join('role_has_actor', 'actor.id', '=', 'role_has_actor.actor_id')
                ->join('role', 'role.id', '=', 'role_has_actor.role_id')
                ->join('role_has_user', 'role.id', '=', 'role_has_user.role_id')
                ->join('users', 'users.id', '=', 'role_has_user.user_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('process_name', 'process_name.process_id', '=', 'process.id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->join('language as l4', 'process_name.language_id', '=', 'l4.id')
                //->join('users as userUpdatedBy', 'userUpdatedBy.id', '=', 'transaction.updated_by')
                ->join('users as processUpdatedBy', 'processUpdatedBy.id', '=', 'process.updated_by')
                ->select('process_type_name.name as process_type_name','process.id as process_id','process_name.name as process_name','transaction.id as transaction_id','transaction.updated_by',DB::raw('group_concat(t_state_name.name ORDER BY t_state_name.t_state_id ASC SEPARATOR \'->\') as t_state_name'),'transaction_type.id as transaction_type_id','transaction_type_name.t_name',DB::raw("'Executer' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',2);

                if ($get_user->user_type === "external" && $get_user->entity_id !== "null")
                {
                    $executerTransactions = $executerTransactions->where('processUpdatedBy.entity_id', '=', $get_user->entity_id);
                                                        //where('userUpdatedBy.entity_id', '=', $get_user->entity_id);
                }

                $executerTransactions =  $executerTransactions->groupBy('transaction_type_id','transaction_id','process_type_name','process_id','process_name','t_name')
                    ->get();*/

            return $executerTransactions;
    }

    public function index()
    {
        return view('dashboard');
    }

    public function insert(Request $request)
    {
        /*$tstate = new TState;
        $tstatename = new TStateName;

        DB::beginTransaction();
        try {
            $tstate->save();

            $tstatename->name = $request->input('name');
            $tstatename->language_id = $request->input('language_id');
            $tstatename->t_state_id = $tstate->id;
            $tstatename->save();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
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
        }*/
    }

    public function update(Request $request, $id)
    {
        /*$url_text = 'PT';
        $tstate = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        DB::beginTransaction();
        try {
            $attributes = array(
                'name' => $request->input('name')
            );
            $tstate->language()->updateExistingPivot($id, $attributes);

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
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
        }*/
    }

    public function delete(Request $request, $id)
    {
        /*$url_text = 'PT';
        $entitytype = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionsType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tStates.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $entitytype->language()->detach($id);

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
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
        }*/
    }

    public function insertData(Request $request)
    {
        $url_text = $this->url_text;

        //tentar tornar mais facil os foreachs
        $error=null;
        $collec = json_decode(json_encode($request->all()));
        //$collec = $request->all();
        DB::beginTransaction();
        try {
            foreach ($collec as $col)
            {
                //dd($col);
                if ($col->process === null)
                {
                    $process = new Process;
                    $process->process_type_id = $col->process_type_id;
                    $process->proc_state = "execution";
                    $process->state = "active";
                    $process->save();

                    $process_type = ProcessType::with(['language' => function ($query) use ($url_text) {
                        $query->where('slug', $url_text);
                    }])->whereHas('language', function ($query) use ($url_text) {
                        return $query->where('slug', $url_text);
                    })->where('id', $col->process_type_id)->first();

                    $processName = new ProcessName;
                    $processName->process_id = $process->id;
                    $processName->language_id = 1; //buscar o language id
                    $processName->name = $process_type->language[0]->pivot->name . " " . $process->id;
                    $processName->save();
                }

                $transaction = new Transaction;
                $transaction->transaction_type_id = $col->transaction_type_id;
                $transaction->state = "active";
                $transaction->process_id = $col->process === null ? $process->id : $col->process->id; //buscar o processo ID
                $transaction->save();

                $counterEntType = 0;
                $counterRelType = 0;
                foreach ($col->tab as $keyTab => $valueTab)
                {
                    $transactionState = new TransactionState;
                    $transactionState->transaction_id = $transaction->id;
                    $transactionState->t_state_id = $valueTab->type;
                    $transactionState->save();

                    if ($valueTab->relTypeExist == false && $valueTab->entTypeExist == true) //nao existe rel type e não existe ent type por exemplo verificar esta parte
                    {
                        if ($counterEntType == 0)
                        {
                            //inserir nas entity... é preciso obter o ent_type_id
                            $ent_type = EntType::with(['language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])->whereHas('language', function ($query) use ($url_text) {
                                return $query->where('slug', $url_text);
                            })->where('transaction_type_id', $col->transaction_type_id)->first();

                            $entity = new Entity;
                            $entity->ent_type_id = $ent_type->id;
                            $entity->state = "active";
                            $entity->transaction_id = $transaction->id;
                            $entity->save();

                            $entityName = new EntityName;
                            $entityName->entity_id = $entity->id;
                            $entityName->language_id = 1; //buscar o language id
                            $entityName->name = $ent_type->language[0]->pivot->name . " " . $entity->id;
                            $entityName->save();
                            $counterEntType++;
                        }
                    }
                    else if ($valueTab->relTypeExist == true && $valueTab->entTypeExist == false)
                    {
                        if ($counterRelType == 0)
                        {
                            $rel_type = RelType::with(['language' => function ($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])->whereHas('language', function ($query) use ($url_text) {
                                return $query->where('slug', $url_text);
                            })->where('transaction_type_id', $col->transaction_type_id)->first();

                            $relation = new Relation;
                            $relation->rel_type_id = $rel_type->id;
                            $relation->entity1_id = $valueTab->entity1->selected->id;
                            $relation->entity2_id = $valueTab->entity2->selected->id;
                            $relation->state = "active";
                            $relation->transaction_id = $transaction->id; //adicionar este campo na tabela relation
                            $relation->save();

                            $relationName = new RelationName;
                            $relationName->relation_id = $relation->id;
                            $relationName->language_id = 1; //buscar o language id através do eloquent
                            $relationName->name = $rel_type->language[0]->pivot->name . " " . $relation->id;
                            $relationName->save();
                            $counterRelType++;
                        }
                    }
                    /*else
                    {
                        throw new Exception('Não existe ent types nem rel types!!!.');
                    }*/

                    if ($valueTab->propsform != null)
                    {
                        foreach ($valueTab->propsform as $keyField => $valueField)
                        {
                            if (isset($valueField->fields))
                            {
                                if ($valueField->value_type === "enum" && $valueField->form_field_type === "checkbox")
                                {
                                    foreach ($valueField->fields as $keyPropFieldValue => $propFieldValue)
                                    {
                                        $value = new Value;
                                        if ($valueTab->relTypeExist == false) {
                                            $value->entity_id = $entity->id;
                                        } else {
                                            $value->relation_id = $relation->id;
                                        }
                                        $value->property_id = $valueField->id;

                                        $value->value = mb_substr($keyPropFieldValue, -1); //obter a ultima posição da string "Tra-1-Local_Destino-2-3": true, neste caso o 3

                                        $value->save();
                                    }
                                }
                                else
                                {
                                    $value = new Value;
                                    if ($valueTab->relTypeExist == false)
                                    {
                                        $value->entity_id = $entity->id;
                                    }
                                    else
                                    {
                                        $value->relation_id = $relation->id;
                                    }
                                    $value->property_id = $valueField->id;
                                    //$value->id_producer = 1;

                                    $currentValueField=null;
                                    foreach ($valueField->fields as $prop) {
                                        $currentValueField = $prop;
                                        break; // or exit or whatever exits a foreach loop...
                                    }

                                    if($valueField->value_type === "file")
                                    {
                                        $value->value = $this->uploadFile($currentValueField);
                                    }
                                    else
                                    {
                                        $value->value = $currentValueField;
                                    }
                                    $value->save();
                                }

                            }
                        }

                        if (isset($valueTab->propsform_)) {
                            foreach ($valueTab->propsform_ as $keyField_ => $valueField_) {
                                if ($keyField_ == 0) {
                                    $entity = new Entity;
                                    $entity->ent_type_id = $valueField_->ent_type->id;
                                    $entity->state = "active";
                                    $entity->transaction_id = $transaction->id;
                                    $entity->save();

                                    $entityName = new EntityName;
                                    $entityName->entity_id = $entity->id;
                                    $entityName->language_id = 1; //buscar o language id
                                    $entityName->name = $valueField_->ent_type->language[0]->pivot->name . " " . $entity->id;
                                    $entityName->save();
                                }

                                if (isset($valueField_->fields))
                                {
                                    $value = new Value;
                                    $value->entity_id = $entity->id;
                                    $value->property_id = $valueField_->id;
                                    $value->id_producer = 1;
                                    foreach ($valueField_->fields as $prop) {
                                        $value->value = $prop;
                                        break; // or exit or whatever exits a foreach loop...
                                    }
                                    $value->save();

                                    if ($valueField_->value_type === "enum" && $valueField_->form_field_type === "checkbox")
                                    {
                                        foreach ($valueField_->fields as $keyPropFieldValue_ => $propFieldValue_)
                                        {
                                            $value = new Value;
                                            $value->entity_id = $entity->id;
                                            $value->property_id = $valueField_->id;

                                            $value->value = mb_substr($keyPropFieldValue_, -1); //obter a ultima posição da string "Tra-1-Local_Destino-2-3": true, neste caso o 3

                                            $value->save();
                                        }
                                    }
                                    else
                                    {
                                        $value = new Value;
                                        $value->entity_id = $entity->id;
                                        $value->property_id = $valueField_->id;

                                        $currentValueField=null;
                                        foreach ($valueField_->fields as $prop) {
                                            $currentValueField = $prop;
                                            break; // or exit or whatever exits a foreach loop...
                                        }

                                        if($valueField_->value_type === "file")
                                        {
                                            $value->value = $this->uploadFile($currentValueField);
                                        }
                                        else
                                        {
                                            $value->value = $currentValueField;
                                        }
                                        $value->save();
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($col->causalinks as $keyCausaLink => $valueCausaLink)
                {
                    //dd($valueCausaLink);
                    for ($x = 0; $x < $valueCausaLink->numberofTrs; $x++)
                    {
                        $transaction = new Transaction;
                        $transaction->transaction_type_id = $valueCausaLink->transaction_type_id;
                        $transaction->state = "active";
                        $transaction->process_id = $col->process === null ? $process->id : $col->process->id; //buscar o processo ID
                        $transaction->save();

                        $transactionState = new TransactionState;
                        $transactionState->transaction_id = $transaction->id;
                        $transactionState->t_state_id = $valueCausaLink->t_state_id;
                        $transactionState->save();
                    }
                }
            }

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $error = $e->getLine() . " " . $e->getMessage();
            $success = false;
            DB::rollback();
        }

        $returnData = array(
            'message' => 'An error occurred!',
            'error' => $error
        );

        if ($success) {
            return Response::json(null,200);
        }
        else
        {
            return Response::json($returnData, 400);
        }
    }

    function uploadFile($fileData64)
    {
        //get the base-64 from data
        $dataFile = $fileData64->data;

        $dataOriginalFileName = $fileData64->fileName;

        $unique_name = md5($dataOriginalFileName . microtime());

        list($type, $dataFile) = explode(';', $dataFile);
        list(, $dataFile) = explode(',', $dataFile);
        $dataFile = base64_decode($dataFile);
        $fileTypeArray = explode('.', $dataOriginalFileName);
        $fileType = $fileTypeArray[count($fileTypeArray)-1];
        $fileNameTypeOriginal = $unique_name . '.' . $fileType;
        Storage::disk('local')->put('public/' . $fileNameTypeOriginal, $dataFile, 'public');
        $path = Storage::disk('local')->getDriver()->getAdapter()->getPathPrefix() . '/public/' . $fileNameTypeOriginal;

        return $path;
    }

    function get_numerics ($str) {
        preg_match_all('/\d+/', $str, $matches);
        return $matches[0];
    }

    public function getSpec($id)
    {
        $url_text = $this->url_text;
        $tstates = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($tstates);
    }

    public function getTransTypeUserCanInit()
    {
        $user_id = $this->user_id;
        $url_text = $this->url_text;
        $transactions = TransactionType::with(['iniciatorActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }, 'language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('iniciatorActor.role.user', function ($query) use ($user_id){
            return $query->where('user_id', $user_id);
        })
        ->doesntHave('causedTransaction')->get();
        return response()->json($transactions);
    }

    public function isUserInicAndExecOfTrans_($id)
    {
        $user_id = $this->user_id;
        $url_text = $this->url_text;
        $transactions = TransactionType::with(['iniciatorActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        },'executerActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }, 'language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('iniciatorActor.role.user', function ($query) use ($user_id){
            return $query->where('user_id', $user_id);
        })->whereHas('executerActor.role.user', function ($query) use ($user_id){
            return $query->where('user_id', $user_id);
        })->where('id',$id)->get();

        $sameActor = $transactions->isEmpty() ? false : true;

        return response()->json($sameActor);
    }

    public function all(Request $request)
    {
        $numberOfTStates = null;
        $trans_type_id = $request->input('trans_type_id');
        $process_id = $request->input('process_id');

        $dataArray = array();

        $sameActor = $this->isUserInicAndExecOfTrans($trans_type_id, 1);
        //\Log::debug($sameActor);

        if ($sameActor === true)
        {
            $numberOfTStates = 5;
        }
        else
        {
            $numberOfTStates = 1;
        }


        for ($i = 1; $i <= $numberOfTStates; $i++)
        {
            $dataResult = $this->isTrAndStWaitingForAnotherTr(new Request, $i, $trans_type_id, $process_id, 1);
            //\Log::debug($i);
            if ($dataResult['empty'] === false)
            {
                break;
            }
            else
            {
                $dataResultProps = $this->getProps($trans_type_id, $i, 1);

                array_push($dataArray, $dataResultProps);
                //\Log::debug($dataArray);
            }
        }

        return response()->json($dataArray, 200);
    }

    public function isUserInicAndExecOfTrans($id, $option = null)
    {
        $user_id = $this->user_id;
        $url_text = $this->url_text;
        $transactions = TransactionType::with(['iniciatorActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        },'executerActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }, 'language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('iniciatorActor.role.user', function ($query) use ($user_id){
            return $query->where('user_id', $user_id);
        })->whereHas('executerActor.role.user', function ($query) use ($user_id){
            return $query->where('user_id', $user_id);
        })->where('id',$id)->get();

        $sameActor = $transactions->isEmpty() ? false : true;

        if ($option === null)
            return response()->json($sameActor);
        else
            return $sameActor;
    }

    public function isTrAndStWaitingForAnotherTr_(Request $request)
    {
        $t_state_id = $request->input('t_state_id');
        $trans_id = $request->input('transaction_type_id');
        $proc_id = $request->input('process_id');

        $waitinglinks = WaitingLink::where('waiting_t',$trans_id)->where('waiting_fact',$t_state_id)->get();

        $existsAllTransactions = true;
        $transactionsLacking = array();
        if ($proc_id != null) {
            if ($waitinglinks != null) {
                /*$waitinglinks = WaitingLink::whereHas('waitedT.processType.processes.transactions.transactionStates')
                    ->where('waiting_transaction', $trans_id)->where('waiting_fact', $t_state_id)->get();*/

                foreach ($waitinglinks as $waitinglink) {
                    foreach ($waitinglink->waitedT->processType->processes as $keyProcess => $valueProcess) {
                        if ($valueProcess->id != $proc_id) {
                            $waitinglink->waitedT->processType->processes->forget($keyProcess);
                        } else {
                            foreach ($valueProcess->transactions as $keyTransaction => $valueTransaction) {
                                //obter apenas as transacções que são do tipo de transacção da waited t (transacção que tem de ser executada antes da waiting t)
                                if ($valueTransaction->transaction_type_id != $waitinglink->waitedT->id) //$value contem toda a informação do objecto id,etc
                                {
                                    $valueProcess->transactions->forget($keyTransaction);
                                } else {
                                    foreach ($valueTransaction->transactionStates as $keyTState => $valueTState) {
                                        if ($valueTState->t_state_id != $waitinglink->waited_fact) {
                                            $valueTransaction->transactionStates->forget($keyTState);
                                        } else {
                                            /*if ($valueTState->entities->isEmpty()) {
                                                $valueProcess->transactions->forget($keyTransaction);
                                            }*/
                                        }
                                    }

                                    if ($valueTransaction->transactionStates->isEmpty()) //repensar esta parte
                                    {
                                        $valueProcess->transactions->forget($keyTransaction);
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($waitinglinks as $waitinglink) {
                    foreach ($waitinglink->waitedT->processType->processes as $keyProcess => $valueProcess) { //verificar a condição de waitinglink max
                        if (($valueProcess->transactions->isEmpty()) || $valueProcess->transactions->count() < $waitinglink->min) {
                            $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_id', $waitinglink->waitedT->id);
                            $transactionsLacking = $this->array_push_assoc($transactionsLacking, 't_state_id', $waitinglink->waited_fact);
                            $existsAllTransactions = false;
                            break 2;
                        }
                    }

                    if ($waitinglink->waitedT->processType->processes->isEmpty()) {
                        $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_id', $waitinglink->waitedT->id);
                        $transactionsLacking = $this->array_push_assoc($transactionsLacking, 't_state_id', $waitinglink->waited_fact);
                        $existsAllTransactions = false;
                    }
                }
                //$sameActor = $transactions->isEmpty() ? false : true;
            }
        }

        $data = array(
            'empty' => $existsAllTransactions,
            'dataTransactionsLacking' => $transactionsLacking,
            'data' => $waitinglinks
        );

        return response()->json($data, $existsAllTransactions == false ? 400 : 200); //400 vai para o catch, 200 vai para o then
    }

    public function isTrAndStWaitingForAnotherTr(Request $request, $type=null, $trans_type_id=null, $process_id=null, $option = null)
    {
        if ($option === null)
        {
            $t_state_id = $request->input('t_state_id');
            $trans_id = $request->input('transaction_type_id');
            $proc_id = $request->input('process_id');
        }
        else
        {
            $t_state_id = $type;
            $trans_id = $trans_type_id;
            $proc_id = $process_id;
        }

        $waitinglinks = WaitingLink::where('waiting_t',$trans_id)->where('waiting_fact',$t_state_id)->get();

        $existsAllTransactions = true;
        $transactionsLacking = array();
        if ($proc_id !== null) {
            if ($waitinglinks !== null) {
                /*$waitinglinks = WaitingLink::whereHas('waitedT.processType.processes.transactions.transactionStates')
                    ->where('waiting_transaction', $trans_id)->where('waiting_fact', $t_state_id)->get();*/

                foreach ($waitinglinks as $waitinglink) {
                    foreach ($waitinglink->waitedT->processType->processes as $keyProcess => $valueProcess) {
                        if ($valueProcess->id != $proc_id) {
                            $waitinglink->waitedT->processType->processes->forget($keyProcess);
                        } else {
                            foreach ($valueProcess->transactions as $keyTransaction => $valueTransaction) {
                                //obter apenas as transacções que são do tipo de transacção da waited t (transacção que tem de ser executada antes da waiting t)
                                if ($valueTransaction->transaction_type_id != $waitinglink->waitedT->id) //$value contem toda a informação do objecto id,etc
                                {
                                    $valueProcess->transactions->forget($keyTransaction);
                                } else {
                                    foreach ($valueTransaction->transactionStates as $keyTState => $valueTState) {
                                        if ($valueTState->t_state_id != $waitinglink->waited_fact) {
                                            $valueTransaction->transactionStates->forget($keyTState);
                                        } else {
                                            /*if ($valueTState->entities->isEmpty()) {
                                                $valueProcess->transactions->forget($keyTransaction);
                                            }*/
                                        }
                                    }

                                    if ($valueTransaction->transactionStates->isEmpty()) //repensar esta parte
                                    {
                                        $valueProcess->transactions->forget($keyTransaction);
                                    }
                                }
                            }
                        }
                    }
                }

                foreach ($waitinglinks as $waitinglink) {
                    foreach ($waitinglink->waitedT->processType->processes as $keyProcess => $valueProcess) { //verificar a condição de waitinglink max
                        if (($valueProcess->transactions->isEmpty()) || $valueProcess->transactions->count() < $waitinglink->min) {
                            $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_id', $waitinglink->waitedT->id);
                            $transactionsLacking = $this->array_push_assoc($transactionsLacking, 't_state_id', $waitinglink->waited_fact);
                            $existsAllTransactions = false;
                            break 2;
                        }
                    }

                    if ($waitinglink->waitedT->processType->processes->isEmpty()) {
                        $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_id', $waitinglink->waitedT->id);
                        $transactionsLacking = $this->array_push_assoc($transactionsLacking, 't_state_id', $waitinglink->waited_fact);
                        $existsAllTransactions = false;
                    }
                }
                //$sameActor = $transactions->isEmpty() ? false : true;
            }
        }

        foreach ($transactionsLacking as $transactionLacking)
        {
            //\Log::debug($transactionLacking->transaction_type_id);
            //$transactionLacking['transaction_type_name'] = "";
            //$transactionLacking->transaction_type_name = TransactionTypeName::where('transaction_type_id','=',$transactionLacking->transaction_type_id)->where('language_id','=',1)->first()->t_name;
            //$transactionLacking->t_state_name = TStateName::where('t_state_id','=',$transactionLacking->t_state_id)->where('language_id','=',1)->first()->name;
        }

        $data = array(
            'empty' => $existsAllTransactions,
            'dataTransactionsLacking' => $transactionsLacking,
            'data' => $waitinglinks
        );

        if ($option === null)
            return response()->json($data, $existsAllTransactions == false ? 400 : 200); //400 vai para o catch, 200 vai para o then
        else
            return $data;
    }

    private function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }

    public function getTransTypeName($id)
    {
        $url_text = $this->url_text;

        $transtypename = TransactionType::with(['language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text) {
            return $query->where('slug', $url_text);
        })->where('id', $id)->get();

        return $transtypename;
    }

    public function getCausalLinksOfTr(Request $request)
    {
        $trans_id = $request->input('transaction_type_id');
        $arr_t_state_id = $request->input('t_states_id');

        $url_text = $this->url_text;

        $causallinks = CausalLink::with(['causedTransaction.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->where('causing_t', $trans_id)->whereIn('t_state_id', $arr_t_state_id)->orderBy('created_at','desc')->get();

        return response()->json($causallinks, $causallinks->isEmpty() ? 400 : 200);
    }

    public function getEntites1RelType($id)
    {
        $url_text = $this->url_text;

        $entitiesRel = Entity::with(['entType.relType1' => function ($query) use ($id) {
            $query->where('id', $id);
        }, 'language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('entType.relType1', function ($query) use ($id) {
            return $query->where('id', $id);
        })->get();

        return $entitiesRel;
    }

    public function getEntites2RelType($id)
    {
        $url_text = $this->url_text;

        $entitiesRel = Entity::with(['entType.relType2' => function ($query) use ($id) {
            $query->where('id', $id);
        }, 'language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('entType.relType2', function ($query) use ($id) {
            return $query->where('id', $id);
        })->get();

        return $entitiesRel;
    }

    public function getPropsRel($transtype_id, $type)
    {
        $url_text = $this->url_text;

        $propsRel = Property::with(['relType' => function ($query) use ($transtype_id, $type) {
            $query->where('transaction_type_id', $transtype_id);
        }, 'relType.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'propAllowedValues.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'fkEntType.entity.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('relType', function ($query) use ($transtype_id, $type) {
            return $query->where('transaction_type_id', $transtype_id);
        })->where('t_state_id', $type)->orderBy('form_field_order', 'asc')->get();

        return $propsRel;
    }

    public function getProps_($transtype_id, $type)
    {
        $url_text = $this->url_text;

        //verificar se com o transaction_type_id e o t_state_id existe um ent type ou rel type
        $existEntTypeWithProps = EntType::whereHas('properties', function ($query) use ($type) {
            return $query->where('t_state_id', $type);
        })->where('transaction_type_id', $transtype_id)->get();
        $existRelTypeWithProps = RelType::whereHas('properties', function ($query) use ($type) {
            return $query->where('t_state_id', $type);
        })->where('transaction_type_id', $transtype_id)->get();

        //inicializar as variaveis de estado a falso e as colecções a null
        $props = null;
        $propsRel = null;
        $rel_type_id=null;

        //se com o transaction type id e o t_state_id existem tipos de entidade entao procura propriedades associadas a esse ent type
        if ($existEntTypeWithProps->isNotEmpty()) {
            //obter propriedades através do transaction type id e o t_state_id
            $props = Property::with(['entType' => function ($query) use ($transtype_id, $type) {
                $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id', NULL);
            }, 'entType.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'propAllowedValues.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'propertiesReading.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            },/* 'propertiesReading.values.entity.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'propertiesReading.values.entity.transactionState.transaction.transactionType.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'propertiesReading.values.entity.transactionState.transaction' => function ($query) use ($url_text) {
                $query->where('process_id', 1);
            },*/
                'propAllowedValues.entType', 'fkEntType.entity.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text)->orderBy('name', 'asc');
                }])->whereHas('entType', function ($query) use ($transtype_id, $type) {
                return $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id', NULL);
            })->where('t_state_id', $type)
                ->orderBy('form_field_order', 'asc')->get();

            /*$props->map(function ($prop, $keyprop) use ($url_text)
            {
                $transactionsPropsEntTypes = DB::table('transaction')
                    ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                    ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                    ->join('entity', 'entity.transaction_state_id', '=', 'transaction_state.id')
                    ->join('ent_type', 'ent_type.id', '=', 'entity.ent_type_id')
                    ->join('property', 'property.ent_type_id', '=', 'ent_type.id')
                    ->join('property_can_read_property', 'property_can_read_property.reading_property', '=', 'property.id')
                    ->join('property as prov_prop', 'property_can_read_property.providing_property', '=', 'prov_prop.id')
                    ->leftJoin('value', 'value.property_id', '=', 'prov_prop.id')
                    ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                    ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                    ->join('entity_name', 'entity_name.entity_id', '=', 'entity.id')
                    ->join('property_name', 'property_name.property_id', '=', 'property.id')
                    ->join('property_name as prov_prop_name', 'prov_prop_name.property_id', '=', 'prov_prop.id')
                    ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                    ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                    ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                    ->join('language as l3', 'entity_name.language_id', '=', 'l3.id')
                    ->join('language as l4', 'property_name.language_id', '=', 'l4.id')
                    ->join('language as l5', 'prov_prop_name.language_id', '=', 'l5.id')
                    ->select('transaction.id as transaction_id', 'transaction_type_name.t_name', 't_state_name.name as t_state_name' ,
                        'transaction_state.created_at' , 'property.id as property_id',
                        'property_name.name as property_name', 'prov_prop.id as prov_prop_id', 'prov_prop_name.name as prov_prop_name', 'value.value')
                    ->where('l1.slug','=',$url_text)
                    ->where('l2.slug','=',$url_text)
                    ->where('l3.slug','=',$url_text)
                    ->where('l4.slug','=',$url_text)
                    ->where('l5.slug','=',$url_text)
                    ->where('property.id', '=', $prop->id);

                $transactionsProps = DB::table('transaction')
                    ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                    ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                    ->join('relation', 'relation.transaction_state_id', '=', 'transaction_state.id')
                    ->join('rel_type', 'rel_type.id', '=', 'relation.rel_type_id')
                    ->join('property', 'property.rel_type_id', '=', 'rel_type.id')
                    ->join('property_can_read_property', 'property_can_read_property.reading_property', '=', 'property.id')
                    ->join('property as prov_prop', 'property_can_read_property.providing_property', '=', 'prov_prop.id')
                    ->leftJoin('value', 'value.property_id', '=', 'prov_prop.id')
                    ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                    ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                    ->join('relation_name', 'relation_name.relation_id', '=', 'relation.id')
                    ->join('property_name', 'property_name.property_id', '=', 'property.id')
                    ->join('property_name as prov_prop_name', 'prov_prop_name.property_id', '=', 'prov_prop.id')
                    ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                    ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                    ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                    ->join('language as l3', 'relation_name.language_id', '=', 'l3.id')
                    ->join('language as l4', 'property_name.language_id', '=', 'l4.id')
                    ->join('language as l5', 'prov_prop_name.language_id', '=', 'l5.id')
                    ->select('transaction.id as transaction_id', 'transaction_type_name.t_name', 't_state_name.name as t_state_name',
                         'transaction_state.created_at', 'property.id as property_id',
                        'property_name.name as property_name', 'prov_prop.id as prov_prop_id', 'prov_prop_name.name as prov_prop_name', 'value.value')
                    ->where('l1.slug','=',$url_text)
                    ->where('l2.slug','=',$url_text)
                    ->where('l3.slug','=',$url_text)
                    ->where('l4.slug','=',$url_text)
                    ->where('l5.slug','=',$url_text)
                    ->where('property.id', '=', $prop->id)
                    ->union($transactionsPropsEntTypes)
                    ->get();

                //$prop['PropertiesInfo'] = "";
                if ($prop->propertiesReading->isNotEmpty() && ($transactionsProps->isNotEmpty()))
                {
                    $this->array_push_assoc($prop,'PropertiesInfo', $transactionsProps);
                }

                $transactionsEntTypesProps = DB::table('transaction')
                    ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                    ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                    ->join('entity', 'entity.transaction_state_id', '=', 'transaction_state.id')
                    ->join('ent_type', 'ent_type.id', '=', 'entity.ent_type_id')
                    ->join('property', 'property.ent_type_id', '=', 'ent_type.id')
                    ->join('property_can_read_ent_type', 'property_can_read_ent_type.reading_property', '=', 'property.id')
                    ->join('ent_type as prov_ent_type', 'property_can_read_ent_type.providing_ent_type', '=', 'prov_ent_type.id')
                    ->join('property as prov_props', 'prov_props.ent_type_id', '=', 'prov_ent_type.id')
                    ->leftJoin('value', 'value.property_id', '=', 'prov_props.id')
                    ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                    ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                    ->join('entity_name', 'entity_name.entity_id', '=', 'entity.id')
                    ->join('property_name', 'property_name.property_id', '=', 'property.id')
                    ->join('property_name as prov_prop_name', 'prov_prop_name.property_id', '=', 'prov_props.id')
                    ->join('transaction_type_name', 'transaction_type_name.transaction_type_id', '=', 'transaction_type.id')
                    ->join('language as l1', 't_state_name.language_id','=', 'l1.id')
                    ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                    ->join('language as l3', 'entity_name.language_id', '=', 'l3.id')
                    ->join('language as l4', 'property_name.language_id', '=', 'l4.id')
                    ->join('language as l5', 'prov_prop_name.language_id', '=', 'l5.id')
                    ->select('transaction.id as transaction_id', 'transaction_type_name.t_name', 't_state_name.name as t_state_name',
                        'transaction_state.created_at', 'property.id as property_id',
                        'property_name.name as property_name', 'prov_props.id as prov_prop_id', 'prov_prop_name.name as prov_prop_name', 'value.value')
                    ->where('l1.slug','=',$url_text)
                    ->where('l2.slug','=',$url_text)
                    ->where('l3.slug','=',$url_text)
                    ->where('l4.slug','=',$url_text)
                    ->where('l5.slug','=',$url_text)
                    ->where('property.id', '=', $prop->id)
                    ->get();

                    //$prop['PropertiesInfo'] = "";
                    if ($prop->propertiesReading->isNotEmpty() && ($transactionsEntTypesProps->isNotEmpty()))
                    {
                        $this->array_push_assoc($prop,'PropertiesInfoEntType', $transactionsEntTypesProps);
                        //$prop['PropertiesInfo'] = $transactions;
                    }
            });*/

            //se não existem propriedades nesse ent type nao é preciso modificar o array
            if ($props->isNotEmpty()) {
                //modificar o array adicionando as propriedades desse ent type um campo a informar se tem ent type associado
                $props->map(function ($valueProp, $keyProp) {
                    $valueProp['has_entType'] = "false";
                    if ($valueProp->value_type == "enum") {
                        if ($valueProp->propAllowedValues->isNotEmpty()) {
                            foreach ($valueProp->propAllowedValues as $keyPropAllVal => $valuePropAllVal) {
                                if ($valuePropAllVal->entType->isNotEmpty()) {
                                    $valueProp['has_entType'] = "true";
                                    break;
                                }
                            }
                        } else {
                            //não é necessário neste momento da implementação
                        }
                    }
                });
            }


            $val = null;
            $existParEntType = $this->verifIfEntTypeHasParEntType($transtype_id, $type);
            if ($existParEntType['existEntTypeWithParEntType'] === true) {
                $val = $this->getParPropTypeVal($transtype_id, $type);
            }

            $data = array(
                'emptyEntTypeProp' => $existEntTypeWithProps->isEmpty(),
                'emptyRelTypeProp' => $existRelTypeWithProps->isEmpty(),
                'data' => $props,
                'rel_type_id' => $rel_type_id, //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type,
                'par_prop_type_val' => $val
            );

            return response()->json($data, 200);
        }
        else if ($existRelTypeWithProps->isNotEmpty()) //se não existirem ent types mas existir rel type entao procura pelas propriedades desse rel type
        {
            $propsRel = $this->getPropsRel($transtype_id, $type); //obter as propriedades associadas a esse rel type

            //se nao existirem propriedades nesse rel type e não existirem rel types então o id do rel type é nulo
            if ($existRelTypeWithProps->isEmpty())
            {
                $rel_type_id=null;
            }
            else if ($existRelTypeWithProps->isNotEmpty()) //se existirem propriedades nesse rel type então o id do rel type é o campo do primeiro objecto da colecção
            {
                $rel_type_id = $existRelTypeWithProps->first()->id;
            }

            $data = array(
                'emptyEntTypeProp' => $existEntTypeWithProps->isEmpty(),
                'emptyRelTypeProp' => $existRelTypeWithProps->isEmpty(),
                'data' => $propsRel,
                'rel_type_id' => $rel_type_id //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type
            );

            return response()->json($data, 200);
        }
        else
        {
            $data = array(
                'emptyEntTypeProp' => $existEntTypeWithProps->isEmpty(),
                'emptyRelTypeProp' => $existRelTypeWithProps->isEmpty(),
                'data' => null,
                'rel_type_id' => $rel_type_id //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type
            );

            return response()->json($data, 400);
        }
    }

    private function getPropsInfoProp($prop_id)
    {
        $url_text = $this->url_text;
        $lang_id = Language::where('slug', $url_text)->first()->id;

        $existPropCanReadProp = PropertyCanReadProperty::where('reading_property', $prop_id)->get();

        $transactionsProps = collect();
        if ($existPropCanReadProp->isNotEmpty()) {
            $transactionsPropsEntTypes = DB::table('transaction')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('entity', 'entity.transaction_id', '=', 'transaction.id')
                ->join('ent_type', 'ent_type.id', '=', 'entity.ent_type_id')
                ->join('property', 'property.ent_type_id', '=', 'ent_type.id')
                ->join('property_can_read_property', 'property_can_read_property.reading_property', '=', 'property.id')
                ->join('property as prov_prop', 'property_can_read_property.providing_property', '=', 'prov_prop.id')
                ->leftJoin('value', 'value.property_id', '=', 'prov_prop.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->select('transaction.id as transaction_id', 'transaction_type.id as transaction_type_id', 't_state.id as t_state_id',
                    'transaction_state.created_at', 'property.id as property_id',
                    'prov_prop.id as prov_prop_id', 'value.value')
                ->where('property.id', '=', $prop_id);

            $transactionsProps = DB::table('transaction')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('relation', 'relation.transaction_id', '=', 'transaction.id')
                ->join('rel_type', 'rel_type.id', '=', 'relation.rel_type_id')
                ->join('property', 'property.rel_type_id', '=', 'rel_type.id')
                ->join('property_can_read_property', 'property_can_read_property.reading_property', '=', 'property.id')
                ->join('property as prov_prop', 'property_can_read_property.providing_property', '=', 'prov_prop.id')
                ->leftJoin('value', 'value.property_id', '=', 'prov_prop.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->select('transaction.id as transaction_id', 'transaction_type.id as transaction_type_id', 't_state.id as t_state_id',
                    'transaction_state.created_at', 'property.id as property_id',
                    'prov_prop.id as prov_prop_id', 'value.value')
                ->where('property.id', '=', $prop_id)
                ->union($transactionsPropsEntTypes)
                ->get();

            foreach($transactionsProps as $transactionsProp)
            {
                $transactionsProp->t_name = TransactionTypeName::where('transaction_type_id','=',$transactionsProp->transaction_type_id)->where('language_id','=',$lang_id)->first()->t_name;
                $transactionsProp->t_state_name = TStateName::where('t_state_id','=',$transactionsProp->t_state_id)->where('language_id','=',$lang_id)->first()->name;
                $transactionsProp->property_name = PropertyName::where('property_id','=',$transactionsProp->property_id)->where('language_id','=',$lang_id)->first()->name;
                $transactionsProp->prov_prop_name = PropertyName::where('property_id','=',$transactionsProp->prov_prop_id)->where('language_id','=',$lang_id)->first()->name;
            }
        }

        return $transactionsProps;
    }

    private function getPropsInfoEntType($prop_id)
    {
        $url_text = $this->url_text;
        $lang_id = Language::where('slug', $url_text)->first()->id;

        $existPropCanReadEntType = PropertyCanReadEntType::where('reading_property', $prop_id)->get();

        $transactionsEntTypesProps = collect();
        if ($existPropCanReadEntType->isNotEmpty()) {
            $transactionsEntTypesProps = DB::table('transaction')
                ->join('transaction_type', 'transaction_type.id', '=', 'transaction.transaction_type_id')
                ->join('transaction_state', 'transaction_state.transaction_id', '=', 'transaction.id')
                ->join('entity', 'entity.transaction_id', '=', 'transaction.id')
                ->join('ent_type', 'ent_type.id', '=', 'entity.ent_type_id')
                ->join('property', 'property.ent_type_id', '=', 'ent_type.id')
                ->join('property_can_read_ent_type', 'property_can_read_ent_type.reading_property', '=', 'property.id')
                ->join('ent_type as prov_ent_type', 'property_can_read_ent_type.providing_ent_type', '=', 'prov_ent_type.id')
                ->join('property as prov_props', 'prov_props.ent_type_id', '=', 'prov_ent_type.id')
                ->leftJoin('value', 'value.property_id', '=', 'prov_props.id')
                ->join('t_state', 't_state.id', '=', 'transaction_state.t_state_id')
                ->select('transaction.id as transaction_id', 'transaction_type.id as transaction_type_id', 't_state.id as t_state_id',
                    'transaction_state.created_at', 'property.id as property_id',
                    'prov_prop.id as prov_prop_id', 'value.value')
                ->where('property.id', '=', $prop_id)
                ->get();

            foreach($transactionsEntTypesProps as $transactionsEntTypesProp)
            {
                $transactionsEntTypesProp->t_name = TransactionTypeName::where('transaction_type_id','=',$transactionsEntTypesProp->transaction_type_id)->where('language_id','=',$lang_id)->first()->t_name;
                $transactionsEntTypesProp->t_state_name = TStateName::where('t_state_id','=',$transactionsEntTypesProp->t_state_id)->where('language_id','=',$lang_id)->first()->name;
                $transactionsEntTypesProp->property_name = PropertyName::where('property_id','=',$transactionsEntTypesProp->property_id)->where('language_id','=',$lang_id)->first()->name;
                $transactionsEntTypesProp->prov_prop_name = PropertyName::where('property_id','=',$transactionsEntTypesProp->prov_prop_id)->where('language_id','=',$lang_id)->first()->name;
            }
        }

        return $transactionsEntTypesProps;
    }

    public function getProps($transtype_id, $type, $option = null)
    {
        $url_text = $this->url_text;
        $user_id = $this->user_id;

        //verificar se o utilizador é externo ou interno
        $getUser = User::find($user_id);

        //verificar se com o transaction_type_id e o t_state_id existe um ent type ou rel type
        $existEntTypeWithProps = EntType::whereHas('properties', function ($query) use ($type) {
            return $query->where('t_state_id', $type);
        })->where('transaction_type_id', $transtype_id)->get();
        $existRelTypeWithProps = RelType::whereHas('properties', function ($query) use ($type) {
            return $query->where('t_state_id', $type);
        })->where('transaction_type_id', $transtype_id)->get();

        //inicializar as variaveis de estado a falso e as colecções a null
        $props = null;
        $propsRel = null;
        $rel_type_id=null;

        //\Log::debug($type);
        //\Log::debug($existEntTypeWithProps);
        //se com o transaction type id e o t_state_id existem tipos de entidade entao procura propriedades associadas a esse ent type
        if ($existEntTypeWithProps->isNotEmpty()) {
            //if ($getUser->user_type == "external") {
                //obter propriedades através do transaction type id e o t_state_id
                $props = Property::with(['entType' => function ($query) use ($transtype_id, $type) {
                    $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id', NULL);
                }, 'entType.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                }, 'language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                }, 'propAllowedValues.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                }, 'propertiesReading.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                }, 'propAllowedValues.entType', 'fkEntType.entity.language' => function ($query) use ($url_text) {
                        $query->where('slug', $url_text)->orderBy('name', 'asc');
                }, 'fkProperty.language' => function ($query) use ($url_text) {
                        $query->where('slug', $url_text)->orderBy('name', 'asc');
                }, 'fkProperty.values' => function ($query) use ($getUser) {
                       //$query->where('entity_id', $getUser->entity_id);
                        if ($getUser->user_type == "external") {
                            $query->whereHas('updatedBy', function ($query) use ($getUser) {
                                return $query->where('entity_id', $getUser->entity_id);
                            });
                        }
                }])->whereHas('entType', function ($query) use ($transtype_id, $type) {
                    return $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id', NULL);
                })->where('t_state_id', $type)
                    ->orderBy('form_field_order', 'asc')->get();
            //}

            $props->map(function ($prop, $keyprop) use ($url_text)
            {
                $transactionsProps = $this->getPropsInfoProp($prop->id);

                if ($prop->propertiesReading->isNotEmpty() && ($transactionsProps->isNotEmpty()))
                {
                    $this->array_push_assoc($prop,'PropertiesInfo', $transactionsProps);
                }

                $transactionsEntTypesProps = $this->getPropsInfoEntType($prop->id);

                if ($prop->propertiesReading->isNotEmpty() && ($transactionsEntTypesProps->isNotEmpty()))
                {
                    $this->array_push_assoc($prop,'PropertiesInfoEntType', $transactionsEntTypesProps);
                }
            });

            //se não existem propriedades nesse ent type nao é preciso modificar o array
            if ($props->isNotEmpty()) {
                //modificar o array adicionando as propriedades desse ent type um campo a informar se tem ent type associado
                $props->map(function ($valueProp, $keyProp) {
                    $valueProp['has_entType'] = "false";
                    if ($valueProp->value_type == "enum") {
                        if ($valueProp->propAllowedValues->isNotEmpty()) {
                            foreach ($valueProp->propAllowedValues as $keyPropAllVal => $valuePropAllVal) {
                                if ($valuePropAllVal->entType->isNotEmpty()) {
                                    $valueProp['has_entType'] = "true";
                                    break;
                                }
                            }
                        } else {
                            //não é necessário neste momento da implementação
                        }
                    }
                });
            }


            $val = null;
            $existParEntType = $this->verifIfEntTypeHasParEntType($transtype_id, $type);
            if ($existParEntType['existEntTypeWithParEntType'] === true) {
                $val = $this->getParPropTypeVal($transtype_id, $type);
            }

            $data = array(
                'emptyEntTypeProp' => $existEntTypeWithProps->isEmpty(),
                'emptyRelTypeProp' => $existRelTypeWithProps->isEmpty(),
                'data' => $props,
                'rel_type_id' => $rel_type_id, //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type,
                'par_prop_type_val' => $val
            );
        }
        else if ($existRelTypeWithProps->isNotEmpty()) //se não existirem ent types mas existir rel type entao procura pelas propriedades desse rel type
        {
            $propsRel = $this->getPropsRel($transtype_id, $type); //obter as propriedades associadas a esse rel type

            //se nao existirem propriedades nesse rel type e não existirem rel types então o id do rel type é nulo
            if ($existRelTypeWithProps->isEmpty())
            {
                $rel_type_id=null;
            }
            else if ($existRelTypeWithProps->isNotEmpty()) //se existirem propriedades nesse rel type então o id do rel type é o campo do primeiro objecto da colecção
            {
                $rel_type_id = $existRelTypeWithProps->first()->id;
            }

            $data = array(
                'emptyEntTypeProp' => $existEntTypeWithProps->isEmpty(),
                'emptyRelTypeProp' => $existRelTypeWithProps->isEmpty(),
                'data' => $propsRel,
                'rel_type_id' => $rel_type_id //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type
            );
        }
        else
        {
            $data = array(
                'emptyEntTypeProp' => $existEntTypeWithProps->isEmpty(),
                'emptyRelTypeProp' => $existRelTypeWithProps->isEmpty(),
                'data' => null,
                'rel_type_id' => $rel_type_id //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type
            );
        }

        if ($option === null)
            return response()->json($data, $data['data'] !== null ? 200 : 400);
        else if ($option !== null)
            return $data;
    }

    private function verifIfEntTypeHasParEntType($transtype_id, $type)
    {
        $existPropEntTypeWithParEntType = EntType::whereHas('properties', function ($query) use ($type) {
            $query->where('value_type', '=', 'enum')->where('t_state_id', $type);
        })->whereHas('properties.propAllowedValues.entType', function ($query) use ($transtype_id, $type) {
            $query->where('transaction_type_id', $transtype_id);
        })->where('transaction_type_id', $transtype_id)
            ->get();

        $existEntTypeWithParEntType = EntType::whereHas('entType', function ($query) use ($transtype_id, $type) {
            $query->where('transaction_type_id', $transtype_id);
        })->where('transaction_type_id', $transtype_id)
            ->get();

        $data = array(
            'existPropEntTypeWithParEntType' => $existPropEntTypeWithParEntType->isNotEmpty(),
            'existEntTypeWithParEntType' => $existEntTypeWithParEntType->isNotEmpty()
        );

        return $data;
    }

    private function getParPropTypeVal($transtype_id, $type)
    {
        /*$existEntTypeWithParEntType = EntType::where('transaction_type_id', $transtype_id)
            ->where('t_state_id', '<', $type)
            ->whereNotNull('par_prop_type_val')
            ->get();

        if ($existEntTypeWithParEntType->isNotEmpty())
        {
            $par_ent_type_id = $existEntTypeWithParEntType->first()->par_ent_type_id;

            $prop = Property::whereHas('propAllowedValues.entType')->where('ent_type_id', $par_ent_type_id)->where('value_type','=', 'enum')->get();

            $par_prop_type_val = Value::where('property_id', $prop->first()->id)->first()->value;

            return $par_prop_type_val;
        }

        return false;*/

        $prop = Property::with('values')->whereHas('propAllowedValues.entType', function ($query) use ($transtype_id) {
            return $query->where('transaction_type_id', $transtype_id);
        })->whereHas('values')->where('value_type', '=', 'enum')->where('t_state_id', '<', $type)->get();

        $par_prop_type_val = $prop->first()['values'][0]['value'];

        return $par_prop_type_val;
    }

    public function getPropsfromChild($id)
    {
        $url_text = $this->url_text;

        $props = Property::with(['entType' => function ($query) use ($id) {
            $query->where('par_prop_type_val', $id);
        }, 'entType.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'propAllowedValues.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'fkEntType.entity.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('entType', function ($query) use ($id) {
            return $query->where('par_prop_type_val', $id);
        })->orderBy('form_field_order', 'asc')->get();

        if ($props->isEmpty())
        {
            return response()->json(null, 400);
        }
        else
        {
            return response()->json($props, 200);
        }
    }

    //provavelmente é possível executar numa só query, verificar essa possibilidade
    public function getAllProcessOfTr($trans_id)
    {
        $url_text = $this->url_text;
        $user_id = $this->user_id;

        //verificar se o utilizador é externo ou interno
        $getUser = User::find($user_id);

        $getTransType = TransactionType::find($trans_id);
        if ($getUser->user_type == "external") //se é externo é necessário
        {
            $processes = Process::with(['language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            })->whereHas('updatedBy', function ($query) use ($getUser) {
                $query->where('entity_id', $getUser->entity_id);
            })->where('process_type_id', $getTransType->process_type_id)->where('proc_state', 'execution')->get();
        }
        else
        {
            //se é interno então faz esta parte
            $processes = Process::with(['language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            })/*->whereHas('transactions.transactionType.iniciatorActor.role.user', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })*/->whereHas('processType.transactionsTypes.iniciatorActor.role.user', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })/*->whereHas('processType.transactionsTypes', function ($query) use ($trans_id) {
                $query->where('id', $trans_id);
            })*/->where('process_type_id', $getTransType->process_type_id)->where('proc_state', 'execution')->get(); //->where('flag','execution') adicionar depois de mudar a base de dados
        }

        $processesAlt = $processes->filter(function ($process_item, $process_key) use ($trans_id) {
            $result = $this->verifCanUseProc($trans_id, $process_item->id);
            return $result === true;
        });

        //necessário fazer sempre return do item a mexer no array map senao array vem vazio
        /*$processesAlt = $processes->transform(function ($process_item, $process_key) use ($trans_id) {
            $result = $this->verifCanUseProc($trans_id, $process_item->id);
            if ($result === true)
            {
                return $process_item;
            }
        });*/

        /*foreach ($processes as $process_key => $process_value)
        {
            $result = $this->verifCanUseProc($trans_id, $process_value->id);
            if ($result === false)
            {
                $processes->pull($process_key);
            }
        }*/

        //dd($processes);

        //chamar o método values para reorganizar os indices da colecçao
        return $processesAlt->values();
    }


    public function getStatesFromTransaction($id)
    {
        $url_text = $this->url_text;
        $trans = TransactionState::with(['tState.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            },'transaction.transactionType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'transactionAck.user'])->whereHas('tState.language')
            ->where('transaction_id', $id)
            ->orderby('created_at','asc')
            ->orderBy('id', 'asc')
            ->get();

        $data = array(
            'data' => $trans->isEmpty() ? null : $trans,
            't_state_id' => $trans->isEmpty() ? null : $trans->last()->tState->id,
            't_state_name' => $trans->isEmpty() ? null : $trans->last()->tState->language[0]->pivot->name
        );

        return response()->json($data);
    }

    private function transactionStateMissesEntityOrRelation($id, $t_state_id, $trans_type_id)
    {
        $existEntType = EntType::where('transaction_type_id', $trans_type_id)->whereHas('properties', function ($query) use ($t_state_id) {
            $query->where('t_state_id', $t_state_id);
        })->get();
        $existRelType = RelType::where('transaction_type_id', $trans_type_id)->whereHas('properties', function ($query) use ($t_state_id) {
            $query->where('t_state_id', $t_state_id);
        })->get();

        $ents = null;
        $rels = null;
        $lacksEntity = false;
        $lacksRelation = false;
        if ($existEntType->isNotEmpty())
        {
            $ents = Transaction::whereHas('entities')
                ->whereHas('transactionStates', function ($query) use ($t_state_id) {
                $query->where('t_state_id', $t_state_id);
            })->where('id', $id)->get();
            //\Log::debug($ents);
            if ($ents->isEmpty())
            {
                $lacksEntity = true;
            }
            else
            {
                $lacksEntity = false;
            }
        }
        else if ($existRelType->isNotEmpty())
        {
            $rels = Transaction::whereHas('relations')
                ->whereHas('transactionStates', function ($query) use ($t_state_id) {
                $query->where('t_state_id', $t_state_id);
            })->where('id', $id)->get();
            if ($rels->isEmpty())
            {
                $lacksRelation = true;
            }
            else
            {
                $lacksRelation = false;
            }
        }
        else
        {

        }

        return array('lacksEntity' => $lacksEntity, 'lacksRelation' => $lacksRelation);
    }

    public function verifyIfCanDoNextTransactionState(Request $request, $id)
    {
        $States = Array(1=>'Request', 2=>'Promise', 3=>'Execute', 4=>'State', 5=>'Accept');

        $t_state_id = $request->input('t_state_id');
        $actorCan = $request->input('actorCan');
        $transaction_type_id = $request->input('transaction_type_id');

        if ($t_state_id == 1)
            $arrayResult = $this->transactionStateMissesEntityOrRelation($id, $t_state_id, $transaction_type_id);
        else
            $arrayResult = array('lacksEntity' => false, 'lacksRelation' => false);

        //\Log::debug($arrayResult);
        $canAdvance = false;
        $nextState=null;
        if ($arrayResult['lacksEntity'] === false && $arrayResult['lacksRelation'] === false) {
            if (($actorCan == 'Executer' && ($t_state_id == 1 || $t_state_id == 2 || $t_state_id == 3)) || ($actorCan == 'Iniciator' && $t_state_id == 4)) {
                $nextState = $this->get_next($States, $t_state_id);
                $canAdvance = true;
            } else {
                $canAdvance = false;
            }
        }
        else
        {
            if ($actorCan == 'Iniciator' && $t_state_id == 1)
            {
                $nextState = $t_state_id;
                $canAdvance = true;
            }
        }

        $data = array(
            'nextState' => $nextState,
            'canAdvance' => $canAdvance
        );


        if ($canAdvance === true)
        {
            return response()->json($data, 200);
        }
        else if ($canAdvance === false)
        {
            return response()->json($data, 400);
        }
    }

    public function verifCanUseProc($transaction_type_id, $process_id)
    {
        $canAdvance = false;
        $trans_type_id = $transaction_type_id;
        $proc_id = $process_id;

        //verificar se existem causal links desse transaction type id
        $getCausalLinksFromTransTypeID = CausalLink::where('caused_t', $trans_type_id)->get();

        if ($getCausalLinksFromTransTypeID->isEmpty())
        {
            $canAdvance = true;
        }
        else
        {
            //contar o número de max dos causal links
            if ($getCausalLinksFromTransTypeID->contains('max','*'))
            {
                $maxCausalLink = '*';
            }
            else
            {
                $maxCausalLink = $getCausalLinksFromTransTypeID->sum('max');
            }

            if ($maxCausalLink !== '*')
            {
                $getExistentTransactionsFromProc = Process::with(['transactions' => function ($query) use ($trans_type_id) {
                    $query->where('transaction_type_id', $trans_type_id);
                }])->where('id', $proc_id)->get();

                $numberExistTrans = $getExistentTransactionsFromProc->first()->transactions->count();

                if ($numberExistTrans >= $maxCausalLink)
                {
                    $canAdvance = false;
                }
                else
                {
                    $canAdvance = true;
                }
            }
            else
            {
                $canAdvance = true;
            }

        }

        return $canAdvance;
    }

    public function transactionAckAll(Request $request)
    {
        $user_id = $this->user_id;
        $trans_state_id = $request->input('trans_state_id');

        $existsTransAck = $this->verifTransactionAckExists($trans_state_id);
        if ($existsTransAck->isEmpty())
        {
            $success = $this->insertTransactionAck($trans_state_id, $user_id);

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
        else
        {
            $returnData = array(
                'message' => 'Transaction Acknowledge already exists!'
            );

            return Response::json($returnData, 401);
        }
    }

    private function verifTransactionAckExists($trans_state_id)
    {
        $transAck = TransactionAck::where('transaction_state_id', $trans_state_id)->get();

        return $transAck;
    }

    private function insertTransactionAck($trans_state_id, $user_id)
    {
        $transaction_ack = new TransactionAck;

        DB::beginTransaction();
        try {
            $transaction_ack->user_id = $user_id;
            $transaction_ack->transaction_state_id = $trans_state_id;
            $transaction_ack->save();

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }

        return $success;
    }

    /*public function verifCanUseProc(Request $request)
    {
        $url_text = 'PT';
        $user_id = 1;

        $canAdvance = false;
        $trans_type_id = $request->input('transaction_type_id');
        $process_id = $request->input('process_id');

        //verificar se existem causal links desse transaction type id
        $getCausalLinksFromTransTypeID = CausalLink::where('caused_t', $trans_type_id)->get();

        if ($getCausalLinksFromTransTypeID->isEmpty())
        {
            $canAdvance = true;
        }
        else
        {
            //contar o número de max dos causal links
            if ($getCausalLinksFromTransTypeID->contains('max','*'))
            {
                $maxCausalLink = '*';
            }
            else
            {
                $maxCausalLink = $getCausalLinksFromTransTypeID->sum('max');
            }

            if ($maxCausalLink !== '*')
            {
                $getExistentTransactionsFromProc = Process::with(['transactions' => function ($query) use ($trans_type_id) {
                    $query->where('transaction_type_id', $trans_type_id);
                }])->where('id', $process_id)->get();

                $numberExistTrans = $getExistentTransactionsFromProc->first()->transactions->count();

                if ($numberExistTrans >= $maxCausalLink)
                {
                    $canAdvance = false;
                }
                else
                {
                    $canAdvance = true;
                }
            }
            else
            {
                $canAdvance = true;
            }

        }

        return response()->json($canAdvance);
    }*/

    private function get_next($array, $key) {
        $currentKey = key($array);
        while ($currentKey !== null && $currentKey != $key) {
            next($array);
            $currentKey = key($array);
        }
        next($array);
        return key($array);
        //return next($array);
    }

    //Inicio - Guilherme

    public function customFormUserCanInit_()
    {
        //Buscar todos os customForm por utilizador
        $user_id = 1;
        $custom_forms = $this->getAllCustomFormByUser($user_id);

        return response()->json($custom_forms);
    }

    //Função para buscar os custom form onde nenhuma das transações inicia um processo
    public function customFormNotInitProcess(Request $request)
    {
        $url_text = "PT";

        $custom_form_id = $request->input('custom_form_id');
        $process_id = $request->input('process_id');
        $custom_form = CustomForm::find($custom_form_id);
        $t_state_id = $custom_form->t_state_id;

        //Criar um array que armezana os nomes das transações caso não essa possivel avançar no casual ou waiting
        $dataError = array(
            "CausalTransaction" => array (),
            "WaitingTransaction" => array ()
        );

        //Inicialização das variáveis
        $canAdvanceCausal = true;
        $canAdvanceWaiting = true;

        //Retirar os custom form que possuem transações com init_proc = 1 (inicia um novo processo)
        foreach($custom_form->transactionTypes as $key => $transactio_type)
        {
            //Verificar o causal link
            if(!$this->verifCanUseProc($transactio_type->id, $process_id))
            {
                $canAdvanceCausal = false;
                array_push($dataError['CausalTransaction'], $transactio_type->language->where('slug', $url_text)->first()->pivot->t_name);
            }

            //verificar o waiting link
            $verifyWaitingLink = $this->customFormWaitingLink($transactio_type->id, $process_id, $t_state_id);
            if(!$verifyWaitingLink['canAdvance'])
            {
                $canAdvanceWaiting = false;
                array_push($dataError['WaitingTransaction'], $verifyWaitingLink['dataTransactionsLacking']['transaction_type_name']);
            }
        }

        //Construir array de resposta com os seguintes dados
        //Causal e Waiting = Booleanos (Verificão se pode avançar, caso seja true)
        //dataError = Array (Indica as transações necessárias no causal e waiting)
        $returnDataError = array(
            'Causal' => $canAdvanceCausal,
            'Waiting' => $canAdvanceWaiting,
            'dataError' => $dataError
        );

        if ($canAdvanceCausal && $canAdvanceWaiting)
            //Caso pode avançar enviar uma reposta com status 200 de sucesso
            return response()->json($returnDataError, 200);
        else
            //Se não poder avançar enviar com status 401
            return response()->json($returnDataError, 401);
    }

    public function customFormWaitingLink($trans_id, $proc_id, $t_state_id)
    {
        $existsAllTransactions = true;
        $url_text = "PT";

        //Verificar se existe waitingLink trasanção num tipo de estado
        $waitinglinks = WaitingLink::where('waiting_t', $trans_id)->where('waiting_fact', $t_state_id)->get();
        $transactionsLacking = array();

        //Buscar os waitinglinks do processo = $proc_id
        foreach ($waitinglinks as $waitinglink) {
            foreach ($waitinglink->waitedT->processType->processes as $keyProcess => $valueProcess) {
                if ($valueProcess->id != $proc_id) {
                    $waitinglink->waitedT->processType->processes->forget($keyProcess);
                } else {
                    foreach ($valueProcess->transactions as $keyTransaction => $valueTransaction) {
                        //obter apenas as transacções que são do tipo de transacção da waited t (transacção que tem de ser executada antes da waiting t)
                        if ($valueTransaction->transaction_type_id != $waitinglink->waitedT->id) //$value contem toda a informação do objecto id,etc
                        {
                            $valueProcess->transactions->forget($keyTransaction);
                        } else {
                            foreach ($valueTransaction->transactionStates as $keyTState => $valueTState) {
                                if ($valueTState->t_state_id != $waitinglink->waited_fact) {
                                    $valueTransaction->transactionStates->forget($keyTState);
                                }
                            }

                            if ($valueTransaction->transactionStates->isEmpty()) //repensar esta parte
                            {
                                $valueProcess->transactions->forget($keyTransaction);
                            }
                        }
                    }
                }
            }
        }

        foreach ($waitinglinks as $waitinglink) {
            foreach ($waitinglink->waitedT->processType->processes as $keyProcess => $valueProcess) {
                if (($valueProcess->transactions->isEmpty()) || $valueProcess->transactions->count() < $waitinglink->min) {
                    $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_id', $waitinglink->waitedT->id);
                    $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_name', $waitinglink->waitedT->language->where('slug', $url_text)->first()->pivot->t_name);
                    $transactionsLacking = $this->array_push_assoc($transactionsLacking, 't_state_id', $waitinglink->waited_fact);
                    $existsAllTransactions = false;
                    break 2;
                }
            }

            if ($waitinglink->waitedT->processType->processes->isEmpty()) {
                $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_id', $waitinglink->waitedT->id);
                $transactionsLacking = $this->array_push_assoc($transactionsLacking, 'transaction_type_name', $waitinglink->waitedT->language->where('slug', $url_text)->first()->pivot->t_name);
                $transactionsLacking = $this->array_push_assoc($transactionsLacking, 't_state_id', $waitinglink->waited_fact);
                $existsAllTransactions = false;
            }
        }

        $data = array(
            'canAdvance' => $existsAllTransactions,
            'dataTransactionsLacking' => $transactionsLacking,
            'data' => $waitinglinks
        );

        return $data;
    }

    public function getProcessCustomForm($id)
    {
        $url_text = 'PT';
        $user_id = 1;

        //verificar se o utilizador é externo ou interno
        $getUser = User::find($user_id);

        if ($getUser->user_type == "external") //se é externo é necessário
        {
            $processes = Process::with(['language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            })->whereHas('updatedBy', function ($query) use ($getUser) {
                $query->where('entity_id', $getUser->entity_id);
            })->where('proc_state', 'execution')->get();
        }
        else
        {
            //se é interno então faz esta parte
            $processes = Process::with(['language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('language', function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            })->whereHas('transactions.transactionType.iniciatorActor.role.user', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->whereHas('processType.transactionsTypes', function ($query) use ($url_text) {
            })->where('proc_state', 'execution')->get();
        }

        return response()->json($processes);
    }

    public function getAllCustomFormByUser ($user_id)
    {
        $url_text = 'PT';

        //Buscar todos custom form
        $custom_forms = CustomForm::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('transactionTypes.language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->get();

        //Buscar só os custom form que o utilizador pode realizar, cosoante o T_State do custom form
        foreach ($custom_forms as $key_c => $custom_form)
        {
            //Corrigir o array dos custom, de acordo com Utilizador
            //verificar os T_States
            $existCustom = false;

            //Request, Accept => iniciatorActor
            //Promise, Execute, State => Executor
            switch($custom_form->t_state_id)
            {
                //Request, Accept
                case 1:
                case 5:
                    //Buscar todos os Actor Iniciators do primeiro tipo de transação. Assumindo que todos tipos de transações são iniciados pelo mesmo iniciador.
                    foreach($custom_form->transactionTypes->first()->iniciatorActor as $key_u => $actor)
                    {
                        $actor_id = $actor->id;
                        //Buscar os roles e users do $actor
                        $actors = Actor::with(['role.user' => function($query) use ($actor_id) {
                            $query->where('id', $actor_id);
                        }])->whereHas('role.user', function ($query) use ($actor_id){
                            return $query->where('id', $actor_id);
                        })->get();

                        //Percorrer todos os actores do tipo de transação
                        foreach($actors as $actor_r)
                        {
                            //Verificar se existe o Utilizador
                            foreach($actor_r->role as $role)
                            {
                                //Verificar se existe utilizador no role
                                if($role->user->where('id', $user_id)->isNotEmpty())
                                {
                                    //Caso o Utilizador não seja o executer, apagar o custom form da coleção
                                    $existCustom = true;
                                }
                            }
                        }
                    }

                    if(!$existCustom)
                        //Caso o utilizador nao pode iniciar este custom form, será removido da coleção
                        $custom_forms->forget($key_c);
                    break;

                case 2:
                case 3:
                case 4:
                    //Verificar o executor das transações. Assumindo que todos tipos de transações são realizadas pelo mesmo excutor. Buscamos somente a primeira tipo de transação
                    if($custom_form->transactionTypes->first()->executer == $user_id)
                        //O utilizador pode realizar este custom Form
                        $existCustom = true;
                    else
                        //Caso o Utilizador não seja o executer, apagar o custom form da coleção
                        $custom_forms->forget($key_c);
                    break;
            }


            //Caso este custom form pertence ao Utilizador, verificar se inicia um processo
            if($existCustom)
            {
                //Acrescentar o Campo $init_proc ao objeto. Serve para sabe se o custom form Inicia um processo
                $init_proc = false;
                //verificar cada transação do custom form
                foreach ($custom_form->transactionTypes as $key_t => $transaction_type)
                {
                    if ($transaction_type->init_proc == 1 )
                    {
                        $init_proc = true;
                        break;
                    }
                }
                //verficar se inicia um processo após verificar todas as transações ou até encontrar um transação que inicia um processo
                //adicionar um novo campo a coleção: Se iniciar um processo => init_proc = 1
                if($init_proc)
                    $custom_form->init_proc = 1;
                else
                    $custom_form->init_proc = 0;
            }
        }

        return $custom_forms;
    }

    public function insertCustomForm(Request $request)
    {
        $url_text = 'PT';
        $language_id = 1;
        $data = json_decode(json_encode($request->all()));

        //Inserção dos Dados
        DB::beginTransaction();
        try {

            foreach ($data as $col)
            {
                //Caso um dos tipos de transações inicia um processo
                if ($col->process_id === null)
                {
                    //Criar um Novo Processo
                    $process = new Process;
                    $process->process_type_id = $col->process_type_id;
                    $process->proc_state = "execution";
                    $process->state = "active";
                    $process->save();

                    //Buscar o tipo de processo
                    $process_type = ProcessType::with(['language' => function ($query) use ($url_text) {
                        $query->where('slug', $url_text);
                    }])->whereHas('language', function ($query) use ($url_text) {
                        return $query->where('slug', $url_text);
                    })->where('id', $col->process_type_id)->first();

                    $process->language()->attach($language_id, ['name' =>  $process_type->language[0]->pivot->name . " " . $process->id]);

                    //Verificar se existe um processo
                    $col->process_id = $process->id;
                }

                //Inserir todas as transações do custom form
                foreach($col->tab[0]->propsform->transaction_types as $transaction_type)
                {
                    //Inserir uma nova transação
                    $transaction = new Transaction;
                    $transaction->transaction_type_id = $transaction_type->id;
                    $transaction->state = "active";
                    $transaction->process_id = $col->process_id; //buscar o processo ID
                    $transaction->save();

                    //Inserir um novo estado da transação
                    $transactionState = new TransactionState;
                    $transactionState->transaction_id = $transaction->id;
                    $transactionState->t_state_id = $col->tab[0]->propsform->t_state_id;
                    $transactionState->save();

                    //Inserir uma nova entitade
                    $entity = new Entity;
                    $entity->ent_type_id = $transaction_type->ent_type[0]->id;
                    $entity->state = "active";
                    $entity->transaction_id = $transaction->id;
                    $entity->save();

                    //Inserir o nome a Entidade
                    $entity->language()->attach($language_id, ['name' =>  $transaction_type->ent_type[0]->language[0]->pivot->name . " " . $col->process_id]);

                    //Buscar as Propriedades da Transação
                    //Verificar se o tipo de transação tem propriedades
                    if(!empty($transaction_type->ent_type[0]->properties))
                    {
                        //Buscar todas as propriedades do tipo de transação
                        foreach($transaction_type->ent_type[0]->properties as $property)
                        {
                            //Inserir os inputs das prorpiedades na tabela Value
                            if (!empty($property->fields))
                            {
                                $value = new Value;
                                $value->property_id = $property->id;
                                $value->entity_id = $entity->id;
                                $value->state = "active";
                                $currentValueField=null;

                                foreach ($property->fields as $prop) {
                                    $currentValueField = $prop;
                                    break; // or exit or whatever exits a foreach loop...
                                }

                                //Verificar se a propriedade é do tipo File
                                if($property->value_type === "file")
                                {
                                    $value->value = $this->uploadFile($currentValueField);
                                }
                                else
                                {
                                    $value->value = $currentValueField;
                                }
                                $value->save();
                            }

                        }
                    }
                }
            }

            DB::commit();
            $success = true;
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
            return response()->json($e->getMessage());
        }
        return response()->json("Sucesso");
    }

    public function getCustomFormProperties($id)
    {
        $url_text = 'PT';
        //Buscar os T State do Custom form
        $costum_form_state = CustomForm::find($id)->t_state_id;

        //Buscar toda informação do Custom form (Transactions Types, Ent Types, Proprieties)
        $costum_form_info = CustomForm::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes' => function($query) use ($url_text) {
            $query->orderBy('field_order', 'asc');
        }, 'transactionTypes.entType.properties' => function($query) use ($costum_form_state) {
            $query->where('t_state_id', $costum_form_state);
        }, 'transactionTypes.entType.properties.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.entType.properties.propAllowedValues.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionTypes.entType.properties.propertiesReading.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($costum_form_info);
    }
    //Fim - Guilherme
}
