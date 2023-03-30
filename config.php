<?php
define("DB_HOST","localhost");
define("DB_USER","root");
define("DB_PASS","");
define("DB_NAME","dziennik");


function dd($value) {
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
    die();
}

require_once 'app/app.php';
require_once 'app/controller.php';