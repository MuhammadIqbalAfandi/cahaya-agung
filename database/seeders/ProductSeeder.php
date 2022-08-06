<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Product::create([
            "number" => "PDK" . now()->format("YmdHis"),
            "name" => "MacBook Pro 16-inch",
            "unit" => "pc",
            "profit" => 0,
        ]);

        Product::create([
            "number" =>
                "PDK" .
                now()
                    ->addSeconds(1)
                    ->format("YmdHis"),
            "name" => "MacBook Pro 14-inch",
            "unit" => "pc",
            "profit" => 30,
        ]);
    }
}
