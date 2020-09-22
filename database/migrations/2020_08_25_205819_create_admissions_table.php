<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAdmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->datetime('application_starts');
            $table->datetime('application_ends');
            $table->text('brief');
            $table->integer('admin_id');
            $table->boolean('automatic_admission');
            $table->boolean('e_exam_required');
            $table->integer('class_id');
            $table->integer('max_class_count');
            $table->boolean('application_fee_required');
            $table->integer('application_fee');
            
            $table->integer('cut_off');
            
            $table->boolean('strict');
            
            $table->boolean('admission_reg_status');
            $table->string('slug')->unique();
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
        Schema::dropIfExists('admissions');
    }
}
