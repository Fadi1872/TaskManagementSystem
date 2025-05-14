<?php

namespace App\Service;

use App\Models\User;

class UserService
{
    /**
     * list all activated users
     * 
     * @return Collection<User>
     */
    public function listAll()
    {
        $users = User::all();
        return $users;
    }

    /**
     * create new user by admin
     * 
     * @param array $data
     * @return void
     */
    public function createUser(array $data)
    {
        $userData = [
            "name" => $data['name'],
            "email" => $data['email'],
            "password" => $data['password'],
        ];
        if (!empty($data['is_admin']) ?? null)
            $userData['is_admin'] = $data['is_admin'];

        User::create($userData);
    }

    /**
     * update user credentials
     * 
     * @param array $data
     * @return void
     */
    public function updateUser(array $data, User $user)
    {
        $userData = [
            'name' => $data['name'],
            'email' => $data['email'],
        ];
        if (!empty($data['is_admin']) ?? null)
            $userData['is_admin'] = $data['is_admin'];
        if (!empty($data['password']) ?? null)
            $userData['password'] = $data['password'];

        $user->update($userData);
    }

    /**
     * delete the user
     * 
     * @param User $user
     * @return void
     */
    public function deleteUser(User $user) {
        $user->delete();
    }

    /**
     * deactivate the uesr
     * 
     * @param User $user
     * @return boolean
     */
    public function deactivateUser(User $user) {
        $is_Activated = $user->is_activated;
        $user->update([
            'is_activated' => !$is_Activated
        ]);
        return $user->is_activated;
    }
}
