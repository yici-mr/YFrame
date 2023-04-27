<?php

namespace yframe\library;

class Db extends Link
{

    protected static $table_name;
    protected static $where;
    /**
     * 表名
     * @param $table_name
     * @return void|Db
     */
    public static function name($table_name)
    {
        self::conn()->init();
        self::$table_name = self::$config['prefix'].$table_name;
        return new self();
    }


    /**
     * @param $db_config_name
     * @return Db
     */
    public static function connection($db_config_name)
    {
        self::conn($db_config_name)->init();
        return new self();
    }

    public  function query($sql)
    {
        try {

            if (self::$table_name){
                throw new \Exception('调用函数，不需要指定表名');
            }
            $result = self::$db->conn->query($sql);
            if (!$result){
                throw new \Exception('查询失败');
            }
            $result = $result->fetch_all(MYSQLI_ASSOC);
            self::$db->conn->close();
            return $result;
        }catch (\Exception $e){
            return $e->getMessage();
        }

    }

    /**
     * 查询所有的数据
     * @return string|array
     */
    public function select()
    {
        try {
            $sql = 'select * from '.self::$table_name.self::$where;
            $result = self::$db->conn->query($sql);
            if (!$result){
                throw new \Exception('查询失败');
            }
            $result = $result->fetch_all(MYSQLI_ASSOC);
            self::$db->conn->close();
            return $result;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }
    /**
     * limit
     * @return Db
     */
    public function limit($limit)
    {
        try {
            self::$where .= ' limit '.$limit;
            return $this;
        }
        catch (\Exception $e){
            return $e->getMessage();
        }

    }
    public function where($where)
    {
        try {
            if (!is_string($where)){
                throw new \Exception('参数错误');
            }
            if (self::$where == ''){
                self::$where = ' where ';
            }else{
                self::$where .= ' and ';
            }

            self::$where .= $where;
            return $this;
        }
        catch (\Exception $e){
            return $e->getMessage();
        }

    }

    /**
     * 查询一条数据
     * @return string|array
     */
    public function find()
    {
        try {
            if (self::$where == ''){
                $sql = 'select * from '.self::$table_name.self::$where .' limit 1';
            }else{
                if (strpos(self::$where,'limit') !== false){
                    $sql = 'select * from '.self::$table_name.self::$where;
                }else{
                    $sql = 'select * from '.self::$table_name.self::$where .' limit 1';
                }
            }

            $result = self::$db->conn->query($sql);
            if (!$result){
                throw new \Exception('查询失败');
            }
            $result = $result->fetch_assoc();
            self::$db->conn->close();
            return $result;
        }catch (\Exception $e){
            return $e->getMessage();
        }
    }

}