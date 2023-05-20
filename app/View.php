<?php
//класс для рендеринга страниц
namespace app;

class View
{
    //объявляем путь к файлу страницы
    public $path;
    //название шаблона
    public $layout='app';
    //основной метод
    public function render($page=null,$data=null)
    {
        //открываем буфер
        ob_start();
        //если есть файл страницы в запросе, то подгружаем его
        if($page&&file_exists('app/views/'.$page.'.php')) require 'app/views/'.$page.'.php';
        //если нет выводим сообщение
        else echo 'вью не найден';
        //сохраняем страницу в переменную
        $content=ob_get_clean();
        //загружаем шаблон с переменной $content
        require_once 'app/views/layout.php';
    }
}

?>