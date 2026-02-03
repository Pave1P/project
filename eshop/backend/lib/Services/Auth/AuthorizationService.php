<?php
declare(strict_types=1);

namespace Eshop\Services\Auth;

use Eshop\Mapper\UserMapper;
use Eshop\Repository\UserRepository;
use Eshop\Session\Session;
use Exception;

Class AuthorizationService
{
    public function login() : bool
    {
        return (new Session())->start();

    }

    /**
     * @throws Exception
     */
    public function verifyCredentials(string $login, string $password) : bool
    {

        $userRepository = new UserRepository(new UserMapper());
        $user = $userRepository->findBylogin($login);

        if (!$user){
            return false;
        }

        return (new HasherPassword())->verify($password, $user->password);
    }


}
