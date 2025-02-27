<?php

namespace App\Http\Repositories;

use App\Http\Interfaces\AuthRepositoryInterface;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthRepository implements AuthRepositoryInterface
{

    public function login($data)
    {
        $token = Auth::attempt($data);
        if (!$token) {
            throw new Exception('Unauthorized', 401);
        }
        $user = Auth::user();
        return $user;
    }
    public function register($data)
    {
        $user = User::create([
            'firstname' => $data['firstname'],
            'lastname' => $data['lastname'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
        return $user;
    }
}
