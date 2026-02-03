<?php
declare(strict_types=1);

namespace Eshop\Mapper;

use DateTime;
use Eshop\Model\User;
use Exception;

class UserMapper implements MapperInterface
{
    public function map(array $row): User
    {
        $dateCreated = DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['dateCreated']);
        $dateModified = DateTime::createFromFormat('Y-m-d H:i:s', (string)$row['dateModified']);

        if ($dateCreated === false || $dateModified === false)
        {
            throw new Exception('Invalid user date format.');
        }

        return new User(
            (int)$row['id'],
            $row['login'],
            $row['password'],
            $dateCreated,
            $dateModified
        );
    }
}
