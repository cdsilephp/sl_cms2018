<?php
//品牌控制器
class logController extends baseController{
	
	//显示品牌列表
	public function indexAction(){
	     
		include CUR_VIEW_PATH ."Slog".DS."log_list.html";
	}

	//获取管理员列表
	public function getloglistAction(){
	    $logModel = new logModel();
	    $page = $this->common->Get("page");
	    $limit= $this->common->Get("limit");
	    
	    $logList = $logModel->getall($page,$limit);
	    
	    $logList["data"]=$logList;
	    $logList["code"]="0";
	    $logList["msg"]="";
	    $logList["count"]=$logModel->getCountNum();
	    
	    
	    $this->common->ajaxReturn($logList);
	    
	    
	}
	
	
	//定义delete方法，完成品牌的删除
	public function deleteAction(){
		//获取brand_id
		if($_REQUEST['id']=='')
		{
		    $this->jump("index.php?p=admin&c=system&a=index","删除失败，参数不能为空",3);
		}
		$sys_id = $_REQUEST['id'];
		$array_id=explode(",", $sys_id);
		$array_id=array_unique($array_id);
		
		$systemModel = new Model("system");
		if($systemModel->delete($array_id)!="false")
		{
		    $this->jump("index.php?p=admin&c=system&a=index","删除成功",2);
		}
		else 
		{
		    $this->jump("index.php?p=admin&c=system&a=index","删除失败",3);
		}
		
	}
	
}