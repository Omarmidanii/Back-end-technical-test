<?php


namespace App\Http\Interfaces;

use App\Http\Requests\Auth\LoginRequest;

interface AuthRepositoryInterface
{
    public function login($data);
    public function register($data);
}
