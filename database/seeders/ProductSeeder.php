<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product  = new Product();
        $product->title =  'Product 1';
        $product->price =  450;
        $product->quantity =  10;
        $product->category_id = 1;
        $product->brand_id = 1;
        $product->description = 'Lorem aute amet incididunt sint reprehenderit exercitation laborum. Excepteur ipsum qui commodo do cillum in. Et proident enim amet laboris occaecat incididunt et ut.';
        $product->save();
    }
}
