<?php
//后台管理员控制器
class adminController extends baseController {
	
	//后台首页
	public function indexAction(){
	    
	    
	    
	    include CUR_VIEW_PATH . "Sadmin".DS."admin_list.html";
	}
	
	//获取管理员列表
	public function getadminlistAction(){
	    $adminModel = new adminModel();
	    $adminList = $adminModel->getall();
	    
	    $adminList["data"]=$adminList;
	    $adminList["code"]="0";
	    $adminList["msg"]="";
	    $adminList["count"]=count($adminList["data"]);
	    
	    
	    $this->common->ajaxReturn($adminList);
	    
	    
	}
	
	public function addAction()
	{
	    $groupModel = new Model("group");
	    $group=$groupModel->findBySql("select * from sl_group ");
	    
	    include CUR_VIEW_PATH . "Sadmin" . DS . "admin_add.html";
	}
	
	//载入编辑管理员页面
	public function editAction(){
	    // 先获取品牌信息
	    $adminModel = new adminModel();
	    $groupModel = new Model("group");
	    $group=$groupModel->findBySql("select * from sl_group ");
	    $user_id=$this->common->Get("id");
	    $adminDetail = $adminModel->findOne($user_id);
	    // print_r($adminDetail);
	    include CUR_VIEW_PATH . "Sadmin" . DS . "admin_edit.html";
	}
	
	
	//载入编辑管理员页面
	public function editpasswordAction(){
	    // 先获取品牌信息
	    $adminModel = new adminModel();
	    $user_id=$this->common->Get("id");
	    $adminDetail = $adminModel->findOne($user_id);
	    include CUR_VIEW_PATH . "Sadmin" . DS . "admin_edit_pass.html";
	}
	
	
	//定义insert方法，完成管理员的插入
	public function insertAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    // //获取条件及数据
	    $adminModel = new adminModel();
	    $data = $adminModel->getFieldArray();
	    $data['create_time'] = time();
	    
	    if(empty( $data['username']))
	    {
	        $data["msg"]="用户名不能为空";
	        $this->common->ajaxReturn($data_return);
	    }
	    
	    if(empty( $data['password']))
	    {
	        $data["msg"]="密码不能为空";
	        $this->common->ajaxReturn($data_return);
	    }else
	    { 
	        $data['password']=md5($data['password']);
	    }
	    
	     
	    
	    // 调用模型完成更新
	    $Common = $this->common;
	    $log = new logModel();
	    // var_dump($data);die();
	    if ($adminModel->insert($data)) {
	        // 写入日志
	        $log->addlog($_SESSION['admin']['username'], $_SESSION['admin']['username'] . ":增加用户信息：成功。操作页面:" . $Common->getUrl(), $Common->getIP(), "用户管理");
	        $data_return["status"]=true;
	        $data_return["msg"]="添加成功";
	        $data_return["code"]=0;
	    } else {
	        $log->addlog($_SESSION['admin']['username'], $_SESSION['admin']['username'] . ":增加用户信息：失败。操作页面:" . $Common->getUrl(), $Common->getIP(), "用户管理");
	        $data_return["msg"]="添加失败";
	    }
	    $this->common->ajaxReturn($data_return);
	    
	}
	
	
	//定义update方法，完成管理员的更新
	public function updateAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    // //获取条件及数据
	    $adminModel = new adminModel();
	    $data = $adminModel->getFieldArray();
	    // 调用模型完成更新
	    $Common = $this->common;
	    $log = new logModel();
	    // var_dump($data);die();
	    if ($adminModel->update($data)) {
	        // 写入日志
	        $log->addlog($_SESSION['admin']['username'], $_SESSION['admin']['username'] . ":更改用户信息：成功。操作页面:" . $Common->getUrl(), $Common->getIP(), "用户管理");
	    
	        $data_return["status"]=true;
	        $data_return["msg"]="更新成功";
	        $data_return["code"]=0;
	        
	    } else {
	        $log->addlog($_SESSION['admin']['username'], $_SESSION['admin']['username'] . ":更改用户信息：失败。操作页面:" . $Common->getUrl(), $Common->getIP(), "用户管理");
	        $data_return["msg"]="更新失败";
	    }
	    $this->common->ajaxReturn($data_return);
	    
	}
	
	
	//定义update方法，完成管理员的更新
	public function updatepasswordAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    // //获取条件及数据
	    $adminModel = new adminModel();
	    $data = $adminModel->getFieldArray();
	    $data['new_password'] =$this->common->Get("new_password");
	    
	    $user = $adminModel->checkUser($data['username'], $data['password']);
	    if ($user["status"]) {
	        // 当前密码正确
	        $data['password'] = md5($data['new_password']);
	    } else {
	        $data_return["msg"]="当前密码不正确";
	        $this->common->ajaxReturn($data_return);
	    }
	    
	    
	    // 调用模型完成更新
	    $Common = $this->common;
	    $log = new logModel();
	    // var_dump($data);die();
	    if ($adminModel->update($data)) {
	        // 写入日志
	        $log->addlog($_SESSION['admin']['username'], $_SESSION['admin']['username'] . ":更改用户信息：成功。操作页面:" . $Common->getUrl(), $Common->getIP(), "用户管理");
	        
	        $data_return["status"]=true;
	        $data_return["msg"]="更新成功";
	        $data_return["code"]=0;
	        
	    } else {
	        $log->addlog($_SESSION['admin']['username'], $_SESSION['admin']['username'] . ":更改用户信息：失败。操作页面:" . $Common->getUrl(), $Common->getIP(), "用户管理");
	        $data_return["msg"]="更新失败";
	    }
	    $this->common->ajaxReturn($data_return);
	    
	}
	
	
	//定义delete方法，完成管理员的删除
	public function deleteAction(){
	    //获取admin_id
	    $admin_id = $this->common->Get("id");
	    $adminModel = new adminModel();
	    //得到图片的全路径
	    if ($adminModel->delete($admin_id)){
	        $this->jump("/admin/admin/index","删除成功",0);
	    }else{
	        $this->jump("/admin/admin/index","删除失败",3);
	    }
	}
	
	 
}