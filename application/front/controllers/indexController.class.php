<?php
<<<<<<< HEAD
//首页控制器
class indexController extends baseController {
	//首页
	public function indexAction(){

	    $txt="欢迎使用思乐CMS";
	    $this->smarty->assign("txt",$txt);
	    
		if($this->common->is_mobile())
		{
		    $this->smarty->display("m".DS.'index.html');
		}else{
		    $this->smarty->display("defualt".DS.'index.html');
		}
		
	}
=======
//后台基础控制器
class indexController extends baseController {
    
	//验证用户是否登录
	public function indexAction(){
	     
		
	}
	
	 
		
	
>>>>>>> 9157a877a13dc685d06444f889279d43b42412ac
}