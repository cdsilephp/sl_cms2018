<?php

class MyException extends Exception
{
    
   public function MysqlConnectException()
    {
        echo "数据库链接失败： ".$this->getTraceAsString();die();
    }
    
    public function SQLException($sql)
    {
        
        echo "SQL出错： ".$sql.$this->getTraceAsString();die();
        
    }
    
}