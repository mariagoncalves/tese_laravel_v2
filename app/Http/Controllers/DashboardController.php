<?php

namespace App\Http\Controllers;

use App\CausalLink;
use App\Entity;
use App\Process;
use App\ProcessType;
use App\ProcessName;
use App\Property;
use App\Transaction;
use App\TransactionAck;
use App\TransactionType;
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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use DB;
use Response;
use Exception;

class DashboardController extends Controller
{
    //
    /*public function getAll(Request $request,$id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

            $firstTransactions = DB::table('transaction')
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
                ->join('process_name', 'process_name.process_id', '=', 'process.process_type_id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->join('language as l4', 'process_name.language_id', '=', 'l4.id')
                ->select('process_type_name.name as process_type_name','process_name.name as process_name','transaction.id as transaction_id','t_state_name.name as t_state_name','transaction_type_name.t_name',DB::raw("'Iniciator' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',1);

            $secondTransactions = DB::table('transaction')
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
                ->join('process_name', 'process_name.process_id', '=', 'process.process_type_id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->join('language as l4', 'process_name.language_id', '=', 'l4.id')
                ->select('process_type_name.name as process_type_name','process_name.name as process_name','transaction.id as transaction_id','t_state_name.name as t_state_name','transaction_type_name.t_name',DB::raw("'Executer' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',1)
                ->union($firstTransactions)
                ->get();

            return response()->json($secondTransactions);
        }
        else
        {
            return $this->getSpec($id);
        }
    }*/

    public function getAllInicExecTrans()
    {
        $returnData = array(
            'InicTrans' => $this->getAllInicTrans(),
            'ExecTrans' => $this->getAllExecTrans()
        );

        return response()->json($returnData);
    }

