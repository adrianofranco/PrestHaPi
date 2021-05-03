<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

require_once('./app/autoloader.php');

// DEFINE OS CABEÇALHOS USADO NO REST

header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');
header('Access-Control-Max-Age: 1000');
header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token, Authorization');
header('Content-Type: application/json');

// FAZ UM GET NO METHODO DE REQUISIÇÃO
$reqMethod = $_SERVER['REQUEST_METHOD'];

// ANALISA SE O METHODO REQUERIDO SERÁ OS USÁVEIS NA APLICAÇÃO
if (in_array($reqMethod, ['GET', 'POST', 'DELETE', 'PUT'])) {
    
    if (isset($_REQUEST) && !empty($_REQUEST)) {
        $main = new Main($_REQUEST);
        $main->exec();
    }

} else {
    print_r(json_encode(AppResponse::getResp(405), JSON_PRETTY_PRINT)); //RETORNA METODO NAO PERMITIDO
}
