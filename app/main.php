<?php

class Main
{

    private $requestData;

    private $path;

    private $file;
    private $class;
    private $method;
    private $params = array();

    //CONSTRUTOR RECEBE OS SEGMENT DA URL E DEFINE CAMINHO PARA CLASSES
    public function __construct($req)
    {
        $this->requestData = $req;
        $this->path = $_SERVER['DOCUMENT_ROOT'] . "/app/controller/";
        $this->parseUrl();
    }

    // TRANSFORMA OS SEGMENTOS EM PARA CONSULTAR NO PROXIMO METODO
    private function parseUrl()
    {
        $url = explode('/', $this->requestData['url']);

        if (isset($url[0])) :
            $this->file = $url[0] . 'Controller.php';
            $this->class = ucfirst($url[0]) . 'Controller';
            array_shift($url);
        endif;

        $this->method = strtolower($_SERVER['REQUEST_METHOD']);
    }

    //PRINCPAL CHAMADA, TRAZ A CLASSE DESEJADA E O METODO SERA O MESMO HTTP EM CADA CLASSE 
    public function exec()
    {
        if (file_exists($this->path . $this->file)) :
            require_once($this->path . $this->file);
            if (class_exists($this->class) && method_exists($this->class, $this->method)) :
                $className = "$this->class";
                $resp = call_user_func_array(array(new $className, $this->method), $this->params);
            else :
                $resp = AppResponse::getResp(400);
            endif;
        else :
            $resp = AppResponse::getResp(400);
        endif;

        return json_encode($resp, JSON_PRETTY_PRINT);
    }

}
