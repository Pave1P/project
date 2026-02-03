<?php
declare(strict_types=1);

namespace Eshop\Repository;

use DateTime;
use Eshop\Mapper\UserMapper;
use Eshop\Model\User;
use Eshop\Services\Auth\HasherPassword;
use Eshop\Services\DatabaseService;
use Exception;

class UserRepository
{
    public function __construct(
        private UserMapper $mapper,
    ) {}

    /**
     * @throws Exception
     */
    public function findBylogin(string $login): ?User
    {
        $sqlQuery = 'SELECT DISTINCT
						u.id,
						u.login,
						u.password,
						u.date_created,
						u.date_modified
					FROM up_user u
				 	WHERE login = ?
				 	LIMIT 1';

        $result = DatabaseService::dbQuery($sqlQuery, 's', [$login]);
        $row = mysqli_fetch_assoc($result);

        return $row ? $this->mapper->map($row) : null;
    }

    /**
     * @throws Exception
     */
    public function save(array $infoUser ): bool
    {
        $sqlQuery = 'INSERT INTO up_user
                     (login, password, date_modified)
                     VALUES (?, ?, ?)';

        $now = new DateTime();
        $date_modified = $now->format('Y-m-d H:i:s');

        $hasher = new HasherPassword();
        $hashPassword = $hasher->hash($infoUser['password']);

        $result = DatabaseService::dbExecute($sqlQuery, 'ss', [
            $infoUser['login'],
            $hashPassword,
            $date_modified
        ]);

        return $result['affected_rows'] > 0;

    }

    /**
     * @throws Exception
     */
    public function delete($login): bool
    {
        $sqlQuery = 'DELETE FROM up_user
                     WHERE login = ?
				 	 LIMIT 1';

        $result = DatabaseService::dbExecute($sqlQuery, 'ss', [$login]);

        return $result['affected_rows'] > 0;
    }

    // при текущей таблицы User можем поменять только пароль пользователя

    /**
     * @throws Exception
     */
    public function update(array $userUpdateData): bool
    {
        $sqlQuery = 'UPDATE up_user
                     SET password = ?
                     SET date_modified = ?
                     WHERE login = ?
                     LIMIT 1';

        $now = new DateTime();
        $date_modified = $now->format('Y-m-d H:i:s');

        $hasher = new HasherPassword();
        $hashPassword = $hasher->hash($userUpdateData['password']);

        $result = DatabaseService::dbExecute($sqlQuery, 'ss', [
            $hashPassword,
            $date_modified,
            $userUpdateData['login'],
            ]);

        return $result['affected_rows'] > 0;

    }

}