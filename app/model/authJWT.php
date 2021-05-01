<?php


class AuthJWT
{

    private static $key = 'Pa$$Pl4yL1st'; //Application Key

    public static function getToken()
    {

        //CABEÇALHO JWT
        $header = [
            'typ' => 'JWT',
            'alg' => 'HS256'
        ];

        //PAYLOD PASSAGEM DE DADOS 
        $payload = [
            'name' => '',
        ];


        $header = json_encode($header);
        $payload = json_encode($payload);

        $header = self::base64UrlEncode($header);
        $payload = self::base64UrlEncode($payload);

        $sign = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
        $sign = self::base64UrlEncode($sign);

        $token = $header . '.' . $payload . '.' . $sign;

        return $token;
    }

    public static function checkAuth($http_header, &$res)
    {
        if (isset($http_header['Authorization']) && $http_header['Authorization'] != null) {
            $bearer = explode(' ', $http_header['Authorization']);

            $token = explode('.', $bearer[1]);
            $header = $token[0];
            $payload = $token[1];
            $sign = $token[2];

            $valid = hash_hmac('sha256', $header . "." . $payload, self::$key, true);
            $valid = self::base64UrlEncode($valid);
            $res = "noValidToken";
            if ($sign === $valid) {
                return true;
            }
        } else {
            $res = "noToken";
        }

        return false;
    }



    private static function base64UrlEncode($data)
    {
        $b64 = base64_encode($data);
        if ($b64 === false) {
            return false;
        }
        $url = strtr($b64, '+/', '-_');
        return rtrim($url, '=');
    }
}
