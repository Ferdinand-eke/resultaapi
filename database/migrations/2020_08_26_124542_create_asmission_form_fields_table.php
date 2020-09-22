<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAsmissionFormFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('asmission_form_fields', function (Blueprint $table) {
            $table->id();
            
            $table->unsignedBigInteger('admission_id')->unsigned();

            $table->foreign('admission_id')->references('id')->on('admissions');
            $table->string('label');
            $table->string('type');
            $table->string('option');
            $table->string('key_name');
            $table->string('slug');
            $table->timestamps();

        
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('asmission_form_fields');
    }
}
