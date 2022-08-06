<?php

namespace Database\Seeders;

use App\Models\Supplier;
use Illuminate\Database\Seeder;

class SupplierSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Supplier::create([
            "name" => "Taylor Otwell",
            "address" => "Singapore",
            "phone" => "0611",
            "npwp" => "061111111111111",
        ]);
    }
}
