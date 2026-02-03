<?php
declare(strict_types=1);

namespace Eshop\Controllers;

use Eshop\Services\Auth\AuthorizationService;
use Exception;
use RuntimeException;

class LoginAdminController
{
    private array $info = [
        "ok" => false,
        "message" => 'Неправильный пароль или логин',
    ];

    /**
     * @throws Exception
     */
    public function loginAction(): array
    {
        if (!(isset($_POST['login'], $_POST['password'])))
        {
            return $this->info;
        }

        $login = $_POST['login'];
        $password = $_POST['password'];

        $Authorization = new AuthorizationService();
        $success = $Authorization->verifyCredentials($login, $password);

        if (!$success)
        {
            return $this->info;
        }

        //заглушка пока нет сессий
        //просто делаем ридерект в случае успешной авторизации

        $success = $Authorization->login();
        if (!$success)
        {
            return $this->info;
        }

        $this->redirectAction();

        return [
            "ok" => true,
            "message" => 'Успешно авторизирован',
        ];

    }
    // обдумать и дать name каждой странице (name = url)

    /**
     * @throws Exception
     */
    public function redirectAction(): void
    {
        $pages = require BACKEND_ROOT . '/config/pageUrl.php';
        $urlPage = null;


        foreach ($pages as $page)
        {
            if($page['name']==='adminPanel')
            {
                $urlPage = $page['url'];
            }
        }

        if  ($urlPage === null)
        {
            throw new RuntimeException("No find page: " . 'adminPanel');
        }

        header('Location: eshop.bx' . $urlPage, true, 301);
    }

}