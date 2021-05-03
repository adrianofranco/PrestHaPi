<?php 

$map = [
   
    'AppResponse' => 'appResponse.php',
    'Main' => 'main.php',
    
    'AuthJWT' => 'model/authJWT.php',
    'ListClass' => 'model/listClass.php',
    'RatingClass' => 'model/ratingClass.php',
    
 ];

 

spl_autoload_register(function ($class) use ($map){
    if (isset($map[$class])):
        require_once $map[$class];
    endif;
}, true);