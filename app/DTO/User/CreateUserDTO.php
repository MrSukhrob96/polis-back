<?php

namespace App\DTO\User;

use App\Core\CoreDTO;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

class CreateUserDTO extends CoreDTO
{
    public string $firstName;
    public string $lastName;
    public string $email;
    public string $password;
    public string $passwordExpiryDate;
    public bool $hasToChangePasswordAfterLogin;
    public ?string $lastActivityUser;
    public ?string $status;

    /**
     * @param array<string, string>
     */
    public function __construct(array $data)
    {
        $this->firstName = $data["firstName"];
        $this->lastName = $data["lastName"];
        $this->email = $data["email"];
        $this->password = $data["password"];
        $this->passwordExpiryDate = Carbon::now()->addDays(5);
        $this->hasToChangePasswordAfterLogin = true;
        $this->lastActivityUser = null;
        $this->status = null;
    }

    public function toArray(): array
    {
        return array(
            "firstName" => $this->firstName,
            "lastName" => $this->lastName,
            "email" => $this->email,
            "password" => Hash::make($this->password),
            "passwordExpiryDate" => $this->passwordExpiryDate,
            "hasToChangePasswordAfterLogin" => $this->hasToChangePasswordAfterLogin,
            "lastActivityUser" => $this->lastActivityUser,
            "status" => $this->status
        );
    }
}
