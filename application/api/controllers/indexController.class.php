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
	   // $this->apisafefilter();

	    $commonClass = $this->common;
	    //处理查询表
	    $t=$this->TablenameFilter($commonClass->Requert("t")  );
	    
	    //处理返回的列名称，用于多表查询
	    $liemingcheng=$this->LiemingchengFilter($commonClass->Requert("liemingcheng"));
	    //返回条数
	    $number=$this->NumberFilter($commonClass->Requert("number") );
	    //当前页数
	    $page=$this->NumberFilter($commonClass->Requert("page") );
	    
	    // 		   ordertype：排序字段，默认已有ID，如不需要排序请为空
	    $ordertype=$commonClass->SafeFilterStr( $commonClass->Requert("ordertype") );
	    // 		   orderby：排序方式，升序和降序
	    $orderby=$commonClass->SafeFilterStr( $commonClass->Requert("orderby") );
	    // 		   sqlvalue：默认查询方式,如果有多个用逗号分隔，“|”会替换成=号
	    $sqlvalue=$this->SqlvalueFilter( $commonClass->Requert("sqlvalue") );
	    // Print 打印测试，如需把sql打印出来，把改成yes，需要显示结果可不传或为空。
	    $print=$commonClass->Requert("print")  ;
	    
	    //拼接为sql语句
	    $_sql=$this->getSql($t,$liemingcheng,$number,$page,$ordertype,$orderby,$sqlvalue);
	    if($print=="yes")
	    {
	        echo $_sql;
	        die();
	    }
	    
	    $temp_model = new Model($t);
	    $temp_arr=$temp_model->findBySql($_sql);
	    //挂载控件类
	    $this->library("Component");
	    $ComponentClass = new Component();
	    $tableModel = new tableModel();
	    $filedModel=new filedModel();
	    $table_id = $tableModel->gettableidBytablename($t);
	    $filedAraay=$filedModel->getallFiledByTableid($table_id);
	    
	    foreach ($filedAraay as $v)
	    {
	        //处理不同字段的显示数据
	        foreach ($temp_arr as $k1=>$v1) {
	            $v1[$v['u1']] =$ComponentClass->showvalueKj($v['u7'],$v['u2'],$v['u1'] ,$v1[$v['u1']],$v['u3'] ,$v['id']) ;
	            $temp_arr[$k1]=$v1;
	        }
	    }
	    $_tableList["data"]=$temp_arr;
	    $_tableList["count"]=$temp_model->total($sqlvalue);
	    
	    returnSuccess($_tableList, "成功",$code=0);
	    
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