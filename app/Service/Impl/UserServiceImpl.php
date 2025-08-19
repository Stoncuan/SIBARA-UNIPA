<?php

namespace App\Service\Impl;

use App\Models\User;
use App\Service\UserService;
use Auth;

class UserServiceImpl implements UserService
{
    public function getAllUser()
    {
        $user = Auth::user();

        return User::query()
            ->where('username', '!=', $user['username'])
            ->whereDoesntHave('roles', function ($q) {
                $q->where('name', 'superAdmin');
            })->get();
    }

    public function getUserByUsername($username){
        return User::query()->where('username', '=', $username)->first('username');
    }

    public function createUser(string $name, string $username, string $password)
    {
        $user = new User([
            "name" => $name,
            "uesrname" => $username,
            "password" => bcrypt($password)
        ]);

        $user->save();
        $user->assignRole('user');
    }

    public function updateUser(int $id, string $name, string $password){
        $user = User::query()->find($id);
        $user->name = $name;
        $user->password = bcrypt($password);

        $user->save();
    }

    public function deleteUser(int $id){
        $user = User::query()->find($id);

        if($user != null){
            $user->delete();
        }
    }

    public function getUserSession(){
        return Auth::user();
    }
}
