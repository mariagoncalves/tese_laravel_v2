<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class WaitingLink extends Model
{
    use SoftDeletes;

    protected $table = 'waiting_link';

    public $timestamps = true;

    protected $fillable = [
        'waited_t',
        'waited_fact',
        'waiting_fact',
        'waiting_t',
        'min',
        'max',
		'updated_by',
        'deleted_by'
    ];

    protected $guarded = [];

    public function waitingTransaction() {
        return $this->belongsTo('App\TransactionType', 'waiting_t', 'id');
    }

    public function waitedT() {
        return $this->belongsTo('App\TransactionType', 'waited_t', 'id');
    }

    public function waitingFact() {
        return $this->belongsTo('App\TState', 'waiting_fact', 'id');
    }

    public function waitedFact() {
        return $this->belongsTo('App\TState', 'waited_fact', 'id');
    }

    public function updatedBy() {

        return $this->belongsTo('App\Users', 'updated_by', 'id');
    }

    public function deletedBy() {

        return $this->belongsTo('App\Users', 'deleted_by', 'id');
    }
    
}
