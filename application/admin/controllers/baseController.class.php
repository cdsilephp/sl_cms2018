<?php
//后台基础控制器
class baseController extends Controller {
    public  $common;
	//构造方法
	public function __construct(){
	    @header('Content-type: text/html;charset=UTF-8');
	    
	    if(CONTROLLER!="autotable" && CONTROLLER!="install")
	    {
	        $this->checkLogin();
	    }
		
		
		
		$this->common = new Common();
	}
	
	//验证用户是否登录
	public function checkLogin(){
	    //var_dump($_SESSION['admin']);die();
	    //注意，此处的admin是我在登录成功时保存的登录标识符
	    if (!isset($_SESSION['admin'])) {
	        $this->jump('/admin/login/login','你还没有登录呢');
	    }

		
	}
	
	
	
}