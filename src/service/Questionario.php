<?php

namespace service;

use tokenService;

class Questionario
{
    public static function checkAuthentication() {
        if (!isset($_GET["token"])) {
            return false;
        } else {
            $token = $_GET["token"];
            if (TokenService::checkTokenValidation($_GET["token"])) {
                return TokenService::decrypt($token);
            } else {
                return false;
            }
        }
    }
}
