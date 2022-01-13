<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSaleForcastsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sale_forcasts', function (Blueprint $table) {
            $table->id();
            $table->string('name_of_the_account')->nullable();
            $table->string('account_manager_name')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('project_name')->nullable();
            $table->string('contact_person_mobile')->nullable();
            $table->string('contact_person_email')->nullable();
            $table->bigInteger('value_of_the_project')->nullable();
            $table->date('po_date')->nullable();
            $table->date('proposal_submission_date')->nullable();
            $table->date('last_follow_up_date')->nullable();
            $table->date('expected_closing_date')->nullable();
            $table->integer('probability_of_closing')->nullable();
            $table->string('activity_update')->nullable();
            $table->string('remarks')->nullable();
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
        Schema::dropIfExists('sale_forcasts');
    }
}
