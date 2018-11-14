<?php
/**
 * Created by PhpStorm.
 * User: lldream
 * Date: 2018/11/14
 * Time: 17:52
 */

class Sms{
    //凌凯验证码短信
    public function lkSmsYzm($uid,$pwd,$tel,$sign = ""){
        header("Content-type: text/html; charset=gbk2312");
        date_default_timezone_set('PRC');
        $message=rand(1000,9999);               //验证码
        $_SESSION[$tel] = $message;             //存session
        $message = "您的验证码为".$message;     //编辑短信内容
        $msg = $message.$sign;                  //添加签名
        $msg = rawurlencode(mb_convert_encoding($msg, "gb2312", "utf-8"));
        $gateway = "http://mb345.com:999/ws/BatchSend2.aspx?CorpID={$uid}&Pwd={$pwd}&Mobile={$tel}&Content={$msg}&SendTime=&cell=";
        $result = file_get_contents($gateway);
        if ($result>0){
            echo json_encode(['code'=>200,'msg'=>'信息发送成功','data'=>[]]);
        }else{
            echo json_encode(['code'=>500,'msg'=>$result,'data'=>[]]);
        }
    }
}