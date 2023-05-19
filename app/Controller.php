<?php
namespace app;
use app\User;
class Controller {

    public $user;
    public $view;
    public function __construct() {
        $this->user=new User;
        $this->view=new View;
    }
    public function show() {
        if(isset($_COOKIE['TestUser'])){
            $auth=$this->user->findByLogin($_COOKIE['TestUser']);
            if(count($auth)>0) return $this->view->render('main',$auth);
        }
        else return $this->loginForm();
    }
    public function loginForm() {
        return $this->view->render('login');
    }
    public function registerForm() {
        return $this->view->render('reg');
    }
    public function login() {
        $data=$_POST;
        $data['password']=md5($data['password']);
        $auth=$this->user->find($data);
        if($auth&&is_array($auth)) {
            setcookie("TestUser", $auth['login'], time() + 3600);
            print(json_encode($this->user->find($data)));
        }
        else print(json_encode(false));
    }
    public function exit() {
        setcookie('TestUser', '');
        return header('Location:/');
    }
    public function register() {
        $data=$_POST;
        $data['password']=md5($data['password']);
        $auth=$this->user->insert($data);
        if($auth=='exists') print('exists');
        elseif($auth&&$auth!='exists'&&is_array($auth)) {
            setcookie("TestUser", $auth['login'], time() + 3600);
            print(json_encode($auth));
        }
        else print(json_encode(false));
    }


}

?>