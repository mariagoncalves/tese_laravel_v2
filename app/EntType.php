<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EntType extends Model
{
    use SoftDeletes;

    protected $table = 'ent_type';

    public $timestamps = true;

    protected $fillable = [
        'state',
        'transaction_type_id',
        'par_ent_type_id',
        'par_prop_type_val',
		't_state_id',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function transactionsType() {
        return $this->belongsTo('App\TransactionType', 'transaction_type_id', 'id');
    }

    public function tStates() {
        return $this->belongsTo('App\TState', 't_state_id', 'id');
    }

    public function entity() {
        return $this->hasMany('App\Entity', 'ent_type_id', 'id');
    }

    public function relType1() {
        return $this->hasMany('App\RelType', 'ent_type1_id', 'id');
    }

    public function relType2() {
        return $this->hasMany('App\RelType', 'ent_type2_id', 'id');
    }

    public function entType() {
        return $this->belongsTo('App\EntType', 'par_ent_type_id', 'id');
    }
    public function propAllowedValue() {
        return $this->belongsTo('App\prop_allowed_value', 'par_prop_type_val', 'id');
    }

    public function fkEntType() {
        return $this->hasMany('App\Property', 'fk_ent_type_id', 'id');
    }

    public function properties() {
        return $this->hasMany('App\Property', 'ent_type_id', 'id');
    }

    public function entTypeName() {
        return $this->hasMany('App\EntTypeName', 'ent_type_id', 'id');
    }
	
	/*public function customForm() {
        return $this->belongsToMany('App\CustomForm', 'custom_form_has_ent_type', 'ent_type_id', 'custom_form_id')->withPivot('field_order','mandatory_form','created_at','updated_at','deleted_at');
    }*/

    public function providingEntTypes() {
        return $this->belongsToMany('App\Property', 'property_can_read_ent_type', 'providing_ent_type', 'reading_property')->withPivot('output_type','created_at','updated_at','deleted_at');
    }

    public function language() {
        return $this->belongsToMany('App\Language', 'ent_type_name', 'ent_type_id', 'language_id')->withPivot('name','created_at','updated_at','deleted_at');
    }

    public function queries() {
        return $this->hasMany('App\Query', 'ent_type_id', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }

}
