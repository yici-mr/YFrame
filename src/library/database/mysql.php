<?php

namespace yframe\library\database;

class mysql
{

    public function __construct($host, $user, $password, $database, $port = 3306, $charset = 'utf8')
    {
        try {
            $this->conn = mysqli_connect($host,$user,$password,$database,$port);
            if ($this->conn->connect_error){
                throw new \Exception('数据库连接失败');
            }
            if (!mysqli_select_db($this->conn,$database)){
                mysqli_close($this->conn);
                throw new \Exception('数据库不存在');
            }

            mysqli_set_charset($this->conn,$charset);

        }catch (\Exception $e){
            return $e->getMessage();
        }
    }



}