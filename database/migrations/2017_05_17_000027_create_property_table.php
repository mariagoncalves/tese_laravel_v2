<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property', function (Blueprint $table) {
            $table->increments('id');
//            $table->string('name', 128)->default('');
            $table->integer('ent_type_id')->nullable()->unsigned();
            $table->integer('rel_type_id')->nullable()->unsigned();
            $table->integer('t_state_id')->unsigned();
            $table->enum('value_type', ['text', 'bool', 'int', 'double', 'enum', 'ent_ref', 'prop_ref', 'file'])->comment('text, int, double, boolean, enum');
//            $table->string('form_field_name', 64)->default('')->comment('ascii string to be used as the name of the form field');
            $table->enum('form_field_type', ['text','textbox','number','radio','checkbox','selectbox','file']);
            $table->integer('unit_type_id')->nullable()->unsigned();
            $table->integer('form_field_order')->comment('order in which form fields will be shown');
            $table->integer('mandatory')->comment('1 if property is mandatory for its parent, 0 if not');
            $table->enum('state', ['active','inactive']);
            $table->integer('fk_ent_type_id')->nullable()->unsigned();
            $table->integer('fk_property_id')->nullable()->unsigned();
            $table->string('form_field_size', 64)->nullable();
            $table->boolean('can_edit');
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
        Schema::drop('property');
    }
}