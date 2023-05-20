<?php
//файл конфигурации
namespace app;
class Config {
//роуты
    const  ROUTES =[
        'login',
        'exit',
        'register',
        'loginForm',
        'registerForm'
    ];
//данные для подключения в бд
    const DB_CREDENTIALS=[
        'host'=>'localhost',
        'dbname'=>'user_bd',
        'user'=>'root',
        'password'=>''
    ];
}
?>