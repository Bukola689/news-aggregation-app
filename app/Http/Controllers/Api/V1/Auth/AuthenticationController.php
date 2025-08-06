<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\LoginRequest;
use App\Dtos\UserDto;
use App\Interfaces\DtoInterface\FromApiFormRequest;
use App\Traits\ApiResponseTrait;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Services\UserService;
use App\Models\User;
use Illuminate\Http\Request;

class AuthenticationController extends Controller
{
     use ApiResponseTrait;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(UserRequest $request,UserService $userService): JsonResponse
    {
        $userDto = UserDto::fromApiFormRequest($request);
        $user = $this->userService->createUser($userDto);
        return $this->sendSuccess(['user'=> $user,], 'Register Successfull');
    }

   public function login(LoginRequest $request): JsonResponse   
   {
      $credentials = $request->validated();

        // Attempt to log the user in

       if (!Auth::attempt($credentials)) {
            return $this->sendError('Invalid credentials', null, 401);
        }

        $user = Auth::user();
        $token = $user->createToken('API Token')->plainTextToken;

        return $this->sendSuccess([
            'user' => $user,
            'token' => $token
        ], 'Login successful');
   }

        public function logout(Request $request): jsonResponse
    {
        if (!$request->user()) {
            return $this->sendError('Unauthenticated', null, 401);
        }
        
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();
        }

        return $this->sendSuccess([
            'user' => $request->user(),
        ], "Authentcated User Retrieved Successfully");
    }

    public function user(Request $request): jsonResponse
    {
        return $this->sendSuccess([
            'user' => $request->user(),
        ], "Authentcated User Retrieved Successfully");
    }

}
