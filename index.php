<?php
ini_set('display_errors',1);
error_reporting(E_ALL);
use app\Config;
use app\Controller;


spl_autoload_register(function($class){
	$path=str_replace('\\','/',$class.'.php');
	if(file_exists($path)) require $path;
});

session_start();

$request=trim($_SERVER['REQUEST_URI'],'/');
$controller=new Controller();
if($request=='') return $controller->show();
elseif(in_array($request, Config::ROUTES)&&method_exists($controller,$request)) return $controller->$request();
else echo 'Страница не найдена';

?>


