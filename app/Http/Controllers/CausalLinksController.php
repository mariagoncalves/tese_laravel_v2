<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CausalLink;
use DB;
use Response;
use Config;

class CausalLinksController extends Controller
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

            $causallinks = DB::table('causal_link')
                ->join('transaction_type as tp1', 'tp1.id', '=', 'causal_link.causing_t')
                ->join('transaction_type_name as tpname1', 'tp1.id', '=', 'tpname1.transaction_type_id')
                ->join('transaction_type as tp2', 'tp2.id', '=', 'causal_link.caused_t')
                ->join('transaction_type_name as tpname2', 'tp2.id', '=', 'tpname2.transaction_type_id')
                ->join('t_state', 't_state.id', '=', 'causal_link.t_state_id')
                ->join('t_state_name', 't_state.id', '=', 't_state_name.t_state_id')
                ->join('language as l1', 'tpname1.language_id', '=', 'l1.id')
                ->join('language as l2', 'tpname2.language_id', '=', 'l2.id')
                ->join('language as l3', 't_state_name.language_id', '=', 'l3.id')
                ->select('causal_link.*','tpname1.t_name as tp1_causing_t',
                    'tpname2.t_name as tp2_caused_t','t_state_name.name as t_state_name')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)->where('l3.slug','=',$url_text)
                ->where('causal_link.deleted_at','=',null)
                ->get();

            return response()->json($causallinks);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('CausalLinks');
    }

    public function insert(Request $request)
    {
        $causallink = new CausalLink;

        DB::beginTransaction();
        try {
            $causallink->causing_t = $request->input('causing_t');
            $causallink->t_state_id = $request->input('t_state_id');
            $causallink->caused_t = $request->input('caused_t');
            $causallink->min = $request->input('min');
            $causallink->max = $request->input('max');
            $causallink->save();

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
        $causallink = CausalLink::with(['causingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'causedTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tState.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('causingTransaction')->find($id);

        DB::beginTransaction();
        try {
            $causallink->causing_t = $request->input('causing_t');
            $causallink->t_state_id = $request->input('t_state_id');
            $causallink->caused_t = $request->input('caused_t');
            $causallink->min = $request->input('min');
            $causallink->max = $request->input('max');
            $causallink->save();

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
        $causallinks = CausalLink::with(['causingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'causedTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tState.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('causingTransaction')->find($id);

        DB::beginTransaction();
        try {
            $causallinks->delete();

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
        $causallinks = CausalLink::with(['causingTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'causedTransaction.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'tState.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('causingTransaction')->find($id);

        return response()->json($causallinks);
    }
}
