<?php

class tokenService
{

    private const ENCRYTION_METHOD = "aes-128-cbc";

    public static function encrypt($data) {
        return @openssl_encrypt(json_encode($data), tokenService::ENCRYTION_METHOD, apache_getenv("secret_key"));
    }

    public static function decrypt($token) {
        return json_decode(openssl_decrypt($token, tokenService::ENCRYTION_METHOD, apache_getenv("secret_key")), true);
    }

    public static function checkTokenValidation($token) {
//        $data = tokenService::decrypt($token);
//        $date = new DateTime("now");
//        var_dump( $data != null and
//            isset($data['expires']) and
//            isset($data['id']) and
//            $data['expires'] > $date->getTimestamp());
        return
            $data = tokenService::decrypt($token) and
            isset($data['expires']) and
            isset($data['id']) and
            $data['expires'] > (new DateTime("now"))->getTimestamp();
    }
}
