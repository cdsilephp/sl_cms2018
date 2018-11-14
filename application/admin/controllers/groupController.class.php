<?php
//用户组控制器
class groupController extends baseController{
	
	//显示用户组列表
	public function indexAction(){
		//先获取用户组信息
		 
		include CUR_VIEW_PATH . "Sgroup".DS."group_list.html";
	}
	
	public function getgrouplistAction(){
	    //先获取用户组信息
	    $groupModel = new groupModel();
	    $groupList = $groupModel->getall();
	    
	    $groupList["data"]=$groupList;
	    $groupList["code"]="0";
	    $groupList["msg"]="";
	    $groupList["count"]=count($groupList["data"]);
	    
	    $this->common->ajaxReturn($groupList);
	}

	//载入添加用户组页面
	public function addAction(){
	    //记录单选框的数量
	    $che_list=0;
	    $menuModel = new menuModel();
	    $classidArray=$menuModel->getmenuByclassid("");
	    $menuList= $menuModel->tree($classidArray);
	    //var_dump($lanmu);
	    include CUR_VIEW_PATH . "Sgroup".DS."group_add.html";
	}

	//载入编辑用户组页面
	public function editAction(){
	    //记录单选框的数量
	    $che_list=0;
	    //获取该用户组信息
	    $groupModel = new groupModel();
	    //条件
	    $group_id = $this->common->Get('id');  
	    
	    //使用模型获取
	    $group = $groupModel->findOne($group_id);
	    
	    $menu_groupModel = new menugroupModel();
	    //记录单选框的数量
	    $menuModel = new menuModel();
	    $classidArray=$menuModel->getmenuByclassid("");
	    
	   //查询栏目是否已经选择
	    foreach($classidArray as $k=>$v)
	    {
	        $classidArray[$k]["checked"]="false";
	        $data2["id"]=$v["id"];
	        $data2["group_id"]=$group_id;
	        if(count($menu_groupModel->where( $data2)->all())>0)
	        {
	            $classidArray[$k]["checked"]="true";
	        }
	        
	    }
	    $menuList= $menuModel->tree($classidArray);
	    
		// var_dump($group);
		include CUR_VIEW_PATH . "Sgroup".DS."group_edit.html";
	}

	//定义insert方法，完成用户组的插入
	public function insertAction(){
	    //获取该用户组信息
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $Common = $this->common;
	    $groupModel = new groupModel();
	    $menu_groupModel = new menugroupModel();
	    $menuModel = new menuModel();
		//接受表单提交过来的数据
	    $col_id =$Common->Requert("colid") ;
		// 1.收集表单数据
		$data = $groupModel->getFieldArray();
		
		$group_id=$groupModel->insert($data);
		if ($group_id){
		    //写入另外权限操作表
		    foreach ($col_id as $v ){
		         
		        $menudetail = $menuModel->findOne($v);
		        $menudetail["laiyuan"]=$_SESSION["admin"]["username"];
		        $menudetail["group_id"]=$group_id;
		        $menu_groupModel->insert($menudetail);
		        
		    }
		    //添加成功
		    $data_return["msg"]="添加用户组成功";
		    $data_return["status"]=true;
		    $data_return["code"]=0;
		}else {//添加失败
		    $data_return["msg"]="添加用户组失败";
		    
		}

		$Common->ajaxReturn($data_return);
		
	}

	//定义update方法，完成用户组的更新
	public function updateAction(){
	    
	    //获取该用户组信息
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $Common = $this->common;
	    $groupModel = new groupModel();
	    $menu_groupModel = new menugroupModel();
	    $menuModel = new menuModel();
	    //接受表单提交过来的数据
	    $col_id =$Common->Requert("colid") ;
	    $group_id = $Common->Get("id");
	    // 1.收集表单数据
	    $data = $groupModel->getFieldArray();
	    
	    $groupModel->update($data);
	    
	    //删除用户组原有数据
	    $menu_groupModel->where(["group_id"=>$group_id])->delete();
	    
	    if ($group_id){
	        //写入另外权限操作表
	        foreach ($col_id as $v ){
	            
	            $menudetail = $menuModel->findOne($v);
	            $menudetail["laiyuan"]=$_SESSION["admin"]["username"];
	            $menudetail["group_id"]=$group_id;
	            $menu_groupModel->insert($menudetail);
	            
	        }
	        //添加成功
	        $data_return["msg"]="添加用户组成功";
	        $data_return["status"]=true;
	        $data_return["code"]=0;
	    }else {//添加失败
	        $data_return["msg"]="添加用户组失败";
	        
	    }
	    
	    $Common->ajaxReturn($data_return);
	    
	}

	//定义delete方法，完成用户组的删除
	public function deleteAction(){
		//获取group_id
		$group_id = $this->common->Get("id");
		$groupModel = new groupModel();
		
		if ($groupModel->delete($group_id)){
		    $menu_groupModel = new menugroupModel();
		    $menu_groupModel->where(["group_id"=>$group_id])->delete();
			$this->jump("/admin/group/index","删除成功",0);
		}else{
			$this->jump("/admin/group/index","删除失败",3);
		}
	}
}