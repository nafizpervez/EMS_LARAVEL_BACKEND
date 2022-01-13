<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateConveyancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('conveyances', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('applicant_id');        
            $table->enum('conveyance_type', ['transportation', 'overtime', 'holiday']);
            $table->dateTime('in_time');
            $table->dateTime('out_time');
            $table->String('from')->nullable();
            $table->String('to')->nullable();
            $table->integer('payable_amount');
            $table->string('details')->nullable();
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
        Schema::dropIfExists('conveyances');
    }
}
