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
    public function addlog($user,$log,$code,$dtame)
    {
        $data['user']   = $user;    //手机号
        $data['log']    = $log;     //日志说明
        $data['code']   = $code;    //验证码
        $data['dtime']  = $dtame;   //添加时间

        //2.验证和处理
        $this->helper("input");

        $data = deepspecialchars($data);
        $data = deepslashes($data);

        $this->insert($data);
    }
}