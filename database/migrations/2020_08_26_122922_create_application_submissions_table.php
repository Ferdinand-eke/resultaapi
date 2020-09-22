<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateApplicationSubmissionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('application_submissions', function (Blueprint $table) {
            $table->id();
           
            $table->unsignedBigInteger('admission_id');

            $table->foreign('admission_id')->references('id')->on('admissions');

            $table->string('cand_fname')->nullable();
            $table->string('cand_lname')->nullable();
            $table->string('cand_age')->nullable();
            $table->string('guardian')->nullable();
            $table->string('guardian_rel')->nullable();
            $table->string('class')->nullable();
            $table->string('photo')->nullable();
            $table->string('payment_status')->nullable();
            $table->integer('can_examscore')->nullable();
            $table->string('reg_status')->nullable();
            $table->string('slug')->unique()->nullable();
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
        Schema::dropIfExists('application_submissions');
    }
}
