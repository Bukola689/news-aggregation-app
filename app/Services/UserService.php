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
use App\Exceptions\InvalidPinLengthException;
use Illuminate\Support\Facades\Hash;

class UserService implements UserServiceInterface
{
    public function createUser(UserDto $userDto): Model
    {
      return User::query()->create([
            'name' => $userDto->getName(),
            'email' => $userDto->getEmail(),
            'password' => $userDto->getPassword(),
        ]);
    }

    public function modelQuery(): Builder
    {
        return User::query();
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