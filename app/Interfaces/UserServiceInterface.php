<?php

namespace App\interfaces;

use App\Models\User;
use App\Dtos\UserDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface
{
    public function modelQuery(): Builder;
    
    public function createUser(UserDto $userDto): Model;

    public function getUserById(int $userId): Model;

    public function setupPin(User $user, string $pin): Void;

    public function validatePin(int $userId, string $pin): bool;

    public function hasSetPin(User $user): bool;
}