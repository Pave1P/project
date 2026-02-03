<?php
declare(strict_types=1);

namespace Eshop\Model;

use DateTime;

class User
{
    public readonly int $id;
    public readonly string $login;
    public readonly string $password;
    public readonly DateTime $dateCreated;
    public readonly DateTime $dateModified;

    public function __construct(int $id, string $login, string $password, DateTime $dateCreated, DateTime $dateModified)
    {
        $this->id = $id;
        $this->login = $login;
        $this->password = $password;
        $this->dateCreated = $dateCreated;
        $this->dateModified = $dateModified;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'password' => $this->password,
            'dateCreated' => $this->dateCreated,
            'dateModified' => $this->dateModified,
        ];
    }

}