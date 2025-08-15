<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $user = new User();
        $user->name = "devtik@unipa.ac.id";
        $user->username = "devtik@unipa.ac.id";
        $user->password = bcrypt("TikUni!p@");
        $user->save();
        $user->assignRole('admin');

        $user1 = new User();
        $user1->name = "user";
        $user1->username = "user";
        $user1->password = bcrypt("Unipa123");
        $user1->save();
        $user1->assignRole('user');
    }
}
