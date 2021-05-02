<?php

class AuthController{
    

    public function post(){
                 
            $token = AuthJWT::getToken();
            return AppResponse::getResp(200, array("Authorization" => $token));
    }

}