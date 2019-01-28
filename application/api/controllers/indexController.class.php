<?php
class indexController extends baseController {
	//首页
	public function indexAction(){

	     
		
	}
	
	/**
	
	* 统一查询方法
	
	* @date: 2019年1月28日 下午2:53:06
	
	* @author: 龚华尧
	
	* @param: variable
	
	* @return:
	
	*/
	public function searchAction(){
	    //验证签名开始
	    $token = $this->common->Requert("token");
	    $sign= $this->common->Requert("sign");
	    $check_tokendata = checktoken($token);
	    if(!$check_tokendata['status']){
	        returnSuccess($check_tokendata['status'], $check_tokendata['msg'] ,$code=2003);
	    }
	    
	    //token验证通过后，验证签名是否正确

	    getsign();
	    $check_signdata = checksign($sign);
	    if(!$check_signdata['status']){
	        returnSuccess($check_signdata['status'], $check_signdata['msg'] ,$code=2004);
	    }
	    
	    //验证签名结束
	    
	}
	
	
	
	/**
	
	* 获取token
	
	* @date: 2019年1月22日 下午6:57:31
	
	* @author: 龚华尧
	
	* @param: variable
	
	* @return:
	
	*/
	public function gettokenAction(){
	    $appkey= $this->appkey;
	    $time = time() + $this->tokentime;
	    $data["appkey"] = $appkey;
	    $data["time"] = $time;
	    //echo serialize($data);die();
	    $token = $this->common->encryptByqingmiphp(serialize($data));
	    returnSuccess($token, $this->getcodestr(2001),$code=0);
	    
	}
	
	
}