<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Property;
use App\PropUnitType;
use App\TState;
use Illuminate\Support\Facades\Log;

class PropertiesController extends Controller {

    //Common methods of relations and entities
    public function getStates() {
        $states = Property::getValoresEnum('state', 'property');
        return response()->json($states);
    }

    public function getValueTypes() {
        $valueTypes = Property::getValoresEnum('value_type', 'property');
        return response()->json($valueTypes);
    }

    public function getFieldTypes() {
        $fieldTypes = Property::getValoresEnum('form_field_type', 'property');
        return response()->json($fieldTypes);
    }

    public function getTransactionsStates() {

        $url_text = 'PT';

        $transactionStates = TState::with(['language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }])
                                ->whereHas('language', function ($query) use ($url_text){
                                    return $query->where('slug', $url_text);
                                })->get();

        return response()->json($transactionStates);
    }

    public function getUnits() {

        $url_text = 'PT';

        $units = PropUnitType::with(['language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }])
                                ->whereHas('language', function ($query) use ($url_text){
                                    return $query->where('slug', $url_text);
                                })->get();

        return response()->json($units);
    }

    public function getProperty($id) {
        $url_text = 'PT';

        $property = Property::with(['language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }])
                            ->with(['units.language' => function($query) use ($url_text) {
                                $query->where('slug', $url_text);
                            }])
                            ->with(['fkProperty' => function ($query) use ($url_text) {
                                $query->with(['language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }]);
                            }])
                            ->with(['readingEntTypes' => function ($query) use ($url_text) {
                               $query->with(['entType.language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }]);
                            }])
                            ->with(['propertiesReading' => function($query) use ($url_text) {
                                $query->with(['language' => function($query) use ($url_text) {
                                    $query->where('slug', $url_text);
                                }]);
                            }])
                            ->find($id);

        return response()->json($property);

    }
}
