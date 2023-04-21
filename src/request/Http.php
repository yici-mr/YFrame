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
    }

}