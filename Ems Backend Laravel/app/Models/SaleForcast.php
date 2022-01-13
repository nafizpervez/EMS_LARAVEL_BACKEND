<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleForcast extends Model
{
    use HasFactory;

    protected $fillable = [
        'name_of_the_account',
        'account_manager_name',
        'project_name',
        'contact_person',
        'contact_person_mobile',
        'contact_person_email',
        'value_of_the_project',
        'po_date',
        'proposal_submission_date',
        'last_follow_up_date',
        'expected_closing_date',
        'probability_of_closing',
        'remarks',
    ];
}
