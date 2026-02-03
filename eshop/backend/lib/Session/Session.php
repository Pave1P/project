<?php
declare(strict_types=1);

namespace Eshop\Session;


use Exception;
use RuntimeException;

class Session
{
    public function start(): bool
    {
        try{
            session_start();
            $_SESSION['sessionId'] = $this->generateSessionId();
            return true;
        } catch (RuntimeException) {
            return false;
        }
    }

//    public function delete(string $id): void
//    {
//        session_destroy($id);
//    }
//
//    //надо подумать где хранить сессии
//    public function check(): bool
//    {
//        return true;
//    }

    /**
     */
    public function generateSessionId(): ?string
    {
        try
        {
            $token = random_bytes(15);
            return  bin2hex($token);
        }
        catch (Exception $exception)
        {
            throw new RuntimeException('Unable to generate session id', 0, $exception);
        }
    }
}
