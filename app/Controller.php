<?php
//контроллер для обработки всех запросов
namespace app;
use app\User;
class Controller {

    public $user;
    public $view;
    //в конструкторе создаем новый объект модели User для работы с БД и View для рендеринга страниц
    public function __construct() {
        $this->user=new User;
        $this->view=new View;
    }
    //метод для главной страницы
    public function show() {
        if(isset($_COOKIE['TestUser'])){
            $auth=$this->user->findByLogin($_COOKIE['TestUser']);
            if(count($auth)>0) return $this->view->render('main',$auth);
        }
        else return $this->loginForm();
    }
    //метод для страницы авторизации
    public function loginForm() {
        return $this->view->render('login');
    }
    //метод для страницы регистрации
    public function registerForm() {
        if (isset($_SESSION['count'])&&$_SESSION['count']!=0) $_SESSION['count'] = 0;
        return $this->view->render('reg');
    }
    //метод для входа на сайт
    public function login() {
        if (!isset($_SESSION['count'])) $_SESSION['count'] = 1;
        if($_SESSION['count']>3) print('bot');
        else {
            $_SESSION['count']++;
            $data=$_POST;
            $data['password']=md5($data['password']);
            $auth=$this->user->find($data);
            if($auth&&is_array($auth)) {
                //устанавливаем куки
                setcookie("TestUser", $auth['login'], time() + 3600);
                //обнуляем счетчик попыток входа
                $_SESSION['count']=0;
                print(json_encode($this->user->find($data)));
            }
            else print('false');
        }
    }
    //метод для выхода из аккаунта
    public function exit() {
        setcookie('TestUser', '');
        return header('Location:/');
    }
    //метод для регистрации на сайте
    public function register() {
        $data=$_POST;
        //проверка данных на пустоту
        foreach($data as $key=>$val){
            if($val==null&&$val=='') {
                print(json_encode(false));
                return;
            }
        }
        //шифрование пароля
        $data['password']=md5($data['password']);
        //вставка записи, вызываем соответствующий метод из объекта модели
        $auth=$this->user->insert($data);
        if($auth=='exists') print('exists');
        elseif($auth&&$auth!='exists'&&is_array($auth)) {
            //устанавливаем куки
            setcookie("TestUser", $auth['login'], time() + 3600);
            print(json_encode($auth));
        }
        else print(json_encode(false));
    }


}

?>