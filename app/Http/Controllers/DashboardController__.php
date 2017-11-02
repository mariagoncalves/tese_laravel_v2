<?php

namespace App\Http\Controllers;

use App\Entity;
use App\Process;
use App\Property;
use App\Transaction;
use App\TransactionType;
use App\TransactionState;
use Illuminate\Http\Request;
use DB;
use Response;

class DashboardController_ extends Controller
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

    public function getAllInicTrans(Request $request,$id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

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
                ->join('process_name', 'process_name.process_id', '=', 'process.process_type_id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->join('language as l4', 'process_name.language_id', '=', 'l4.id')
                ->select('process_type_name.name as process_type_name','process_name.name as process_name','transaction.id as transaction_id','t_state_name.name as t_state_name','transaction_type_name.t_name',DB::raw("'Iniciator' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',1)->get();

                return response()->json($iniciatorTransactions);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function getAllExecTrans(Request $request,$id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

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
                ->join('process_name', 'process_name.process_id', '=', 'process.process_type_id')
                ->join('language as l1', 't_state_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                ->join('language as l4', 'process_name.language_id', '=', 'l4.id')
                ->select('process_type_name.name as process_type_name','process_name.name as process_name','transaction.id as transaction_id','t_state_name.name as t_state_name','transaction_type_name.t_name',DB::raw("'Executer' as Type"))
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('l4.slug','=',$url_text)
                ->where('users.id','=',1)
                ->get();

            return response()->json($executerTransactions);
        }
        else
        {
            return $this->getSpec($id);
        }
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
        $user_id = 3;
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

    public function isUserInicAndExecOfTrans($id)
    {
        $user_id = 3;
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
        })->get();

        return $propsRel;
    }

    public function getProps($transtype_id, $type)
    {
        $url_text = 'PT';

        $props = Property::with(['entType' => function ($query) use ($transtype_id, $type) {
                $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id',NULL)->where('t_state_id', $type);
            }, 'entType.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'propAllowedValues.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'fkEntType.entity.language' => function ($query) use ($url_text) {
                $query->where('slug', $url_text)->orderBy('name', 'asc');
            }])->whereHas('entType', function ($query) use ($transtype_id, $type) {
                return $query->where('transaction_type_id', $transtype_id)->where('par_ent_type_id',NULL)->where('t_state_id', $type);
        })->get();

        $propsRel = $this->getPropsRel($transtype_id, $type);

        $data = array(
            'emptyEntType' => $props->isEmpty(),
            'emptyRelType' => $propsRel->isEmpty(),
            'data' => $props->isEmpty() ? $propsRel : $props,
            'rel_type_id' => $propsRel->isEmpty() ? null : $propsRel->first()->rel_type_id
        );

        if ($props->isEmpty() && $propsRel->isEmpty())
        {
            return response()->json(null, 400);
        }
        else
        {
            return response()->json($data, 200);
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
        })->get();

        return response()->json($props);
    }

    public function getProcessesUserSelected($id)
    {
        $url_text = 'PT';
        $processes = Process::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->where('process_type_id',$id)->get();

        return $processes;
    }


    public function getStatesFromTransaction($id)
    {
        $url_text = 'PT';
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

        return response()->json($data);
    }

    public function verifyIfCanDoNextTransactionState(Request $request,$id)
    {
        $States = Array(1=>'Request', 2=>'Promise', 3=>'Execute', 4=>'State', 5=>'Accept');

        $t_state_id = $request->input('t_state_id');
        $actorCan = $request->input('actorCan');

        $canAdvance = false;
        $nextState=null;
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
            }
        }

        $data = array(
            'nextState' => $nextState,
            'canAdvance' => $canAdvance
        );


        return response()->json($data, 200);

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

    function get_next($array, $key) {
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
