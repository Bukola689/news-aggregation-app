<?php

namespace App\Dtos;

use App\Interfaces\DtoInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

class UserDto
{
    public $name;

    public $email;

    public $password;

    public function __construct(array $data)
    {
        $this->name = $data['name'];

        $this->email = $data['email'];

        $this->password = $data['password'];

    }

     public static function fromApiFormRequest(UserRequest $request): DtoInterface    
   {
      $userDto = new UserDto();
      $userDto->setName($request->input('name'));
      $userDto->setEmail($request->input('email'));
      $userDto->setPhoneNumber($request->input('phone_number'));
      //$userDto->setPin($request->input('pin'));
      $userDto->setPassword($request->input('password'));
      return $userDto;
   }

   public static function fromModel(Model $model): DtoInterface
   {
       $userDto = new UserDto();
       $userDto->setId($model->id);
       $userDto->setName($model->name);
       $userDto->setEmail($model->email);
       $userDto->setPhoneNumber($model->phone_number);
       $userDto->setPin($model->pin);
       $userDto->setPassword($model->password);
       $userDto0>setCreated_at($model->created_at);
       $userDto->setUpdated_at($model->updated_at);
       return $userDto;
   }

   public static function toArray(Model $model): array
   {
       return [
           'id' => $model->id,
           'email' => $model->email,
           'phone_number' => $model->phone_number,
           'pin' => $model->pin,
           'password' => $model->password,
           'created_at' => $model->created_at,
           'updated_at' => $model->updated_at,
       ];
   }
}