<?php

namespace App\Http\Controllers;

use App\WaitingLink;
use Illuminate\Http\Request;
use DB;
use Response;
use Config;

class WaitingLinksController extends Controller
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
            /*$waitinglinks = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'waitingTransaction.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'waitingFact.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }, 'waitedFact.language' => function($query) use ($url_text) {
                $query->where('slug', $url_text);
            }])->whereHas('waitedT.language')->paginate(5);*/

            $waitinglinks = DB::table('waiting_link')
                ->join('transaction_type as tp1', 'tp1.id', '=', 'waiting_link.waited_t')
                ->join('transaction_type_name as tpname1', 'tp1.id', '=', 'tpname1.transaction_type_id')
                ->join('language as l1', 'tpname1.language_id', '=', 'l1.id')
                ->join('transaction_type as tp2', 'tp2.id', '=', 'waiting_link.waiting_t')
                ->join('transaction_type_name as tpname2', 'tp2.id', '=', 'tpname2.transaction_type_id')
                ->join('language as l2', 'tpname2.language_id', '=', 'l2.id')
                ->join('t_state as wf1', 'wf1.id', '=', 'waiting_link.waited_fact')
                ->join('t_state_name as wfname1', 'wf1.id', '=', 'wfname1.t_state_id')
                ->join('language as l3', 'wfname1.language_id', '=', 'l3.id')
                ->join('t_state as wf2', 'wf2.id', '=', 'waiting_link.waiting_fact')
                ->join('t_state_name as wfname2', 'wf2.id', '=', 'wfname2.t_state_id')
                ->join('language as l4', 'wfname2.language_id', '=', 'l4.id')
                ->select('waiting_link.*','tpname1.t_name as tp1_waited_t',
                    'tpname2.t_name as tp2_waiting_t','wfname1.name as wfname1_waited_fact', 'wfname2.name as wfname2_waiting_fact')
                ->where('l1.slug','=',$url_text)->where('l2.slug','=',$url_text)
                ->where('l3.slug','=',$url_text)->where('l4.slug','=',$url_text)
                ->where('waiting_link.deleted_at','=',null)
                ->get();

            return response()->json($waitinglinks);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('WaitingLinks');
    }

    public function insert(Request $request)
    {
        $waitinglink = new WaitingLink;

        DB::beginTransaction();
        try {
            $waitinglink->waited_t = $request->input('waited_t');
            $waitinglink->waited_fact = $request->input('waited_fact');
            $waitinglink->waiting_fact = $request->input('waiting_fact');
            $waitinglink->waiting_t = $request->input('waiting_t');
            $waitinglink->min = $request->input('min');
            $waitinglink->max = $request->input('max');
            $waitinglink->save();

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
        $waitinglink = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitedFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('waitedT.language')->find($id);

        DB::beginTransaction();
        try {
            $waitinglink->waited_t = $request->input('waited_t');
            $waitinglink->waited_fact = $request->input('waited_fact');
            $waitinglink->waiting_fact = $request->input('waiting_fact');
            $waitinglink->waiting_t = $request->input('waiting_t');
            $waitinglink->min = $request->input('min');
            $waitinglink->max = $request->input('max');
            $waitinglink->save();

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
        $waitinglink = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitedFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('waitedT.language')->find($id);

        DB::beginTransaction();
        try {
            $waitinglink->delete();

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
        $waitinglinks = WaitingLink::with(['waitedT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingT.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitingFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }, 'waitedFact.language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('waitedT.language')->find($id);

        return response()->json($waitinglinks);
    }
}