    public function getAllInicTrans()
    {
            $url_text = 'PT';

            $get_user = Users::find(2);

            $iniciatorTransactions = DB::table('transaction')
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
                ->join('users as userUpdatedBy', 'userUpdatedBy.id', '=', 'transaction.updated_by')
                ->select('process_type_name.name as process_type_name','process_name.name as process_name','transaction.id as transaction_id','transaction.updated_by',DB::raw('group_concat(t_state_name.name ORDER BY t_state_name.t_state_id ASC SEPARATOR \'->\') as t_state_name'),'transaction_type_name.t_name',DB::raw("'Iniciator' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',2);

                if ($get_user->user_type === "external" && $get_user->entity_id !== "null")
                {
                    $iniciatorTransactions = $iniciatorTransactions->where('userUpdatedBy.entity_id', '=', $get_user->entity_id);
                }
                $iniciatorTransactions =  $iniciatorTransactions->groupBy('transaction_id','process_type_name','process_name','t_name')
                    ->get();

                return $iniciatorTransactions;
    }

    public function getAllExecTrans()
    {
            $url_text = 'PT';

            $get_user = Users::find(2);

            $executerTransactions = DB::table('transaction')
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
                ->join('users as userUpdatedBy', 'userUpdatedBy.id', '=', 'transaction.updated_by')
                ->select('process_type_name.name as process_type_name','process_name.name as process_name','transaction.id as transaction_id','transaction.updated_by',DB::raw('group_concat(t_state_name.name ORDER BY t_state_name.t_state_id ASC SEPARATOR \'->\') as t_state_name'),'transaction_type_name.t_name',DB::raw("'Executer' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',2);

                if ($get_user->user_type === "external" && $get_user->entity_id !== "null")
                {
                    $executerTransactions = $executerTransactions->where('userUpdatedBy.entity_id', '=', $get_user->entity_id);
                }

                $executerTransactions =  $executerTransactions->groupBy('transaction_id','process_type_name','process_name','t_name')
                    ->get();

            return $executerTransactions;
    }

    public function index()
    {
        return view('dashboard');
    }

    public function insert(Request $request)
    {
        $tstate = new TState;
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
        }
    }

    public function update(Request $request, $id)
    {
        $url_text = 'PT';
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
        }
    }

    public function delete(Request $request, $id)
    {
        $url_text = 'PT';
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
        }
    }

    public function insertData(Request $request)
    {
        $url_text = "PT";

        //tentar tornar mais facil os foreachs
        $error=null;
        $collec = json_decode(json_encode($request->all()));
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

                foreach ($col->tab as $keyTab => $valueTab)
                {
                    $transactionState = new TransactionState;
                    $transactionState->transaction_id = $transaction->id;
                    $transactionState->t_state_id = $valueTab->type;
                    $transactionState->save();

                    if ($valueTab->relTypeExist == false && $valueTab->entTypeExist == true) //nao existe rel type e não existe ent type por exemplo verificar esta parte
                    {
                        //inserir nas entity... é preciso obter o ent_type_id
                        $ent_type = EntType::with(['language' => function ($query) use ($url_text) {
                            $query->where('slug', $url_text);
                        }])->whereHas('language', function ($query) use ($url_text) {
                            return $query->where('slug', $url_text);
                        })->where('transaction_type_id', $col->transaction_type_id)->where('t_state_id', $valueTab->type)->first();

                        $entity = new Entity;
                        $entity->ent_type_id = $ent_type->id;
                        $entity->state = "active";
                        $entity->transaction_state_id = $transactionState->id;
                        $entity->save();

                        $entityName = new EntityName;
                        $entityName->entity_id = $entity->id;
                        $entityName->language_id = 1; //buscar o language id
                        $entityName->name = $ent_type->language[0]->pivot->name . " " . $entity->id;
                        $entityName->save();
                    }
                    else if ($valueTab->relTypeExist == true && $valueTab->entTypeExist == false)
                    {
                        $rel_type = RelType::with(['language' => function ($query) use ($url_text) {
                            $query->where('slug', $url_text);
                        }])->whereHas('language', function ($query) use ($url_text) {
                            return $query->where('slug', $url_text);
                        })->where('transaction_type_id', $col->transaction_type_id)->where('t_state_id', $valueTab->type)->first();

                        $relation = new Relation;
                        $relation->rel_type_id = $rel_type->id;
                        $relation->entity1_id = $valueTab->entity1->selected->id;
                        $relation->entity2_id = $valueTab->entity2->selected->id;
                        $relation->state = "active";
                        $relation->transaction_state_id = $transactionState->id; //adicionar este campo na tabela relation
                        $relation->save();

                        $relationName = new RelationName;
                        $relationName->relation_id = $relation->id;
                        $relationName->language_id = 1; //buscar o language id através do eloquent
                        $relationName->name = $rel_type->language[0]->pivot->name . " " . $relation->id;
                        $relationName->save();
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

                        if (isset($valueTab->propsform_)) {
                            foreach ($valueTab->propsform_ as $keyField_ => $valueField_) {
                                if ($keyField_ == 0) {
                                    $entity = new Entity;
                                    $entity->ent_type_id = $valueField_->ent_type->id;
                                    $entity->state = "active";
                                    $entity->transaction_state_id = $transactionState->id;
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
        $url_text = 'PT';
        $tstates = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($tstates);
    }

    public function getTransTypeUserCanInit($id)
    {
        $user_id = 1;
        $url_text = 'PT';
        $transactions = TransactionType::with(['iniciatorActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }, 'language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('iniciatorActor.role.user', function ($query) use ($user_id){
            return $query->where('user_id', $user_id);
        })->where('process_type_id',$id)->get();

        return response()->json($transactions);
    }

    public function getTransTypeUserCanInit_()
    {
        $user_id = 1;
        $url_text = 'PT';
        $transactions = TransactionType::with(['iniciatorActor.role.user' => function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        }, 'language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('iniciatorActor.role.user', function ($query) use ($user_id){
            return $query->where('user_id', $user_id);
        })->get();

        return response()->json($transactions);
    }

    public function isUserInicAndExecOfTrans($id)
    {
        $user_id = 1;
        $url_text = 'PT';
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

    public function isTrAndStWaitingForAnotherTr(Request $request)
    {
        $t_state_id = $request->input('t_state_id');
        $trans_id = $request->input('transaction_type_id');
        $proc_id = $request->input('process_id');

        $waitinglinks = WaitingLink::where('waiting_transaction',$trans_id)->where('waiting_fact',$t_state_id)->get();

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
                                            if ($valueTState->entities->isEmpty()) {
                                                $valueProcess->transactions->forget($keyTransaction);
                                            }
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
                        if (($valueProcess->transactions->isEmpty()) || (($valueProcess->transactions->count() <= $waitinglink->max) && ($valueProcess->transactions->count() >= $waitinglink->min))) {
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

    private function array_push_assoc($array, $key, $value){
        $array[$key] = $value;
        return $array;
    }

    public function getTransTypeName($id)
    {
        $url_text = 'PT';

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

        $url_text="PT";

        $causallinks = CausalLink::with(['causedTransaction.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->where('causing_t', $trans_id)->whereIn('t_state_id', $arr_t_state_id)->orderBy('created_at','desc')->get();

        return response()->json($causallinks, $causallinks->isEmpty() ? 400 : 200);
    }

    public function getEntites1RelType($id)
    {
        $url_text = 'PT';

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
        $url_text = 'PT';

        $entitiesRel = Entity::with(['entType.relType1' => function ($query) use ($id) {
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
        $url_text = 'PT';

        $propsRel = Property::with(['relType' => function ($query) use ($transtype_id, $type) {
            $query->where('transaction_type_id', $transtype_id)->where('t_state_id', $type);
        }, 'relType.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'propAllowedValues.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'fkEntType.entity.language' => function ($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('relType', function ($query) use ($transtype_id, $type) {
            return $query->where('transaction_type_id', $transtype_id)->where('t_state_id', $type);
        })->orderBy('form_field_order', 'asc')->get();

        return $propsRel;
    }

    public function getProps($transtype_id, $type)
    {
        $url_text = 'PT';

        //verificar se com o transaction_type_id e o t_state_id existe um ent type ou rel type
        $existEntType = EntType::where('transaction_type_id', $transtype_id)->where('t_state_id', $type)->get();
        $existRelType = RelType::where('transaction_type_id', $transtype_id)->where('t_state_id', $type)->get();

        //inicializar as variaveis de estado a falso e as colecções a null
        $emptyEntTypeProp=true;
        $emptyRelTypeProp=true;
        $props = null;
        $propsRel = null;
        $rel_type_id=null;

        //se com o transaction type id e o t_state_id existem tipos de entidade entao procura propriedades associadas a esse ent type
        if ($existEntType->isNotEmpty())
        {
            //obter propriedades através do transaction type id e o t_state_id
            $props = Property::with(['entType' => function ($query) use ($transtype_id, $type) {
                $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id', NULL)->where('t_state_id', $type);
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
            },*/ 'propAllowedValues.entType', 'fkEntType.entity.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text)->orderBy('name', 'asc');
            }])->whereHas('entType', function ($query) use ($transtype_id, $type) {
                return $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id', NULL)->where('t_state_id', $type);
            })->orderBy('form_field_order', 'asc')->get();

            $props->map(function ($prop, $keyprop) use ($url_text)
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
            });

            /*$props->transform(function ($prop, $keyprop)
            {
                $url_text = "PT";
                $transactions = Transaction::with(['transactionType.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                },'transactionStates.tState.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                },'transactionStates.entities.entType.properties.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                },'transactionStates.entities.entType.properties.values', 'transactionStates.relations.relType.properties.values'])
                    ->where('process_id', 1)->get();
                //$transactions = Transaction::where('process_id', 1)->get();

                foreach ($prop->propertiesReading as $propRead) {
                    foreach ($transactions as $transactionKey => $transaction) {
                        foreach ($transaction->transactionStates as $keyTransState => $valueTransState) {
                            if ($valueTransState->entities->isNotEmpty()) {
                                foreach ($valueTransState->entities->first()->entType->properties as $keyProperty => $valueProperty) {
                                    if ($valueProperty->id != $propRead->id) {
                                        $valueTransState->entities->first()->entType->properties->forget($keyProperty);
                                    }

                                    foreach ($valueProperty->values as $keyVal => $valueVal) {
                                        if ($valueVal->entity_id != $valueTransState->entities->first()->id) {
                                            $valueProperty->values->forget($keyVal);
                                        }
                                    }

                                    if ($valueProperty->values->isEmpty()) {
                                        $valueTransState->entities->first()->entType->properties->forget($keyProperty);
                                    }
                                }

                                if ($valueTransState->entities->first()->entType->properties->isEmpty()) {
                                    $valueTransState->forget($keyTransState);
                                }
                            } else if ($valueTransState->relations->isNotEmpty()) {

                            }
                        }
                    }
                }

                $prop['PropertiesInfo'] = "";
                if ($prop->propertiesReading->isNotEmpty())
                {
                    $prop['PropertiesInfo'] = $transactions;
                }
            });*/

            /*$props->each(function ($prop, $keyprop)
            {
                $url_text = "PT";
                $prop->propertiesReading->each( function ($propRead) use ($url_text) {
                    $transactions = Transaction::with(['transactionType.language' => function ($query) use ($url_text) {
                        $query->where('slug', $url_text);
                    },'transactionStates.tState.language' => function ($query) use ($url_text) {
                        $query->where('slug', $url_text);
                    },'transactionStates.entities.entType.properties' => function ($query) use ($propRead) {
                        $query->whereIn('id', $propRead->id);
                    },'transactionStates.entities.entType.properties.language' => function ($query) use ($url_text) {
                        $query->where('slug', $url_text);
                    },'transactionStates.entities.entType.properties.values', 'transactionStates.relations.relType.properties.values'])
                        ->whereHas('transactionStates.entities.entType.properties', function ($query) use ($propRead) {
                            return $query->where('id', $propRead->id);
                        })
                        ->where('process_id', 1)->get();
                });*/

                //$transactions = Transaction::where('process_id', 1)->get();

                /*$prop->propertiesReading->each( function ($propRead) use ($transactions) {
                    $transactions->each(function($transaction, $transactionKey) use ($propRead) {
                        foreach ($transaction->transactionType->language as $keyTransTypeLang => $valueTransTypeLang)
                        {
                            if ($valueTransTypeLang->slug !== 'PT')
                            {
                                $transaction->transactionType->language->forget($keyTransTypeLang);
                            }
                        }
                        $transaction->transactionStates->each(function($valueTransState, $keyTransState) use ($propRead) {
                            foreach ($valueTransState->tState->language as $key => $value)
                            {
                               if ($value->slug !== 'PT')
                               {
                                   $valueTransState->tState->language->forget($key);
                               }
                            }

                            if ($valueTransState->entities->isNotEmpty()) {
                                $valueTransState->entities->first()->entType->properties->each(function($valueProperty, $keyProperty) use ($propRead, $valueTransState) {
                                    foreach ($valueProperty->language as $keyPropLang => $valuePropLang)
                                    {
                                        if ($valuePropLang->slug !== 'PT')
                                        {
                                            $valueProperty->language->forget($keyPropLang);
                                        }
                                    }

                                    if ($valueProperty->id != $propRead->id) {
                                        $valueTransState->entities->first()->entType->properties->forget($keyProperty);
                                    }

                                    $valueProperty->values->map(function($valueVal, $keyVal) use ($valueTransState, $valueProperty) {
                                        if ($valueVal->entity_id !== $valueTransState->entities->first()->id)
                                        {
                                            $valueProperty->values->forget($keyVal);
                                        }
                                    });

                                    if ($valueProperty->values->isEmpty()) {
                                        $valueTransState->entities->first()->entType->properties->forget($keyProperty);
                                    }
                                });
                            } else if ($valueTransState->relations->isNotEmpty()) {

                            }
                        });
                    });
                });*/

                /*$prop['PropertiesInfo'] = "";
                if ($prop->propertiesReading->isNotEmpty())
                {
                    $prop['PropertiesInfo'] = $transactions;
                }*/
            //});

            /*$props->transform(function ($prop, $keyprop)
            {
                $url_text = "PT";
                $transactions = Transaction::with(['transactionType.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                },'transactionStates.tState.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                },'transactionStates.entities.entType.properties.language' => function ($query) use ($url_text) {
                    $query->where('slug', $url_text);
                },'transactionStates.entities.entType.properties.values', 'transactionStates.relations.relType.properties.values'])
                    ->where('process_id', 1)->get();

                $prop->propertiesReading->transform( function ($propRead) use ($transactions) {
                    $transactions->transform(function($transaction, $transactionKey) use ($propRead) {
                        $transaction->transactionStates->transform(function($valueTransState, $keyTransState) use ($propRead) {
                            if ($valueTransState->entities->isNotEmpty()) {
                                $valueTransState->entities->first()->entType->properties->each(function($valueProperty, $keyProperty) use ($propRead, $valueTransState) {
                                    if ($valueProperty['id'] != $propRead['id']) {
                                        $valueTransState->entities->first()->entType->properties->forget($keyProperty);
                                    }

                                    $valueProperty->values->each(function($valueVal, $keyVal) use ($valueTransState,$valueProperty) {
                                        if ($valueVal->entity_id != $valueTransState->entities->first()->id) {
                                            $valueProperty->values->forget($keyVal);
                                        }
                                    });

                                    if ($valueProperty->values->isEmpty()) {
                                        $valueTransState->entities->first()->entType->properties->forget($keyProperty);
                                    }
                                });

                            } else if ($valueTransState->relations->isNotEmpty()) {

                            }
                        });
                    });
                });

                $prop['PropertiesInfo'] = "";
                if ($prop->propertiesReading->isNotEmpty())
                {
                    $prop['PropertiesInfo'] = $transactions;
                }
            });*/

            $emptyEntTypeProp = $props->isEmpty(); //se nao existirem propriedades nesse ent type a variável fica a true

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

            $data = array(
                'emptyEntTypeProp' => $emptyEntTypeProp,
                'emptyRelTypeProp' => $emptyRelTypeProp,
                'emptyEntType' => $existEntType->isEmpty(),
                'emptyRelType' => $existRelType->isEmpty(),
                'data' => $props,
                'rel_type_id' => $rel_type_id //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type
            );

            if ($emptyEntTypeProp)
            {
                return response()->json($data, 401);
            }
            else //caso contrário enviar o status de sucesso 200 e o array correspondente
            {
                return response()->json($data, 200);
            }
        }
        else if ($existRelType->isNotEmpty()) //se não existirem ent types mas existir rel type entao procura pelas propriedades desse rel type
        {
            $propsRel = $this->getPropsRel($transtype_id, $type); //obter as propriedades associadas a esse rel type

            $emptyRelTypeProp = $propsRel->isEmpty(); //se não existirem propriedades nesse rel type entao a variável fica a true

            //se nao existirem propriedades nesse rel type e não existirem rel types então o id do rel type é nulo
            if ($propsRel->isEmpty() && $existRelType->isEmpty())
            {
                $rel_type_id=null;
            }
            else if ($propsRel->isNotEmpty()) //se existirem propriedades nesse rel type então o id do rel type é o campo do primeiro objecto da colecção
            {
                $rel_type_id = $propsRel->first()->rel_type_id;
            }
            else if ($existRelType->isNotEmpty()) //se existirem rel types então o id do rel type é o campo do primeiro objecto da colecção
            {
                $rel_type_id = $existRelType->first()->id;
            }

            $data = array(
                'emptyEntTypeProp' => $emptyEntTypeProp,
                'emptyRelTypeProp' => $emptyRelTypeProp,
                'emptyEntType' => $existEntType->isEmpty(),
                'emptyRelType' => $existRelType->isEmpty(),
                'data' => $propsRel,
                'rel_type_id' => $rel_type_id //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type
            );

            if ($emptyRelTypeProp)
            {
                return response()->json($data, 401);
            }
            else //caso contrário enviar o status de sucesso 200 e o array correspondente
            {
                return response()->json($data, 200);
            }
        }
        else
        {
            $data = array(
                'emptyEntTypeProp' => $emptyEntTypeProp,
                'emptyRelTypeProp' => $emptyRelTypeProp,
                'emptyEntType' => $existEntType->isEmpty(),
                'emptyRelType' => $existRelType->isEmpty(),
                'data' => null,
                'rel_type_id' => $rel_type_id //para depois ser utilizada na busca das entidades para as selecboxes se for o caso de um rel type
            );

            return response()->json($data, 400);
        }
    }

    public function getPropsfromChild($id)
    {
        $url_text = 'PT';

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
            return$query->where('par_prop_type_val', $id);
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
        $url_text = 'PT';
        $user_id = 1;

        //verificar se o utilizador é externo ou interno
        $getUser = User::find($user_id);

        if ($getUser->user_type == "external") //se é externo é necessário
        {
            $getTransType = TransactionType::find($trans_id);

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
            })->whereHas('transactions.transactionType.iniciatorActor.role.user', function ($query) use ($user_id) {
                $query->where('user_id', $user_id);
            })->whereHas('processType.transactionsTypes', function ($query) use ($trans_id) {
                $query->where('id', $trans_id);
            })->where('proc_state', 'execution')->get(); //->where('flag','execution') adicionar depois de mudar a base de dados
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
        $url_text = 'PT';
        $trans = TransactionState::with(['tState.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            },'transaction.transactionType.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('tState.language')
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

    public function verifyIfCanDoNextTransactionState(Request $request,$id)
    {
        $States = Array(1=>'Request', 2=>'Promise', 3=>'Execute', 4=>'State', 5=>'Accept');

        $t_state_id = $request->input('t_state_id');
        $actorCan = $request->input('actorCan');

        $ents = TransactionState::whereHas('entities')->where('transaction_id', $id)->where('t_state_id', $t_state_id)->get();

        $canAdvance = false;
        $nextState=null;
        $lacksEntity = false;
        if ($actorCan == 'Executer')
        {
            if (($t_state_id == 1) || ($t_state_id == 2) || ($t_state_id == 3))
            {
                //return response()->json($this->get_next($States, $t_state_id));
                $nextState = $this->get_next($States, $t_state_id);
                $canAdvance = true;
            }
            else
            {
                $canAdvance = false;
            }
        }
        else if ($actorCan == 'Iniciator')
        {
            if ($t_state_id == 4)
            {
                $nextState = $this->get_next($States, $t_state_id);
                $canAdvance = true;
            }
            else
            {
                $canAdvance = false;
                if ($ents->isEmpty())
                {
                    $lacksEntity = true;
                }
                else
                {
                    $lacksEntity = false;
                }
            }
        }

        $data = array(
            'nextState' => $nextState,
            'canAdvance' => $canAdvance,
            'lacksEntity' => $lacksEntity
        );


        if ($canAdvance === true)
        {
            return response()->json($data, 200);
        }
        else if ($canAdvance === false && $lacksEntity === false)
        {
            return response()->json($data, 400);
        }
        else if ($canAdvance === false && $lacksEntity === true)
        {
            return response()->json($data, 401);
        }

        /*$url_text = 'PT';
        $trans = TransactionState::with(['tState.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        },'transaction.transactionType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('tState.language')
            ->where('transaction_id', $id)->get();

        $data = array(
            'data' => $trans->isEmpty() ? null : $trans,
            't_state_id' => $trans->isEmpty() ? null : $trans->last()->tState->id,
            't_state_name' => $trans->isEmpty() ? null : $trans->last()->tState->language[0]->pivot->name
        );

        return response()->json($data);*/
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
        $user_id = 3;
        $trans_state_id = $request->input('trans_state_id');

        $existsTransAck = $this->verifTransactionAckExists($trans_state_id, $user_id);
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

            return Response::json($returnData, 200);
        }
    }

    public function verifTransactionAckExists($trans_state_id, $user_id)
    {
        $transAck = TransactionAck::where('transaction_state_id', $trans_state_id)->where('user_id', $user_id)->get();

        return $transAck;
    }

    public function insertTransactionAck($trans_state_id, $user_id)
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
}
