<?php
namespace yframe\request;
class Route
{
    protected static $route = [
        '/'=>'/index/index/index',
        '/index'=>'/index/index/index',
        '/index/'=>'/index/index/index',
        '/index/index'=>'/index/index/index',
        '/index/index/'=>'/index/index/index',
    ];

    public function __construct()
    {
        try {
            if (array_key_exists($_SERVER['REQUEST_URI'], self::$route)) {
                //默认路由
                $_SERVER['REQUEST_URI'] = self::$route[$_SERVER['REQUEST_URI']];
            }
//            else{
//                $app = $this->App();
//
//                if (!file_exists(__DIR__.'/../../app/'.$app)) {
//                    throw new \Exception('应用不存在');
//                }
//                $Controller =  $this->Controller();
//                if (!file_exists(__DIR__.'/../../app/'.$app.'/controller/'.$Controller.'.php')){
//                    throw new \Exception('控制器不存在');
//                }
//
//            }
            $this->visit();
        }
        catch (\Exception $e){
            return $e->getMessage();
        }
    }
    protected function visit()
    {
        try {
            $app = $this->App();
            $Controller =  $this->Controller();
            $Controller = ucfirst($Controller);
            $Action = $this->Action();
            $param = $this->Data();
            $class = 'app\\'.$app.'\\controller\\'.$Controller;

            $class = new $class();
            $class->$Action($param);
        }
        catch (\Throwable $e){
            return $e->getMessage();
        }

    }

}