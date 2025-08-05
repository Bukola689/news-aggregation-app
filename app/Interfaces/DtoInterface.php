<?php

namespace App\Interfaces;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;
use App\Http\Requests\UserRequest;


interface DtoInterface
{

    // an aapi form request is a request that is used to validate and transform incoming data
    // before it is passed to the controller. It is typically used in API endpoints to ensure
    public static function fromApiFormRequest(UserRequest $request): DtoInterface;
    

    // that the data is in the correct format and meets the required validation rules.
    public static function fromModel(Model $model): DtoInterface;

    // Convert the DTO to an array representation.
    // This is useful for serializing the DTO to JSON or for returning it in API responses
    public static function toArray(Model $model): array;
}