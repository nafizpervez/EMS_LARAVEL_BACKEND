<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAllotedLeavesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alloted_leaves', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('alloted_for');
            $table->integer('total_alloted_leaves')->default(34);
            $table->integer('sick_leave')->default(0);
            $table->integer('annual_leave')->default(0);
            $table->integer('maternity_leave')->default(0);
            $table->integer('unpaid_leave')->default(0);
            $table->date('business_year_start');
            $table->date('business_year_end');
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
        Schema::dropIfExists('alloted_leaves');
    }
}
