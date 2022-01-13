<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SaleForcast;

class SaleForcastSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
      SaleForcast::create([
        "name_of_the_account" => "CAR HUB BD",
        "account_manager_name" => "Ashaduzzaman Mehedi",
        "contact_person" => "Khairuddin Ahmed Bappi",
        "project_name" => "Denting Fix",
        "contact_person_mobile" => "01708814676",
        "contact_person_email" => "khairuddin.ahmed@carhub.com",
        "value_of_the_project" => 12000,
        "po_date" => "2021-05-07",
        "proposal_submission_date" => null,
        "last_follow_up_date" => "2021-10-13",
        "expected_closing_date" => "2021-10-12",
        "probability_of_closing" => 100.0,
        "activity_update" => null,
        "remarks" => "Stock ready and Ready to roll",
      ]);
      SaleForcast::create([
        "name_of_the_account" => "CAR HUB BD",
        "account_manager_name" => "Ashaduzzaman Mehedi",
        "contact_person" => "Khairuddin Ahmed Bappi",
        "project_name" => "Denting Fix",
        "contact_person_mobile" => "01708814676",
        "contact_person_email" => "khairuddin.ahmed@carhub.com",
        "value_of_the_project" => 12000,
        "po_date" => "2021-05-07",
        "proposal_submission_date" => null,
        "last_follow_up_date" => "2021-10-13",
        "expected_closing_date" => "2021-10-12",
        "probability_of_closing" => 100.0,
        "activity_update" => null,
        "remarks" => "Stock ready and Ready to roll",
      ]);
      SaleForcast::create([
        "name_of_the_account" => "Jantrik. ",
        "account_manager_name" => "Rafsan Parvez Rono",
        "contact_person" => "Md. Noman Mahmud",
        "project_name" => "Fault Code Fix",
        "contact_person_mobile" => "01733333377",
        "contact_person_email" => "shariar4243@jantrik.com",
        "value_of_the_project" => 9000,
        "po_date" => null,
        "proposal_submission_date" => null,
        "last_follow_up_date" => null,
        "expected_closing_date" => null,
        "probability_of_closing" => null,
        "activity_update" => null,
        "remarks" => null,
      ]);
      SaleForcast::create([
        "name_of_the_account" => "Jantrik. ",
        "account_manager_name" => "Rafsan Parvez Rono",
        "contact_person" => "Md. Noman Mahmud",
        "project_name" => "Fault Code Fix",
        "contact_person_mobile" => "01733333377",
        "contact_person_email" => "shariar4243@jantrik.com",
        "value_of_the_project" => 9000,
        "po_date" => null,
        "proposal_submission_date" => null,
        "last_follow_up_date" => null,
        "expected_closing_date" => null,
        "probability_of_closing" => null,
        "activity_update" => null,
        "remarks" => null,
      ]);
      
    }
}
