<?php

require_once __DIR__ . '/core/Connexion.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/core/Controller.php';

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}


$c = isset($_REQUEST['c']) ? $_REQUEST['c'] : 'Home';
http://localhost/

$m = isset($_REQUEST['m']) ? $_REQUEST['m'] : 'index';
$c =  $c . 'Controller';

$params = [];
foreach ($_REQUEST as $key => $value) {
    if ($key != 'c' && $key != 'm') {
        $params[$key] = $value;
    }
}
if(file_exists("controllers/$c.php")) {
    require_once("controllers/$c.php");
    $c = new $c;
    if(method_exists($c, $m)) {
        if (!empty($params)) {
            call_user_func(array($c, $m), $params);
        } else {
            call_user_func(array($c, $m));

        }
    } else{
        echo json_encode(['error' => 'Method not found']);
    }
} else{
    echo json_encode(['error' => 'Controller not found']);
}