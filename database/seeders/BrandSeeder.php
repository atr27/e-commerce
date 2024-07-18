<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brand = new Brand();
        $brand->name = 'Apple';
        $brand->slug = 'apple';
        $brand->save();

        $brand = new Brand();
        $brand->name = 'Samsung';
        $brand->slug = 'samsung';
        $brand->save();

        $brand = new Brand();
        $brand->name = 'Xiaomi';
        $brand->slug = 'xiaomi';
        $brand->save();

        $brand = new Brand();
        $brand->name = 'Asus';
        $brand->slug = 'asus';
        $brand->save();
    }
}
