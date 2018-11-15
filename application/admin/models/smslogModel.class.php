<?php
/**
 * Created by PhpStorm.
 * User: lldream
 * Date: 2018/11/14
 * Time: 18:32
 */

class smslogModel extends Model{
    public function __construct()
    {
        parent::__construct("smslog");
    }

    //获取所有的日志
    public function getall($page=0,$limit=10){
        $page = $page==""?0:($page-1);
        $limit= $limit==""?0:$limit;
        return $this->limit($page*$limit,$limit)->all();
    }
    //添加日志
    public function addlog($user,$log,$type)
    {
        $data['user']   = $user;    //手机号
        $data['log']    = $log;     //日志说明
        $data['type']   = isset($type)?$type:"普通";    //发送类型
        $data['dtime']  = date("Y-m-d h:m:s",time());   //添加时间
        
        //var_dump($data);
 
        $this->insert($data);
    }
}