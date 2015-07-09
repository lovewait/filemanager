<?php
class Core{
    public static function init(){
        spl_autoload_register(array(__CLASS__,'autoload'));
        $_POST = self::addslashes_deep($_POST);
        $_GET = self::addslashes_deep($_GET);
        $_COOKIE = self::addslashes_deep($_COOKIE);
        $action = isset($_GET['action']) ? trim($_GET['action']) : 'index';
        $method = isset($_GET['method']) ? trim($_GET['method']) : 'index';
        self::run($action,$method);
    }
    public static function addslashes_deep($arr){
        if(is_numeric($arr) || is_bool($arr) || is_string($arr)){
            return $arr;
        }elseif(is_null($arr)){
            return null;
        }elseif(is_array($arr)){
            foreach($arr as $key => $value){
                $key = self::addslashes_deep($key);
                $arr[$key] = self::addslashes_deep($value);
            }
            return $arr;
        }else{
            trigger_error('传入了错误的数据类型',E_USER_ERROR);
        }
    }
    public static function autoload($class){
        if($class =='Action'){
            require APP_PATH.'/Lib/Action.php';
        }elseif($class == 'Model'){
            require APP_PATH.'/Lib/Model.php';
        }elseif($class == 'View'){
            require APP_PATH.'/Lib/View.php';
        }elseif(substr($class,-6) == 'Action'){
            require APP_PATH.'/Lib/Action/'.$class.'.php';
        }elseif(substr($class,-5) == 'Model'){
            require APP_PATH.'/Lib/Model/'.$class.'.php';
        }else{
//            trigger_error('文件不存在',E_USER_ERROR);
        }
    }

    public static function run($action,$method){
        $action_class = ucfirst($action).'Action';
        $c=new $action_class();
        $c->action_name = $action;
        $c->model_name = $action;
        $c->tpl_name = $method;

        $c->$method();
    }
    public static function GBK2UTF8($str){
        return iconv('GBK','UTF-8',$str);
    }
    public static function UTF82GBK($str){
        return iconv('UTF-8','GBK//TRANSLIT',$str);
    }
}