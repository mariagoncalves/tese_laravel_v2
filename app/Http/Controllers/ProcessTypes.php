<?php

namespace App\Http\Controllers;

use App\Http\Requests\ValProcType;
use App\ProcessType;
use App\ProcessTypeName;
use App\Language;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Response;
use DB;
use File;
use Config;

class ProcessTypes extends Controller
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
            $procs = DB::table('process_type')
                ->join('process_type_name', 'process_type.id', '=', 'process_type_name.process_type_id')
                ->join('language as l1', 'process_type_name.language_id', '=', 'l1.id')
                ->select('process_type.*','process_type_name.*')
                ->where('l1.slug','=',$url_text)
                ->get();

            return response()->json($procs);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function index()
    {
        return view('processTypes');
    }

    public function insert(ValProcType $request)
    {
        $processtype = new ProcessType;
        $processtypename = new ProcessTypeName;

        DB::beginTransaction();
        try {
            $processtype->state = $request->input('state');

            $processtypename->name = $request->input('name');
            $processtypename->language_id = $request->input('language_id');

            $processtype->save();

            $processtypename->process_type_id = $processtype->id;
            $processtypename->save();

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
        $processtype = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        DB::beginTransaction();
        try {
            $processtype->state = $request->input('state');
            $processtype->save();

            $attributes = array(
                'name' => $request->input('name')
            );
            $processtype->language()->updateExistingPivot($processtype->language()->first()->id, $attributes);

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
        $processtype = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        DB::beginTransaction();
        try {
            $processtype->language()->detach();

            //$processtype->language()->updateExistingPivot($id,  ['deleted_at' => DB::raw('NOW()')]);

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
        $procs = ProcessType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->find($id);

        return response()->json($procs);
    }

    public function getAllLanguage1()
    {
        $langs = Language::orderBy('name','asc')->get();
        return $langs;
    }

    public function getAllLanguage()
    {
        $langs = Language::orderBy('name','asc')->get();
        return response()->json($langs);
    }
}
