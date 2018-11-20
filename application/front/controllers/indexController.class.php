<?php
class indexController extends baseController {
	//首页
	public function indexAction(){

	    $txt="欢迎使用思乐CMS";
	    $this->smarty->assign("txt",$txt);
	    
	    
	    $this->library("Sms");
	    $Sms = new Sms();
	    $Sms->lingkai("13320668037", "","验证码");
	    
		if($this->common->is_mobile())
		{
		    $this->smarty->display("m".DS.'index.html');
		}else{
		    $this->smarty->display("defualt".DS.'index.html');
		}
		
	}
}