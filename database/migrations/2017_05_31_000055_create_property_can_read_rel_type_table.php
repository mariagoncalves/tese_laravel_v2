<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePropertyCanReadRelTypeTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('property_can_read_rel_type', function (Blueprint $table) {
            $table->integer('reading_property')->unsigned();
            $table->integer('providing_rel_type')->unsigned();
            $table->enum('output_type', ['popover', 'accordion']);
            $table->integer('updated_by')->nullable()->unsigned();
            $table->integer('deleted_by')->nullable()->unsigned();
            $table->timestamps();
            $table->softDeletes();

            // $table->foreign('property_need')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            // $table->foreign('property_info')->references('id')->on('property')->onDelete('no action')->onUpdate('no action');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('property_can_read_rel_type');
    }
}