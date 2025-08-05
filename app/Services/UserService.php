<?php

namespace App\Services;

use App\Dtos\UserDto;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use App\Exceptions\ModeNotFoundException;
use App\Exceptions\PinHasAlreadyBeenSetException;
use App\Exceptions\PinNotSetException;
use Illuminate\Database\Eloquent\Builder;
use App\Interfaces\UserServiceInterface;
use Illuminate\Http\Request;
use App\Exceptions\InvalidPinLengthException;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function register(UserDto $userDto)
    {
      $user = User::query()->create([
            'name' => $userDto->name,
            'email' => $userDto->email,
            'password' => Hash::make($userDto->password),
        ]);

          $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ], 201);
    }

     public function login(UserDto $userDto)
    {
        if (!Auth::attempt(['email' => $userDto->email, 'password' => $userDto->password])) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], 401);
        }

        $user = Auth::user();

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'success' => true,
            'user' => $user,
            'token' => $token,
        ]);
        
    }

     public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }
    
      public function getUserById(int $userId): Model
    {
        $user = User::query()->find($userId);

        if (!$user) {
            throw new ModelNotFoundException('User Not Found');
        }

        return $user;
    }
}