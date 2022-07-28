<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            "name" => "Owner",
            "username" => "owner",
            "password" => bcrypt("owner"),
            "role_id" => 1,
        ]);

        User::create([
            "name" => "Admin 1",
            "username" => "admin1",
            "password" => bcrypt("admin1"),
            "role_id" => 2,
        ]);

        User::create([
            "name" => "Admin 2",
            "username" => "admin2",
            "password" => bcrypt("admin2"),
            "role_id" => 3,
        ]);
    }
}
