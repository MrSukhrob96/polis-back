<?php

namespace App\DTO\Auth;

use App\Core\CoreDTO;

class LoginDTO extends CoreDTO
{
    public string $email;
    public string $password;

    /**
     * @param array<string, string>
     */
    public function __construct(array $data)
    {
        $this->email = $data["email"];
        $this->password = $data["password"];
    }

    public function toArray(): array
    {
        return array(
            "email" => $this->email,
            "password" => $this->password
        );
    }
}
