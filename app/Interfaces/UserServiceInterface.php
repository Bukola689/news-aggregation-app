<?php

namespace App\interfaces;

use App\Models\User;
use App\Dtos\UserDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface
{
    public function modelQuery(): Builder;
    
    public function createUser(UserDto $userDto): Model;

    public function getUserById(int $userId): Model;
}