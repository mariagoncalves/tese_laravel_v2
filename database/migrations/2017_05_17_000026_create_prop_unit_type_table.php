<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropUnitTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prop_unit_type', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('name', 45)->comment('kg, cm, mmHg');
            $table->enum('state', ['active', 'inactive']);
//            $table->timestamp('updated_on');
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();
        });



    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {


        Schema::drop('prop_unit_type');
    }
}