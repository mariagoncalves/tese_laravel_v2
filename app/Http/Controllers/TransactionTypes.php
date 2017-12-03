<?php

namespace App\Http\Controllers;

use App\TransactionTypeName;
use Illuminate\Http\Request;
use App\TransactionType;
use App\ProcessType;
use App\Actor;
use DB;
use Response;
use Illuminate\Pagination\LengthAwarePaginator;
use Config;

class TransactionTypes extends Controller
{
    //
    private $url_text;
    private $user_id;

    public function __construct()
    {
        $this->url_text = Config::get('config_app.url_text');
        $this->user_id = Config::get('config_app.user_id');
    }

    public function getAll($id = null)
    {
        if ($id == null)
        {
            $url_text = $this->url_text;
            $transacs = DB::table('transaction_type')
                ->join('process_type', 'transaction_type.process_type_id', '=', 'process_type.id')
                ->join('transaction_type_name', 'transaction_type.id', '=', 'transaction_type_name.transaction_type_id')
                ->join('language as l1', 'transaction_type_name.language_id', '=', 'l1.id')
                ->join('process_type_name', 'process_type_name.process_type_id', '=', 'process_type.id')
                ->join('language as l2', 'process_type_name.language_id', '=', 'l2.id')
                ->join('actor', 'actor.id', '=', 'transaction_type.executer')
                ->join('actor_name', 'actor_name.actor_id', '=', 'actor.id')
                ->join('language as l3', 'actor_name.language_id', '=', 'l3.id')
                ->select('transaction_type_name.*','process_type_name.*','transaction_type.*', 'actor_name.name as actor_name_executer')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->whereNull('transaction_type.deleted_at')
                ->orderBy('transaction_type.process_type_id','desc')->orderBy('transaction_type_name.rt_name','asc')
                ->get();

            return response()->json($transacs);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('transactionTypes');
    }

    public function insert(Request $request)
    {
        $transactiontype = new TransactionType;
        $transactiontypename = new TransactionTypeName;

        DB::beginTransaction();
        try {
            $transactiontype->state = $request->input('state');
            $transactiontype->init_proc = $request->input('init_proc');
            $transactiontype->process_type_id = $request->input('process_type_id');
            $transactiontype->executer = $request->input('executer');
            $transactiontype->auto_activate = $request->input('auto_activate');
            if ($transactiontype->auto_activate === 1)
            {
                if ($transactiontype->freq_activate != "")
                {
                    $transactiontype->freq_activate = $request->input('freq_activate');
                }

                if ($transactiontype->when_activate != "")
                {
                    $transactiontype->when_activate = $request->input('when_activate');
                }
            }
            $transactiontype->save();

            $transactiontypename->t_name = $request->input('t_name');
            $transactiontypename->rt_name = $request->input('rt_name');
            $transactiontypename->language_id = $request->input('language_id');
            $transactiontypename->transaction_type_id = $transactiontype->id;
            $transactiontypename->save();

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
        $transactiontype = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'executerActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $transactiontype->state = $request->input('state');
            $transactiontype->init_proc = $request->input('init_proc');
            $transactiontype->process_type_id = $request->input('process_type_id');
            $transactiontype->executer = $request->input('executer');
            $transactiontype->auto_activate = $request->input('auto_activate');
            if ($transactiontype->auto_activate === 1)
            {
                if ($transactiontype->freq_activate != "")
                {
                    $transactiontype->freq_activate = $request->input('freq_activate');
                }
                else
                {
                    $transactiontype->freq_activate = null;
                }

                if ($transactiontype->when_activate != "")
                {
                    $transactiontype->when_activate = $request->input('when_activate');
                }
                else
                {
                    $transactiontype->when_activate = null;
                }
            }
            else
            {
                $transactiontype->freq_activate = null;
                $transactiontype->when_activate = null;
            }
            $transactiontype->save();

            $attributes = array(
                't_name' => $request->input('t_name'),
                'rt_name' => $request->input('rt_name')
            );
            $transactiontype->language()->updateExistingPivot($transactiontype->language()->first()->id, $attributes);

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
        $transactiontype = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'executerActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        DB::beginTransaction();
        try {
            $transactiontype->language()->detach($id);
            $transactiontype->delete();

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
        //return ProcessType::find($id);
        //$procs = ProcessType::with('language')->find($id);
        $url_text = $this->url_text;
        $transacs = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'executerActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'iniciatorActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($transacs);
    }

    public function getAllExecuters()
    {
        $url_text = $this->url_text;
        $executers = Actor::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text)->orderBy('actor_name.name','asc');
        })->get();

        return response()->json($executers);
    }
	
	public function getActorsIniciatesT($id)
    {
        //Buscar todos os actores
        $langid = 1;
        $cActors = collect();
        $Actors = Actor::all();
        foreach ($Actors as $Actor) {
            if ($Actor->language) {
                if ($Actor->language->where('language_id', $langid)->first() != null) {
                    $Actor->name = $Actor->language-->where('language_id', $langid)->first()->pivot->name;
                } else {
                    $Actor->name = $Actor->language->first()->pivot->name;
                }
            }
            if (!$Actor->name) {
                $Actor->name = "Undefined";
            }

            $sActor =  array(
                "id" => $Actor->id,
                "name" => $Actor->name,
            );

            $cActors->push($sActor);
        }

        //Buscar os Actores já selecionados
        $cselActors = collect();
        $selActors = Actor::has('iniciaTransactionType')->get();

        foreach ($selActors as $Actor) {
            if ($Actor->iniciaTransactionType->where('id', $id)->first() != null) {
                if ($Actor->language) {
                    if ($Actor->language->where('language_id', $langid)->first() != null) {
                        $Actor->name = $Actor->language->where('language_id', $langid)->first()->pivot->name;
                    } else {
                        $Actor->name = $Actor->language->first()->pivot->name;
                    }
                }

                if (!$Actor->name) {
                    $Actor->name = "Undefined";
                }

                $sselActor = array(
                    "id" => $Actor->id,
                    "name" => $Actor->name,
                );

                $cselActors->push($sselActor);
            }
        }

        //Buscar o tipo de transação
        $url_text = 'PT';
        $trans = TransactionType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'processType.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'executerActor.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);


        //Construir o array dos dados a enviar
        $data = array(
            'actors' => $cActors,
            'sel_actors' => $cselActors,
            'transaction_type' => $trans,
        );

        return response()->json($data);
    }

    public function updateActorsIniciatesT(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            //Apagar todos os registos na tabela actor_iniciates_t, de acordo o resquest ID do tipo de transação
            $transactio_type = TransactionType::find($id);
            $transactio_type->iniciatorActor()->detach();

            //Inserir os novos registos
            //Verificar se o request é null
            if($request->input('selectedActors')){
                foreach($request->input('selectedActors') as $selActor){
                    $transactio_type->iniciatorActor()->attach($selActor['id']);
                }
            }

            DB::commit();
        } catch (\Exception $e) {
            $success = false;
            DB::rollback();
        }
    }

    public function removeActorIniciatesT(Request $request)
    {
        $transaction_type_id = $request->input('transaction_type_id');
        $actor_id = $request->input('actor_id');

        //Apagar o registo
        $transactio_type = TransactionType::find($transaction_type_id);
        $transactio_type->iniciatorActor()->detach($actor_id);
    }
}
