<?php
//参数控制器
class sortController extends baseController{
	
	//显示参数列表
	public function indexAction(){
	    $Common = $this->common;
	    $sortModel = new sortModel();
	    $classid = $Common->Get('classid');
	    $classid = $classid==""?"0":$classid;
	    $classidArray = $sortModel->getsortByclassid("");
	    
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    
	     
	    $str = "<tr>
        <td>\$u4</td>
        <td>\$classid</td>
        <td>\$id</td>
        <td>\$spacer  \$u1</td>
        <td>\$u5</td>
        <td>
            <a title='增加分类' data-href='/admin/sort/add?id=\$id' data-title='增加分类'   class='layui-btn layui-btn-xs layui-btn-primary sort_anniu'>增加子类</a>
            <a title='编辑分类' data-href='/admin/sort/edit?id=\$id' data-title='编辑分类'  class='layui-btn layui-btn-xs layui-btn-primary sort_anniu'>编辑</a>
            <a title='删除' data-href='/admin/sort/delete?id=\$id'  data-title='删除'  class='layui-btn layui-btn-xs layui-btn-primary sort_anniu'>删除</a></td>
        </tr>";
	    
	    
	    $html='';
	    $html .= $tree->get_tree($classid,$str,-1);
		
		include CUR_VIEW_PATH."Ssort".DS.  "sort_list.html";
	}
	
	
	public function getsortlistAction(){
	    //先获取用户组信息
	    $sortModel = new sortModel();
	    $sortList = $sortModel->getall();
	    
	    $sortList["data"]=$sortList;
	    $sortList["code"]="0";
	    $sortList["msg"]="";
	    $sortList["count"]=count($sortList["data"]);
	    
	    $this->common->ajaxReturn($sortList);
	}
	
	 

	//载入添加参数页面
	public function addAction(){
	    $sortModel = new sortModel();
	    $classidArray = $sortModel->getsortByclassid("");
	    $classid = $this->common->Get("id");
	    $classid = $classid==""?"0":$classid;
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
	    $html_option='';
	    $html_option .= $tree->get_tree(0,$str,$classid);
	    
	    
	    include CUR_VIEW_PATH ."Ssort".DS. "sort_add.html";
	}

	//载入编辑参数页面
	public function editAction(){
		 //获取该模型信息
	    $sortModel = new sortModel();
	    $classidArray = $sortModel->getsortByclassid("");
	    //条件
	    $id = $this->common->Get("id");
	    //使用模型获取
	    $sortdetail = $sortModel->findOne($id);

	    $classid = $sortdetail['classid'];
	    $classid = $classid==""?"0":$classid;
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
	    $html_option='';
	    $html_option .= $tree->get_tree(0,$str,$classid);
	    
		include CUR_VIEW_PATH ."Ssort".DS. "sort_edit.html";
	}

	//定义insert方法，完成参数的插入
	public function insertAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $sortModel = new  sortModel();
	    //1.收集表单数据
	    $data=$sortModel->getFieldArray();
	    //2.验证和处理
	    
	    
	    if ($sortModel->insert($data)) {
	        //4.创建数据表
	        $data_return["status"]=true;
	        $data_return["msg"]="添加成功";
	        $data_return["code"]=0;
	        
	    } else {
	        $data_return["msg"]="添加失败";
	    }
	    $this->common->ajaxReturn($data_return);
	    
	}

	//定义update方法，完成参数的更新
	public function updateAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $sortModel = new  sortModel();
	    //1.收集表单数据
	    $data=$sortModel->getFieldArray();
	    //2.验证和处理
	    
		//调用模型完成更新
		
		if($sortModel->update($data)){
		    $data_return["status"]=true;
		    $data_return["msg"]="更新成功";
		    $data_return["code"]=0;
		}else{
		    $data_return["msg"]="更新失败";
		}
		$this->common->ajaxReturn($data_return);
	}

	//定义delete方法，完成参数的删除
	public function deleteAction(){
	   //获取sort_id
	    $sort_id = $this->common->Get('id');
		$sortModel = new sortModel();
		
		if ($sortModel->delete($sort_id)){ 
			    $this->jump("/admin/sort/index","删除成功",0);
		}else{
			$this->jump("/admin/sort/index","删除失败",3);
		}
		
	}
}