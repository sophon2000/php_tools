<?php 
/**
 * 控制反转(对组件对象控制权的转移，从程序代码本身转移到了外部容器。)
 */

// 传统工厂方法
//---------------------------------------------------------
class Factory {
    public static function getDb(){
        include "./Lib/Db.php";
        return new Db("localhost","root","123456","test");
    }
}

class example {
    private $_db;
    function __construct(){
        $this->_db = Factory::getDb();
    }
    function getList(){
        $this->_db->query("......");//这里具体sql语句就省略不写了
    }
}

// 依赖注入工厂方法
//---------------------------------------------------------
class example {
    private $_db;
    function getList(){
        $this->_db->query("......");
        //这里具体sql语句就省略不写了
    }
    //从外部注入db连接
    function setDb($connection){
        $this->_db = $connection;
    }
}

class Factory {
    public static function getExample(){
        $example = new example();
        //注入db连接
        $example->setDb(Factory::getDb());
        //注入文件处理类
        $example->setFile(Factory::getFile());
        //注入Image处理类
        $example->setImage(Factory::getImage());
        return $expample;
    }
}

$example=Factory::getExample();
$example->getList();

// 优化版依赖注入
//---------------------------------------------------------

class example {
    private $_di;
    function __construct(Di &$di){
        $this->_di = $di;
    }
    //通过di容器获取db实例
    function getList(){
        $this->_di->get('db')->query("......");//这里具体sql语句就省略不写了
    }
 }
$di = new Di();
$di->set("db",function(){
        return new Db("localhost","root","root","test");
    });
$example = new example($di);
$example->getList();