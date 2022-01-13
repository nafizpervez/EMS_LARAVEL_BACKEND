<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateExtendedUserDetailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('extended_user_details', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('user_id')->unique();
            $table->string('employment_term')->nullable();
            $table->string('bank_account_for_salary')->nullable();
            $table->string('bank_name')->nullable();
            $table->boolean('is_two_factor_auth')->nullable();
            $table->string('supervisor')->nullable();
            $table->string('insurance_category')->nullable();
            $table->integer('tin')->nullable();
            $table->integer('pf_code')->nullable();
            $table->integer('pf_contribution')->nullable();
            $table->date('date_of_birth')->nullable();
            $table->enum('marital_status', ['married', 'un-married', 'divorced'])->nullable();;
            $table->string('fathers_name')->nullable();
            $table->string('mothers_name')->nullable();
            $table->string('spouse_name')->nullable();
            $table->string('nationality')->nullable();
            $table->integer('nid')->unique()->nullable();
            $table->enum('gender', ['male', 'female', 'lgbtqa'])->nullable();;
            $table->string('religion')->nullable();
            $table->integer('number_of_child')->nullable();
            $table->string('passport_number')->unique()->nullable();
            $table->string('mailing_address')->nullable();
            $table->string('personal_email')->unique()->nullable();
            $table->string('personal_contact_number')->nullable();
            $table->string('emergency_contact_number')->nullable();            
            $table->string('permanent_address')->nullable();
            $table->string('official_intercom_extension')->nullable();
            $table->string('skype_id')->unique()->nullable();
            $table->string('facebook_id')->unique()->nullable();
            $table->string('twitter_id')->unique()->nullable();
            $table->string('linkedin_id')->unique()->nullable();
            $table->string('ssc_equivalent')->nullable();
            $table->string('hsc_equivalent')->nullable();
            $table->string('graduation')->nullable();
            $table->string('post_graduation')->nullable();
            $table->string('ssc_from_school')->nullable();
            $table->string('hsc_from_college')->nullable();
            $table->string('grad_university')->nullable();
            $table->string('post_grad_university')->nullable();
            $table->string('professional_certification')->nullable();
            $table->string('social_afiliation')->nullable();
            $table->string('professional_afiliation')->nullable();
            $table->string('habits')->nullable();
            $table->string('award_achievements')->nullable();
            $table->string('total_job_experience')->nullable();
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
        Schema::dropIfExists('extended_user_details');
    }
}
