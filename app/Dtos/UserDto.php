<?php

namespace App\Dtos;
use App\Interfaces\DtoInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserRequest;
use Illuminate\Http\Request;
use Carbon\Carbon;

Class UserDto implements DtoInterface
{
    private int $id;

    private string $name;

    private string $email;
    
    private string $password;

    private Carbon $created_at;

    private Carbon $updated_at;

   public function getId()
   {
       return $this->id;
   }

    public function setId($id)
   {
       $this->id = $id;
   }

    public function getName()
    {
        //$this->name = $name;
        return $this->name;
    }

     public function setName(string $name)
    {
        $this->name = $name;
        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

     public function setEmail(string $email)
    {
        $this->email = $email;
        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

      public function setPassword(string $password)
    {
          $this->password = Hash::make($password);
          return $this;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function setCreatedAt(Carbon $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(Carbon $updated_at): void
    {
        $this->updated_at = $updated_at;
    }

   public static function fromApiFormRequest(UserRequest $request): DtoInterface    
   {
      $userDto = new UserDto();
      $userDto->setName($request->input('name'));
      $userDto->setEmail($request->input('email'));
      $userDto->setPassword($request->input('password'));
      $userDto->setCreatedAt(Carbon::now());
      $userDto->setUpdatedAt(Carbon::now());
      return $userDto;
    }


    public static function fromModel(Model $model): DtoInterface
    {
       $userDto = new UserDto();
       $userDto->setId($model->id);
       $userDto->setName($model->name);
       $userDto->setEmail($model->email);
       $userDto->setPassword($model->password);
       $userDto->setCreatedAt($model->created_at);
       $userDto->setUpdatedAt($model->updated_at);
       return $userDto;
    }

   public static function toArray(Model $model): array
   {
       return [
           'id' => $model->id,
           'name' => $model->name,
           'email' => $model->email,
           'created_at' => $model->created_at,
           'updated_at' => $model->updated_at,
       ];
   }
}