<?php
namespace app;
use app\Config;
use PDO;
//класс-модель для работы с БД
class User{
    protected $connection;
    protected $table;
//в конструкторе определяем название таблицы и реквизиты для подключения к БД
    public function __construct(){
        $this->table='users';
        $this->connection=new PDO(
            'mysql:
            host='.Config::DB_CREDENTIALS['host'].';
            dbname='.Config::DB_CREDENTIALS['dbname'],
            Config::DB_CREDENTIALS['user'],
            Config::DB_CREDENTIALS['password']
        );
    }
//метод для получения всех записей из таблицы
    public function get()
    {
        try {
            $result=$this->connection->query('SELECT * from '.$this->table)->fetchAll(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }
//метод для поиска по логину, например если есть уже куки
    public function findByLogin($login)
    {
        try {
            $result=$this->connection->query("SELECT * from ".$this->table." WHERE login='".$login."'")->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }
//метод для поиска по логину и паролю
    public function find($data)
    {
        try {
            $result=$this->connection->query("SELECT * from ".$this->table." WHERE login='".$data['login']."' AND password='".$data['password']."'")->fetch(PDO::FETCH_ASSOC);
            return $result;
        } catch (PDOException $e) {
            print "Error!: " . $e->getMessage() . "<br/>";
            die();
        }

    }
//метод для вставки записи
    public function insert($data)
    {
        if($this->findByLogin($data['login'])) return 'exists';
        else{
            $sql="INSERT into users (login,name,password) VALUES ('".$data['login']."','".$data['name']."','".$data['password']."')";
            try {
                $result=$this->connection->query($sql);
                return $this->findByLogin($data['login']);
            } catch (PDOException $e) {
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        }
    }


}

?>