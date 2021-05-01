<?php

class ListController
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

    public function get()
    {
        $list = new ListClass();
        return AppResponse::getResp(200, json_decode($list->getList()));
    }
 
    public function post()
    {
        return AppResponse::getResp(200, array("ok"));
    }
}
