<?php

namespace yframe\request;


class Param
{
    protected static $Method;

    /**
     * 判断是否为GET请求
     * @return mixed
     */
    public  function isGet(){
        if (self::$Method == 'GET'){
            return true;
        }else{
            return false;
        }
    }

    /**
     * 判断是否为POST请求
     * @return mixed
     */
    public  function isPost(){
        if (self::$Method == 'POST'){
            return true;
        }else{
            return false;
        }
    }





    /**
     * 获取请求方式
     * @return mixed
     */
    public static function Method()
    {
        self::$Method = $_SERVER['REQUEST_METHOD'];
        return new self();
    }

    /**
     * 获取当前应用
     * @return mixed
     */
    public static function App(){
        $app = $_SERVER['REQUEST_URI'];
        $app = explode('/',$app);
        return $app[1];
    }

    /**
     * 获取当前控制器
     * @return mixed
     */
    public static function Controller(){
        $app = $_SERVER['REQUEST_URI'];
        $app = explode('/',$app);
        return $app[2];
    }

    /**
     * 获取当前方法
     * @return mixed
     */
    public static function Action()
    {
        $app = $_SERVER['REQUEST_URI'];
        $app = explode('/', $app);
        return $app[3];
    }

    /**
     * 获取请求参数
     * @return mixed
     */
    public function Data()
    {
        $param = $_SERVER['REQUEST_URI'];
        $param = explode('/', $param);
        $params = array();
        if (array_key_exists(4,$param))
        {
            for ($i = 4; $i < count($param); $i += 2) {
                if (isset($param[$i+1])) {
                    $params[$param[$i]] = $param[$i+1];
                }
            }
            $Q = json_decode(file_get_contents('php://input'),true);
            if(!$Q){
                $Q = [];
            }
            $params = array_merge($params,$Q);
            return $params;

        }else{
            return null;
        }
    }
}