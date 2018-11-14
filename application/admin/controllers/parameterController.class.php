<?php
//参数控制器
class parameterController extends baseController{
	
	//显示参数列表
	public function indexAction(){
	    $Common = $this->common;
	    $parameterModel = new parameterModel('parameter');
	    $classid = $Common->Get('classid');
	    $classid = $classid==""?"0":$classid;
	    $classidArray = $parameterModel->getparameterByclassid("");
	    
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    
	     
	    $str = "<tr>
        <td>\$u4</td>
        <td>\$classid</td>
        <td>\$id</td>
        <td>\$spacer  \$u1</td>
        <td>\$u2</td>
        <td>
            <a title='增加参数' data-href='/admin/parameter/add?id=\$id' data-title='增加参数'   class='layui-btn layui-btn-xs layui-btn-primary parameter_anniu'>增加子类</a>
            <a title='编辑参数' data-href='/admin/parameter/edit?id=\$id' data-title='编辑参数'  class='layui-btn layui-btn-xs layui-btn-primary parameter_anniu'>编辑</a>
            <a title='删除' data-href='/admin/parameter/delete?id=\$id'  data-title='删除'  class='layui-btn layui-btn-xs layui-btn-primary parameter_anniu'>删除</a></td>
        </tr>";
	    
	    
	    $html='';
	    $html .= $tree->get_tree($classid,$str,-1);
		
		include CUR_VIEW_PATH."Sparameter".DS.  "parameter_list.html";
	}
	
	
	public function getparameterlistAction(){
	    //先获取用户组信息
	    $parameterModel = new parameterModel();
	    $parameterList = $parameterModel->getall();
	    
	    $parameterList["data"]=$parameterList;
	    $parameterList["code"]="0";
	    $parameterList["msg"]="";
	    $parameterList["count"]=count($parameterList["data"]);
	    
	    $this->common->ajaxReturn($parameterList);
	}
	
	 

	//载入添加参数页面
	public function addAction(){
	    $parameterModel = new parameterModel();
	    $classidArray = $parameterModel->getparameterByclassid("");
	    $classid = $this->common->Get("id");
	    $classid = $classid==""?"0":$classid;
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
	    $html_option='';
	    $html_option .= $tree->get_tree(0,$str,$classid);
	    
	    
	    include CUR_VIEW_PATH ."Sparameter".DS. "parameter_add.html";
	}

	//载入编辑参数页面
	public function editAction(){
		 //获取该模型信息
	    $parameterModel = new parameterModel();
	    $classidArray = $parameterModel->getparameterByclassid("");
	    //条件
	    $id = $this->common->Get("id");
	    //使用模型获取
	    $parameterdetail = $parameterModel->findOne($id);

	    $classid = $parameterdetail['classid'];
	    $classid = $classid==""?"0":$classid;
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
	    $html_option='';
	    $html_option .= $tree->get_tree(0,$str,$classid);
	    
		include CUR_VIEW_PATH ."Sparameter".DS. "parameter_edit.html";
	}

	//定义insert方法，完成参数的插入
	public function insertAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $parameterModel = new  parameterModel();
	    //1.收集表单数据
	    $data=$parameterModel->getFieldArray();
	    //2.验证和处理
	    
	    
	    if ($parameterModel->insert($data)) {
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
	    
	    $parameterModel = new  parameterModel();
	    //1.收集表单数据
	    $data=$parameterModel->getFieldArray();
	    //2.验证和处理
	    
		//调用模型完成更新
		
		if($parameterModel->update($data)){
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
	   //获取parameter_id
	    $parameter_id = $this->common->Get('id');
		$parameterModel = new parameterModel();
		
		if ($parameterModel->delete($parameter_id)){ 
			    $this->jump("/admin/parameter/index","删除成功",0);
		}else{
			$this->jump("/admin/parameter/index","删除失败",3);
		}
		
	}
}