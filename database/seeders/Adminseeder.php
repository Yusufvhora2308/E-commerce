<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;

class Adminseeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

            User::create([
            'name'     => 'Yusuf',
            'email'    => 'admin@gmail.com',
            'password' => Hash::make('Admin@123'),   // Default password 
            'role'     => 'admin',
        ]);

    }
}
