<?php
//файл точка входа всех запросов
ini_set('display_errors',1);
error_reporting(E_ALL);
use app\Config;
use app\Controller;
//регистрируем автозагрузчик классов
spl_autoload_register(function($class){
	$path=str_replace('\\','/',$class.'.php');
	if(file_exists($path)) require $path;
});
//ничинаем сессию
session_start();
//распознаем запрос
$request=trim($_SERVER['REQUEST_URI'],'/');
//создаем объект контроллера
$controller=new Controller();
//начальная страница
if($request=='') return $controller->show();
//прочие страницы
elseif(in_array($request, Config::ROUTES)&&method_exists($controller,$request)) return $controller->$request();
//ошибка если не распознал запрос
else echo 'Страница не найдена';

?>


