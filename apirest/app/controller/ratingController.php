<?php

class RatingController
{

    public function __construct()
    {
        // VERIFICA CHAVE DE ACESSO
        $headers = apache_request_headers();

        if (!AuthJWT::checkAuth($headers, $res)) :
             print_r(json_encode(AppResponse::getResp(403, $res), JSON_PRETTY_PRINT));
             exit();
        endif;
    }

    public function post()
    {
        $rating = new RatingClass();

        $rating->setRate($_POST);
        
        return AppResponse::getResp(200, date("Y-m-d_h-i-s"));
    }
}
