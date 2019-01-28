<?php
//后台基础控制器
class baseController extends Controller {
    public  $common;
    public  $smarty;
    public  $templates;
    public  $appkey;
    public  $signstate;
    public  $tokentime ;//token有效时间 20分钟
    
	//构造方法
	public function __construct(){ 
	    $this->appkey=$GLOBALS['config_api']['appkey'];
	    $this->signstate=$GLOBALS['config_api']['signstate'];
	    $this->tokentime=$GLOBALS['config_api']['tokentime'];
	    $this->common = new Common();
	}
	
	public function getcodestr($id) {
	    return $GLOBALS['config_code'][$id];
	}
	
}