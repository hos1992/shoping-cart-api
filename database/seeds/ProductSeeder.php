<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['title' => 'P1', 'price' => 100, 'discount' => null, 'final_price' => null, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['title' => 'P2', 'price' => 100, 'discount' => 50, 'final_price' => 50, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
            ['title' => 'P3', 'price' => 300, 'discount' => null, 'final_price' => null, 'created_at' => \Carbon\Carbon::now(), 'updated_at' => \Carbon\Carbon::now()],
        ];
        DB::table('products')->insert($data);
    }
}
