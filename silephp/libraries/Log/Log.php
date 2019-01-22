<?php
/**
 * Created by PhpStorm. composer 自动加载
 * User: cdsile
 * Date: 2018/11/22
 * Time: 14:59
 */
class Log
{
    protected static $stack = "wechat";
    private static $instace;# Log对象实例
    private $title;

    /**
     * 获取实例
     */
    public static function getInstace()
    {
        if(!(self::$instace instanceof self)) {
            self::$instace = new Log();
        };
        return self::$instace;
    }
    /**
     * 获取数据
     * @param $param
     */
    public function get($param)
    {
        
    }

    /**
     * 数据存储
     * @param $param
     */
    public  function set($param,$filename='default.log')
    {
        $dir = self::$stack;
        $file = APP_LOG."\\$dir\\".$filename;

        # 读写方式打开, 文件不存在就尝试创建
        $handle = fopen($file, 'a+');
        $time = date('Y-m-d H:i:s');
        $str = "【{$time}】【 {$this->title}】".json_encode($param)."\t\r";

        fwrite($handle,$str);

        return self::getInstace();
    }
    /**
     * 数据存储
     * @param $param
     */
    public  function error($param)
    {
        $filename='error.log';
        $dir = self::$stack;
        $file = APP_LOG."\\$dir\\".$filename;

        # 读写方式打开, 文件不存在就尝试创建
        $handle = fopen($file, 'a+');
        $time = date('Y-m-d H:i:s');
        $str = "【{$time}】【 {$this->title}】".json_encode($param)."\t\r";

        fwrite($handle,$str);

        return self::getInstace();
    }
    /**
     * 数据存储
     * @param $param
     */
    public  function info(...$param)
    {

        $filename='info.log';
        $dir = self::$stack;
        $file = APP_LOG."\\$dir\\".$filename;

        # 读写方式打开, 文件不存在就尝试创建
        $handle = fopen($file, 'a+');
        $time = date('Y-m-d H:i:s');
        $str = "【{$time}】【 {$this->title}】".json_encode($param)."\t\r";

        fwrite($handle,$str);

        return self::getInstace();
    }
    /**
     * 数据存储
     * @param $param
     */
    public  function waring($param)
    {
        $filename='waring.log';
        $dir = self::$stack;
        $file = APP_LOG."\\$dir\\".$filename;

        # 读写方式打开, 文件不存在就尝试创建
        $handle = fopen($file, 'a+');

        $time = date('Y-m-d H:i:s');
        $str = "【{$time}】【 {$this->title}】".json_encode($param)."\t\r";

        fwrite($handle,$str);

        return self::getInstace();
    }

    /**
     * 通道
     */
    public static function channel($stack)
    {
        self::$stack = $stack;
        $dir = APP_LOG."\\$stack\\";
        is_dir( $dir)?:mkdir($dir);
        return self::getInstace();
    }
    /**
     * title notice 每条日志的头
     */
    public function setTitle($title)
    {
        $this->title = $title;
        return self::getInstace();
    }
}