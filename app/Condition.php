<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Condition extends Model
{
    use SoftDeletes;

    protected $table = 'condition';

    public $timestamps = true;

    protected $fillable = [
        'query_id',
        'operator_id',
		'property_id',
		'value_id',
		'value',
        'prop_allowed_value_id',
        'table_type',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function operator() {

        return $this->belongsTo('App\Operator','operator_id', 'id');
    }

    public function queries() {

        return $this->belongsTo('App\Query','query_id', 'id');
    }

    public function property() {

        return $this->belongsTo('App\Property','property_id', 'id');
    }

    public function value() {

        return $this->belongsTo('App\Value','value_id', 'id');
    }

    public function propAllowedValue() {

        return $this->belongsTo('App\PropAllowedValue','prop_allowed_value_id', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }

    public function scopeSearchOperatorTypes($query, $id, $data) {
        if ($id != null) {
            $query->where('id', $id);
        }

        if (isset($data['operator_type']) && $data['operator_type'] != '') {
            $query->where('operator_type', 'LIKE', '%'.$data['operator_type'].'%');
        }
    }
}
