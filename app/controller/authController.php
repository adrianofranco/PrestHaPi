<?php

class AuthController{

    
    public function get(){
                       
        $token = AuthJWT::getToken();

        return AppResponse::getResp(200, array("Authorization" => $token));

    }


}