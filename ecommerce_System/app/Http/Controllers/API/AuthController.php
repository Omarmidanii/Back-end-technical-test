<?php

namespace App\Http\Controllers\API;


use App\Http\Controllers\Controller;
use App\Http\Interfaces\AuthRepositoryInterface;
use App\Http\Requests\Auth\LoginRequest;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use App\Trait\ApiResponse;
use PHPOpenSourceSaver\JWTAuth\Exceptions\JWTException as ExceptionsJWTException;
use PHPOpenSourceSaver\JWTAuth\JWTAuth; // Adjust the namespace based on your JWT library  
use PHPOpenSourceSaver\JWTAuth\JWTException;
use Throwable;

class AuthController extends Controller
{
    use ApiResponse;
    private $AuthRepository;
    protected $jwt;

    public function __construct(AuthRepositoryInterface $authRepository, JWTAuth $jwt)
    {
        $this->jwt = $jwt;
        $this->AuthRepository = $authRepository;
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }
    public function login(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        try {
            if (!$token = $this->jwt->attempt($credentials)) {
                return response()->json(['error' => 'Invalid credentials'], 401);
            }
        } catch (ExceptionsJWTException $e) {
            return response()->json(['error' => 'Could not create token'], 500);
        }
        return response()->json(['token' => $token]);
    }
    public function register(RegisterRequest $request)
    {
        try {
            $data = $request->validated();
            $user = $this->AuthRepository->register($data);
            return $this->SuccessOne($user, null, 'User Created Successfully');
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }
    public function logout()
    {
        try {
            Auth::logout();
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        } catch (Throwable $th) {
            return $this->Error($th);
        }
    }
    public function refresh()
    {
        return response()->json([
            'user' =>
            Auth::user(),
            'authorisation' => [
                'token' => Auth::refresh(),
                'type' => 'bearer',
            ]
        ]);
    }
}
