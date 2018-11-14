<?php
//核心控制器
class Controller {
     
   public  $common;
    
    //构造方法
    public function __construct(){
       $this->common  = new Common();
    }
    
    
	//跳转方法
	public function jump($url,$message,$wait = 4){
		if ($wait == 0) {
			header("Location:$url");
		} else {
			
		    include_once APP_PATH."admin".DS. "views" .DS. "sys_error.html";
		}
		exit(); //一定要退出 die一样
	}

	//引入工具类模型方法 
	public function library($lib){
	    include_once LIB_PATH . "{$lib}.class.php";
	}
	
	public function library2($lib){
	    include_once LIB_PATH . "{$lib}.php";
	}

	//引入辅助函数方法
	public function helper($helper){
	    include_once HELPER_PATH . "{$helper}.php";
	}
}