<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'Admin';
        $user->email = 'admin@admin.it';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User();
        $user->name = 'test';
        $user->email = 'test@email.it';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User();
        $user->name = 'admin';
        $user->email = 'admin@email.it';
        $user->password = Hash::make('password');
        $user->save();

        $user = new User();
        $user->name = 'user';
        $user->email = 'user@email.it';
        $user->password = Hash::make('password');
        $user->save();
    }
}