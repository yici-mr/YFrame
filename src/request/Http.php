<?php
namespace yframe\request;

class Http
{
    public function receive()
    {
       $method =  Param::Method();
       $param = $method->Data();
       $app = $method->App();
       $Controller =  $method->Controller();
       $Action = $method->Action();
       //下面进行路由
       print_r($method);die;
    }

}