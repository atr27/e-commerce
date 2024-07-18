<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category =  new Category();
        $category->name = 'Laptop';
        $category->slug = 'laptop';
        $category->save();

        $category =  new Category();
        $category->name = 'Smartphone';
        $category->slug = 'smartphone';
        $category->save();

        $category =  new Category();
        $category->name = 'Tablet';
        $category->slug = 'tablet';
        $category->save();

        $category =  new Category();
        $category->name = 'TV';
        $category->slug = 'tv';
        $category->save();

        $category =  new Category();
        $category->name = 'Watch';
        $category->slug = 'watch';
        $category->save();
    }
}
