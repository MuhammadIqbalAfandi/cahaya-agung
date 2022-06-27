<?php

namespace Database\Seeders;

use App\Models\Ppn;
use Illuminate\Database\Seeder;

class PpnSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Ppn::create([
            'ppn' => 11
        ]);
    }
}
