<?php

namespace Database\Seeders;

use App\Models\Company;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CompanySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Company::create([
            "name" => "Your Company",
            "address" => "Your Address Company",
            "telephone" => "0611",
            "npwp" => "061111111111111",
        ]);
    }
}
