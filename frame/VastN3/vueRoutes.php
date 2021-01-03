<?php
$routes = [
    ['path'=> '/Products', 'component' => 'nProducts']
];

function vueRoutes(){
    global $routes;
    $parse = json_encode($routes);
    echo preg_replace('/"component":"([a-z-]+)"/i', '"component":$1',$parse);
}

vueRoutes();