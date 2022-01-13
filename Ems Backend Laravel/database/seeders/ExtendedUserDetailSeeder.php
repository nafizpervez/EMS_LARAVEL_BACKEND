<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Models\User;
use App\Models\ExtendedUserDetail;

class ExtendedUserDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = User::all();

        foreach ($users as $user) {
            ExtendedUserDetail::create([
                'user_id' => $user->id,
            ]);
        }
    }
}
