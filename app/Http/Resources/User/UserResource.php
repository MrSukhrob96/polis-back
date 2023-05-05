<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email,
            "passwordExpiryDate" => $this->passwordExpiryDate,
            "hasToChangePasswordAfterLogin" =>  Carbon::parse($this->hasToChangePasswordAfterLogin)->format('Y-m-d h:m:s'),
            "lastActivityUser" => $this->lastActivityUser,
            "status" => $this->status,
            "created_at" => Carbon::parse($this->created_at)->format('Y-m-d h:m:s')
        ];
    }
}
