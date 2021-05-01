<?php

class AppResponse
{
    //DEFINE O RETORNO HTTP E ABRE ABRE PARAMETRO PARA PASSAGEM DE DADOS

    public static function getResp($reqCode, $data = [])
    {
        switch ($reqCode):

            case 200:
                $http = '200';
                $httpResponse = 'Successful request.';
                $success = TRUE;
                break;

            case 400:
                $http = '400';
                $httpResponse = 'Bad Requst.';
                $success = FALSE;
                break;

            case 402:
                $http = '402';
                $httpResponse = 'Payment Required.';
                $success = FALSE;
                break;

            case 403:
                $http = '403';
                $httpResponse = 'Forbidden.';
                $success = FALSE;
                break;

            case 404:
                $http = '404';
                $httpResponse = 'Not Found.';
                $success = FALSE;
                break;

            case '405':
                $http = '405';
                $httpResponse = 'Method not allowed.';
                $success = FALSE;
                break;

            case 500:
                $http = '500';
                $httpResponse = 'Internal Server Error.';
                $success = FALSE;
                break;

            default:
                $http = '000';
                $httpResponse = 'Unknown Error';
                $success = FALSE;
        endswitch;

        http_response_code($reqCode);
        
        return array('data' => $data, 'success' => $success, 'httpcode' => $http, 'httpResponse' => $httpResponse);
    }
}
