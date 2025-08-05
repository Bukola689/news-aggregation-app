<?php

namespace App\Dtos;

use App\Interfaces\DtoInterface;
use Illuminate\Support\Facades\Hash;
use Carbon\Carbon;

class UserDto implements DtoInterface
{
    private int $id;

    private string $name;

    private string $email;

    private string $password;

    private Carbon $created_at;

    private Carbon $updated_at;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getCreatedAt(): Carbon
    {
        return $this->created_at;
    }

    public function setCreatedAt(Carbon $created_at)
    {
        $this->created_at = $created_at;
        return $this;
    }

    public function getUpdatedAt(): Carbon
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(Carbon $updated_at)
    {
        $this->updated_at = $updated_at;
        return $this;
    }
}