<?php

namespace App\Service;

use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use League\CommonMark\Extension\CommonMark\Node\Inline\Code;

class AuthService
{
    /**
     * log the user in
     * 
     * @param string $emial
     * @param string $password
     * @return array
     * 
     * @throws Exception
     */
    public function login(string $email, string $password)
    {
        $user = User::where('email', $email)->first();

        if (!$user || !Hash::check($password, $user->password))
            throw new Exception("The provided credentials are not valid");

        if (!$user->is_activated)
            throw new Exception("Account is deactivated");

        $token = $user->createToken(config('app.name', 'TaskManagement'))->plainTextToken;

        return [
            'user' => $user,
            'token' => $token
        ];
    }

    /**
     * log the user out
     * 
     * @param User $user
     * @return void
     */
    public function logout(User $user) {
        $user->currentAccessToken()->delete();
    }
}
