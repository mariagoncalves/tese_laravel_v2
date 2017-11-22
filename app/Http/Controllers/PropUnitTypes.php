<?php namespace App\Http\Controllers;

use App\Language;
use App\PropUnitType;
use App\PropUnitTypeName;
use Illuminate\Http\Request;
use Response;
use DB;
use App\Http\Requests;
use App\Http\Controllers\Controller;


class PropUnitTypes extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        //Definir o Utilizador
        session()->put('user_id',1);
        return view('propUnitType');
    }

    /**
     * Buscar todos os prop_unit_type
     *
     * @return Response
     */
    public function getAll($id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

            $prop_unit_types = DB::table('prop_unit_type')
                ->join('prop_unit_type_name', 'prop_unit_type.id', '=', 'prop_unit_type_name.prop_unit_type_id')
                ->join('language as l1', 'prop_unit_type_name.language_id', '=', 'l1.id')
                ->select('prop_unit_type.*','prop_unit_type_name.*')
                ->whereNull('prop_unit_type.deleted_at')
                ->where('l1.slug','=',$url_text)
                ->get();

            return response()->json($prop_unit_types);
        }
        else
        {
            return $this->getSpec($id);
        }
    }


    public function getSpec($id)
    {
        $url_text = 'PT';

        $prop_unit_types = PropUnitType::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);

        return response()->json($prop_unit_types);
    }

    /**
     * Inserir uma nova os unidade
     *
     * @return Response
     */
    public function insert(Request $request)
    {
		//$createById = 1;
        $prop_unit_type = new PropUnitType;
        $prop_unit_type_name = new PropUnitTypeName;

        DB::beginTransaction();

        try {
            $prop_unit_type->state = $request->input('state');
			$prop_unit_type->updated_by = session()->get('user_id');
            $prop_unit_type->save();

            $prop_unit_type_name->name = $request->input('name');
            $prop_unit_type_name->prop_unit_type_id = $prop_unit_type->id;
            $prop_unit_type_name->language_id = 1;
			$prop_unit_type_name->updated_by = session()->get('user_id');
            $prop_unit_type_name->save();

            DB::commit();
            // all good
            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            //return Response::json($e->getMessage(),200);
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

    public function update(Request $request, $id)
    {
		 try {
             $user_id = session()->get('user_id');

            $query = ['prop_unit_type_id' => $id, 'language_id' => 1];
			$prop_unit_type_name = PropUnitTypeName::where($query);
			$prop_unit_type = PropUnitType::find($id);

			$prop_unit_type_name->update([
				'name' => $request->input('name'),
                'updated_by' => $user_id
			]);

			$prop_unit_type->update([
				'state' => $request->input('state'),
                'updated_by' => $user_id
			]);

            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong

        }
    }

    public function remove(Request $request)
    {
        try {
            $user_id = session()->get('user_id');

            $prop_unit = PropUnitType::find($request->input('id'));
            $prop_unit->update(['updated_by' => $user_id, 'deleted_by' => $user_id]);
            $prop_unit->delete();

            //Apagar os Nomes do $prop_unit
            DB::commit();
            // all good
        } catch (\Exception $e) {
            DB::rollback();
            // something went wrong
            return Response::json($e->getMessage(),400);
        }

        return Response::json(session()->all(),200);
    }
}
