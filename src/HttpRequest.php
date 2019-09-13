<?php

namespace App;

/**
 * Class HttpRequest
 * @package App
 */
class HttpRequest
{
    /**
     * @param string|null $key
     * @return mixed
     */
    public static function post(?string $key = null)
    {
        $data = json_decode(file_get_contents('php://input'), true);

        if (!$data) {
            $data = $_POST;
        }

        if ($key) {
            return $data[$key];
        }

        return $data;
    }
}