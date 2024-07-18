<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user  =  new User();
        $user->name = 'Admin';
        $user->email = 'admin@mail.com';
        $user->password = bcrypt('admin123');
        $user->is_admin = 1;
        $user->save();
    }
}
