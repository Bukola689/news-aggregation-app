<?php

namespace App\interfaces;

use App\Models\User;
use App\Dtos\UserDto;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface UserServiceInterface
{
    public function register(UserDto $userDto);
    
    public function login(UserDto $userDto);
    
    public function logout(Request $request);

    public function user(Request $request);


}