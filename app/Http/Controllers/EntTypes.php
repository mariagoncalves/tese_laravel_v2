<?php

namespace App\Http\Controllers;

use App\EntType;
use App\PropAllowedValue;
use App\TransactionType;
use App\TState;
use App\EntTypeName;
use App\ProcessType;
use Illuminate\Http\Request;
use DB;
use Response;
use Config;

class EntTypes extends Controller
{
    //
    private $url_text;
    private $user_id;

    public function __construct()
    {
        $this->url_text = Config::get('config_app.url_text');
        $this->user_id = Config::get('config_app.user_id');
    }

    public function getAll(Request $request,$id = null)
    {
        if ($id == null)
        {
            $url_text = $this->url_text;

            $ents = DB::table('ent_type')
                ->join('ent_type_name', 'ent_type.id', '=', 'ent_type_name.ent_type_id')
                ->join('transaction_type','transaction_type.id','=','ent_type.transaction_type_id')
                ->join('transaction_type_name','transaction_type.id','=','transaction_type_name.transaction_type_id')
                ->join('process_type','process_type.id','=','transaction_type.process_type_id')
                ->join('process_type_name','process_type.id','=','process_type_name.process_type_id')
                //->join('t_state_name','t_state.id','=','t_state_name.t_state_id')
                ->leftJoin('ent_type as et1','ent_type.par_ent_type_id','=','et1.id')
                //->join('ent_type_name as etn1','et1.id', '=', 'etn1.ent_type_id')
                ->leftJoin('prop_allowed_value','ent_type.par_prop_type_val','=','prop_allowed_value.id')
                //->join('prop_allowed_value_name','prop_allowed_value.id','=','prop_allowed_value_name.p_a_v_id')
                ->join('language as l1', 'ent_type_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'transaction_type_name.language_id', '=', 'l2.id')
                ->join('language as l3', 'process_type_name.language_id', '=', 'l3.id')
                //->join('language as l4', 'prop_allowed_value_name.language_id', '=', 'l4.id')
                //->join('language as l5', 'etn1.language_id', '=', 'l5.id')
                //->join('language as l6', 't_state_name.language_id', '=', 'l6.id')
                ->select('process_type_name.name as process_type_name', 'transaction_type_name.t_name as transaction_type_t_name',
                    'ent_type.id', 'ent_type_name.name as ent_type_name',
                    'et1.id as etn1_name', 'prop_allowed_value.id as p_a_v_name',
                    //'etn1.name as etn1_name', 'prop_allowed_value_name.name as p_a_v_name',
                    //'t_state_name.name as t_state_name',
                    'ent_type.state as ent_type_state', 'ent_type.created_at', 'ent_type.updated_at', 'ent_type.state')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                //->where('l4.slug','=',$url_text)->where('l5.slug','=',$url_text)
                //->where('l6.slug','=',$url_text)
                ->whereNull('ent_type.deleted_at')
                ->get();

            foreach ($ents as $keyProcess => $valueProcess)
            {
                if ($valueProcess->etn1_name != "")
                {
                    $valueProcess->etn1_name = DB::table('ent_type')
                        ->join('ent_type_name', 'ent_type.id', '=', 'ent_type_name.ent_type_id')
                        ->join('language as l1', 'ent_type_name.language_id', '=', 'l1.id')
                        ->select('ent_type_name.name as ent_type_name')
                        ->where('l1.slug','=',$url_text)
                        ->where('ent_type.id', '=', $valueProcess->etn1_name)
                        ->whereNull('ent_type.deleted_at')
                        ->first()->ent_type_name;
                }

                if ($valueProcess->p_a_v_name != "")
                {
                    $valueProcess->p_a_v_name = DB::table('prop_allowed_value')
                        ->join('prop_allowed_value_name','prop_allowed_value.id','=','prop_allowed_value_name.p_a_v_id')
                        ->join('language as l1', 'prop_allowed_value_name.language_id', '=', 'l1.id')
                        ->select('prop_allowed_value_name.name as p_a_v_name')
                        ->where('l1.slug','=',$url_text)
                        ->where('prop_allowed_value.id', '=', $valueProcess->p_a_v_name)
                        ->whereNull('prop_allowed_value.deleted_at')
                        ->first()->p_a_v_name;
                }
            }

            return response()->json($ents);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('entTypes');
    }

    public function insert(Request $request)
    {
        $entitytype = new EntType;
        $entitytypename = new EntTypeName;

        DB::beginTransaction();
        try {
            $entitytype->state = $request->input('state');
            $entitytype->transaction_type_id = $request->input('transaction_type_id');

            if ($request->input('par_ent_type_id') != "")
            {
                $entitytype->par_ent_type_id = $request->input('par_ent_type_id');
            }

            if ($request->input('par_prop_type_val') != "")
            {
                $entitytype->par_prop_type_val = $request->input('par_prop_type_val');
            }

            $entitytype->save();

            $entitytypename->name = $request->input('name');
            $entitytypename->language_id = $request->input('language_id');
            $entitytypename->ent_type_id = $entitytype->id;
            $entitytypename->save();

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
        $url_text = $this->url_text;
        $entitytype = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionsType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $entitytype->state = $request->input('state');
            $entitytype->transaction_type_id = $request->input('transaction_type_id');

            if ($request->input('par_ent_type_id') != "")
            {
                $entitytype->par_ent_type_id = $request->input('par_ent_type_id');
            }
            else
            {
                $entitytype->par_ent_type_id = null;
            }

            if ($request->input('par_prop_type_val') != "")
            {
                $entitytype->par_prop_type_val = $request->input('par_prop_type_val');
            }
            else
            {
                $entitytype->par_prop_type_val = null;
            }

            $entitytype->save();

            $attributes = array(
                'name' => $request->input('name')
            );
            $entitytype->language()->updateExistingPivot($entitytype->language()->first()->id, $attributes); //$id_lang corresponde do language_id
            //$entitytype->language()->sync([$id => [ 'name' => $request->input('name')] ], false);

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
        $url_text = $this->url_text;
        $entitytype = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionsType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $entitytype->language()->detach($id);
            $entitytype->delete();

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
        $url_text = $this->url_text;
        $ents = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'transactionsType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'entType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($ents);
    }

    public function getAllHttp()
    {
        $returnData = array(
            'tr' => $this->getAllTransactionTypes(),
            'ts' => $this->getAllTStates(),
            'et' => $this->getAllEntTypes(),
            'av' => $this->getAllPropAllowedValues(),
            'langs' => app('App\Http\Controllers\ProcessTypes')->getAllLanguage1()
        );

        return response()->json($returnData);
    }

    public function getAllTransactionTypes()
    {
        $url_text = $this->url_text;
        $transactiontypes = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('transaction_type_name.t_name','asc');
        })->get();

        return $transactiontypes;
    }

    public function getAllTStates()
    {
        $url_text = $this->url_text;
        $tstates = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('t_state_name.name','asc');
        })->get();

        return $tstates;
    }

    public function getAllEntTypes()
    {
        $url_text = $this->url_text;
        $enttypes = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('ent_type_name.name','asc');
        })->get();

        return $enttypes;
    }

    public function getAllPropAllowedValues()
    {
        $url_text = $this->url_text;
        $propallowedvalues = PropAllowedValue::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('prop_allowed_value_name.name','asc');
        })->get();

        return $propallowedvalues;
    }

    /*public function getAllTransactionTypes()
    {
        $url_text = 'PT';
        $transactiontypes = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('transaction_type_name.t_name','asc');
        })->get();

        return response()->json($transactiontypes);
    }

    public function getAllTStates()
    {
        $url_text = 'PT';
        $tstates = TState::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('t_state_name.name','asc');
        })->get();

        return response()->json($tstates);
    }

    public function getAllEntTypes()
    {
        $url_text = 'PT';
        $enttypes = EntType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('ent_type_name.name','asc');
        })->get();

        return response()->json($enttypes);
    }

    public function getAllPropAllowedValues()
    {
        $url_text = 'PT';
        $propallowedvalues = PropAllowedValue::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('prop_allowed_value_name.name','asc');
        })->get();

        return response()->json($propallowedvalues);
    }*/
}
