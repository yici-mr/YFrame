<?php
namespace yframe\library;
use yframe\library\database\mysql;

class Link
{
    protected static $config;
    protected static $db;
    protected static function conn($db_config_name = '')
    {
        try {
            $path = $_SERVER['DOCUMENT_ROOT'];
            $path = $path.'/app/database.php';
            if (!file_exists($path)){
                throw new \Exception('配置文件不存在');
            }
            $config = include $path;

            //这一段有问题
            if ($db_config_name != ''){
                if (!array_key_exists($db_config_name,$config)){
                    throw new \Exception('配置文件不存在');
                }
                foreach ($config as $key=>$value){
                    if ($key == $db_config_name){
                        $config = $value;
                    }
                }
            }else{
                $config = array_shift($config);
            }



            self::$config = $config;
            self::init();
            return new self();
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    protected static function init()
    {
        switch (self::$config['type']){
            case 'mysql':
                self::$db = new mysql(self::$config['host'],self::$config['user'],self::$config['password'],self::$config['database'],self::$config['port'],self::$config['charset']);

                break;
            case 'sqlite':
                break;
            default:
                break;
        }


    }

}