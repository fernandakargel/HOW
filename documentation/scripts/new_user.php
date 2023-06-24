<?php
use Bruner\Security\Security;

include 'vendor/bruner/Bruner/Security/Security.php';

if (PHP_SAPI === 'cli') {
    $param["name"] = $argv[1];
    $param["mail"] = $argv[2];
    $param["pass"] = $argv[3];
}
else {
    $param["name"] = $_GET['name'];
    $param["mail"] = $_GET['email'];
    $param["pass"]= $_GET['password'];
}

if(isset($param["name"]) && isset($param["mail"]) && isset($param["pass"])){
    echo    "\n\n[ Informações ] \n\n".
            "Nome:". Security::encrypt($param["name"]) . "\n"  . 
            "E-mail:" . Security::encrypt($param["mail"]) . "\n"  .
            "Passeowrd: ". Security::hash($param["pass"]) . "\n\n";
} else {
    echo "\n\n Passe como parâmetro Nome, e-mail e senha \n\n";
}