<?php namespace App\Http\Controllers;

use App\EntType;
use App\Property;
use App\PropAllowedValueName;
use App\PropAllowedValue;
use Response;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;

use Illuminate\Http\Request;

class PropAllowedValueController extends Controller {

	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function index()
	{
        return view('propAllowedValue');
	}

    public function getAll($id = null)
    {
        if ($id == null)
        {
            $url_text = 'PT';

            $prop_allowed_values = DB::table('ent_type')
                ->join('ent_type_name', 'ent_type.id', '=', 'ent_type_name.ent_type_id')
                ->join('property','property.ent_type_id','=','ent_type.id')
                ->where('property.value_type', "enum")
                ->join('property_name','property.id','=','property_name.property_id')
                ->Leftjoin('prop_allowed_value','prop_allowed_value.property_id','=','property.id')
                ->join('language as l1', 'ent_type_name.language_id', '=', 'l1.id')
                ->join('language as l2', 'property_name.language_id', '=', 'l2.id')
                ->select('ent_type.id as ent_id',
                    'ent_type_name.name as ent_name',
                    'property.id as prop_id',
                    'property_name.name as prop_name',
                    'prop_allowed_value.id as prop_all_value_id',
                    'prop_allowed_value.id as prop_all_value_name')
                ->where('l1.slug','=',$url_text)
                ->where('l2.slug','=',$url_text)
                ->get();

            foreach ($prop_allowed_values as $keyProcess => $valueProcess)
            {
                if ($valueProcess->prop_all_value_name != "")
                {
                    $valueProcess->prop_all_value_name = DB::table('prop_allowed_value')
                        ->join('prop_allowed_value_name','prop_allowed_value.id','=','prop_allowed_value_name.p_a_v_id')
                        ->join('language as l1', 'prop_allowed_value_name.language_id', '=', 'l1.id')
                        ->select('prop_allowed_value_name.name as prop_all_value_name')
                        ->where('l1.slug','=',$url_text)
                        ->where('prop_allowed_value.id', '=', $valueProcess->prop_all_value_name)
                        ->whereNull('prop_allowed_value.deleted_at')
                        ->first()->prop_all_value_name;
                }
            }

            return response()->json($prop_allowed_values);
        }
        else
        {
            return $this->getSpec($id);
        }
    }

    public function getSpec($id)
    {
        $url_text = 'PT';

        $prop_allowed_value = PropAllowedValue::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->find($id);


        return response()->json($prop_allowed_value);
    }

    public function insert(Request $request)
    {
        $createById = 1;
        $prop_allowed_value = new PropAllowedValue;
        $prop_allowed_value_name = new PropAllowedValueName;

        DB::beginTransaction();

        try {
            $prop_allowed_value->state = $request->input('state');
            $prop_allowed_value->property_id = $request->input('property_id');
            $prop_allowed_value->updated_by = $createById;
            $prop_allowed_value->save();

            $prop_allowed_value_name->name = $request->input('name');
            $prop_allowed_value_name->p_a_v_id = $prop_allowed_value->id;
            $prop_allowed_value_name->updated_by = $createById;
            $prop_allowed_value_name->language_id = 1;
            $prop_allowed_value_name->save();
            DB::commit();
            // all good
            $success = true;
        } catch (\Exception $e) {
            DB::rollback();
            $success = false;
            // something went wrong
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

    public function getProp()
    {
        $url_text = 'PT';

        $property = Property::with(['language' => function($query) use ($url_text) {
            $query->where('slug', $url_text);
        }])->whereHas('language', function ($query) use ($url_text){
            return $query->where('slug', $url_text);
        })->where('value_type', "enum")->get();

        return response()->json($property);
    }

    public function update(Request $request, $id)
    {
        $query = ['p_a_v_id' => $id, 'language_id' => 1];
        $prop_allowed_value_name = PropAllowedValueName::where($query);
        $prop_allowed_value = PropAllowedValue::find($id);

        $prop_allowed_value_name->update([
            'name' => $request->input('name')
        ]);
        $prop_allowed_value->update([
            'state' => $request->input('state')
        ]);
    }
}
