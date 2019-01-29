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
 	    //接口安全验证开始
	    $this->apisafefilter();

	    //处理返回的列名称，用于多表查询
	    $liemingcheng=$this->LiemingchengFilter($_GET["liemingcheng"]);
	    //返回条数
	    $number=$this->NumberFilter($_GET["number"]);
	    //当前页数
	    $page=$this->NumberFilter($_GET["page"]);
	    
	    // 		   ordertype：排序字段，默认已有ID，如不需要排序请为空
	    $ordertype=$commonClass->SafeFilterStr($_GET["ordertype"]);
	    // 		   orderby：排序方式，升序和降序
	    $orderby=$commonClass->SafeFilterStr($_GET["orderby"]);
	    // 		   sqlvalue：默认查询方式,如果有多个用逗号分隔，“|”会替换成=号
	    $sqlvalue=$this->SqlvalueFilter($_GET["sqlvalue"]);
	    
	    
	    //拼接为sql语句
	    $_sql=$this->getSql($t,$liemingcheng,$number,$page,$ordertype,$orderby,$sqlvalue);
	    if($print=="yes")
	    {
	        echo $_sql;
	        die();
	    }
	    $temp_model = new Model("moxing");
	    $temp_arr=$temp_model->select($_sql);
	    //单独处理时间的格式
	    foreach ($temp_arr as $k=>$v)
	    {
	        if($temp_arr[$k]["dtime"]!=null)
	        {
	            $temp_arr[$k]["dtime"]=$commonClass->formatTime($v["dtime"]);
	            $temp_arr[$k]["dtime1"]=$v["dtime"];
	        }
	        
	        //echo $temp_arr[$k]["dtime"];
	    }
	    
	    $rdata['msg']=json_encode($temp_arr);
	   
	    
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