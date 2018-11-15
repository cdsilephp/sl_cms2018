<?php
/**
 * Created by PhpStorm.
 * User: lldream
 * Date: 2018/11/14
 * Time: 17:52
 */

//挂载账号文件
$GLOBALS['config_account'] = include APP_PATH."admin".DS. "config" .DS. "account.config.php";
//挂载短信记录类
include APP_PATH."admin".DS. "models" .DS. "smslogModel.class.php"; 

const lingkai_code=[
    "-1"=>"账号未注册",
    "-7"=>"提交信息末尾未加签名",
];

class Sms{
   
    
    
    /**
    
    * 凌凯验证码短信方案
    
    * @date: 2018年11月15日 下午4:02:40
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    public function lingkai($tel,$msg,$type="验证码"){
        $uid=$GLOBALS['config_account']['LK_ACCOUNT'];
        $pwd=$GLOBALS['config_account']['LK_PASSWORD'];
        $sign=$GLOBALS['config_account']['LK_SIGN'];
        $re_data["status"]=false;
        $re_data["msg"]="发送失败";
        
        $smslogModel = new smslogModel();
        
        header("Content-type: text/html; charset=gbk2312");
        date_default_timezone_set('PRC');
        
        $message="";
        if($type=="验证码"){
            $code=rand(1000,9999);
            $message=$code;               //验证码
            $_SESSION['yzm'] = $message;            //存session
            $message = "您的验证码为".$message;     //编辑短信内容
            $msg="【{$sign}】".$message;
            $message=$code;//添加签名
        }else{
            $msg="【{$sign}】".$msg;         //添加签名
        }
        
        
        $msg = rawurlencode(mb_convert_encoding($msg, "gb2312", "utf-8"));
        $gateway = "http://mb345.com:999/ws/BatchSend2.aspx?CorpID={$uid}&Pwd={$pwd}&Mobile={$tel}&Content={$msg}&SendTime=&cell=";
        $result = file_get_contents($gateway);
        
        if ($result>0){
            $re_data["status"]=true;
            $re_data["msg"]="信息发送成功";
            if($type=="验证码"){
                $smslogModel->addlog($tel, $message, $type);
            }else{
                $smslogModel->addlog($tel, $re_data["msg"]." 内容：".$message, $type);
            } 
        }else{
            $re_data["msg"]="发送失败:{lingkai_code[$result]}";
            $smslogModel->addlog($tel, $re_data["msg"]." 内容：".$message, $type);
        }
        
        return $re_data;
        
    }

/**

* 阿里短信方案

* @date: 2018年11月15日 下午4:00:36

* @author: 龚华尧

* @param: variable

* @return:

*/
    
    public function ali($tel,$msg,$type="验证码"){
        $uid=$GLOBALS['config_account']['LK_ACCOUNT'];
        $pwd=$GLOBALS['config_account']['LK_PASSWORD'];
        $sign=$GLOBALS['config_account']['LK_SIGN'];
        $re_data["status"]=false;
        $re_data["msg"]="发送失败";
        
        $smslogModel = new smslogModel();
        
        header("Content-type: text/html; charset=gbk2312");
        date_default_timezone_set('PRC');
        
        $message="";
        if($type=="验证码"){
            $message=rand(1000,9999);               //验证码
            $_SESSION['yzm'] = $message;            //存session
            $message = "您的验证码为".$message;     //编辑短信内容
            $msg="【{$sign}】".$message;         //添加签名
        }else{
            $msg="【{$sign}】".$msg;         //添加签名
        }
        
        
        $msg = rawurlencode(mb_convert_encoding($msg, "gb2312", "utf-8"));
        $gateway = "http://mb345.com:999/ws/BatchSend2.aspx?CorpID={$uid}&Pwd={$pwd}&Mobile={$tel}&Content={$msg}&SendTime=&cell=";
        $result = file_get_contents($gateway);
        
        if ($result>0){
            $re_data["status"]=true;
            $re_data["msg"]="信息发送成功";
            $smslogModel->addlog($tel, $re_data["msg"]." 内容：".$message, $type);
        }else{
            $re_data["msg"]="发送失败:{lingkai_code[$result]}";
            $smslogModel->addlog($tel, $re_data["msg"]." 内容：".$message, $type);
        }
        
        return $re_data;
        
    }

}