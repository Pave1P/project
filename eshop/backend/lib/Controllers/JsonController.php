<?php

namespace Eshop\Controllers;

abstract class JsonController
{
    public function getJsonBody(): array
    {
        $raw = file_get_contents('php://input');
        if ($raw === false || $raw === '') {
        return [];
        }

        $data = json_decode($raw, true);
        return is_array($data) ? $data : [];
    }
}