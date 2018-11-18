<?php
//规格控制器
class goodsparameterController extends baseController{
	
	//显示规格列表
	public function indexAction(){
	    $Common = $this->common;
	    $goodsparameterModel = new goodsparameterModel('goodsparameter');
	    $classid = $Common->Get('classid');
	    $classid = $classid==""?"0":$classid;
	    $classidArray = $goodsparameterModel->getgoodsparameterByclassid("");
	    
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    
	     
	    $str = "<tr>
        <td>\$u4</td>
        <td>\$id</td>
        <td>\$spacer  \$u1</td>
        <td>\$u2</td>
        <td>
            <a title='增加规格' data-href='/admin/goodsparameter/add?id=\$id' data-title='增加规格'   class='layui-btn layui-btn-xs layui-btn-primary goodsparameter_anniu'>增加子类</a>
            <a title='编辑规格' data-href='/admin/goodsparameter/edit?id=\$id' data-title='编辑规格'  class='layui-btn layui-btn-xs layui-btn-primary goodsparameter_anniu'>编辑</a>
            <a title='删除' data-href='/admin/goodsparameter/delete?id=\$id'  data-title='删除'  class='layui-btn layui-btn-xs layui-btn-primary goodsparameter_anniu'>删除</a></td>
        </tr>";
	    
	    
	    $html='';
	    $html .= $tree->get_tree($classid,$str,-1);
		
		include CUR_VIEW_PATH."Sgoodsparameter".DS.  "goodsparameter_list.html";
	}
	
	
	public function getgoodsparameterlistAction(){
	    //先获取用户组信息
	    $goodsparameterModel = new goodsparameterModel();
	    $goodsparameterList = $goodsparameterModel->getall();
	    
	    $goodsparameterList["data"]=$goodsparameterList;
	    $goodsparameterList["code"]="0";
	    $goodsparameterList["msg"]="";
	    $goodsparameterList["count"]=count($goodsparameterList["data"]);
	    
	    $this->common->ajaxReturn($goodsparameterList);
	}
	
	 

	//载入添加规格页面
	public function addAction(){
	    $goodsparameterModel = new goodsparameterModel();
	    $classidArray = $goodsparameterModel->getgoodsparameterByclassid("");
	    $classid = $this->common->Get("id");
	    $classid = $classid==""?"0":$classid;
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
	    $html_option='';
	    $html_option .= $tree->get_tree(0,$str,$classid);
	    
	    
	    include CUR_VIEW_PATH ."Sgoodsparameter".DS. "goodsparameter_add.html";
	}

	//载入编辑规格页面
	public function editAction(){
		 //获取该模型信息
	    $goodsparameterModel = new goodsparameterModel();
	    $classidArray = $goodsparameterModel->getgoodsparameterByclassid("");
	    //条件
	    $id = $this->common->Get("id");
	    //使用模型获取
	    $goodsparameterdetail = $goodsparameterModel->findOne($id);

	    $classid = $goodsparameterdetail['classid'];
	    $classid = $classid==""?"0":$classid;
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
	    $html_option='';
	    $html_option .= $tree->get_tree(0,$str,$classid);
	    
		include CUR_VIEW_PATH ."Sgoodsparameter".DS. "goodsparameter_edit.html";
	}

	//定义insert方法，完成规格的插入
	public function insertAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $goodsparameterModel = new  goodsparameterModel();
	    //1.收集表单数据
	    $data=$goodsparameterModel->getFieldArray();
	    //2.验证和处理
	    
	    
	    if ($goodsparameterModel->insert($data)) {
	        //4.创建数据表
	        $data_return["status"]=true;
	        $data_return["msg"]="添加成功";
	        $data_return["code"]=0;
	        
	    } else {
	        $data_return["msg"]="添加失败";
	    }
	    $this->common->ajaxReturn($data_return);
	    
	}

	//定义update方法，完成规格的更新
	public function updateAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $goodsparameterModel = new  goodsparameterModel();
	    //1.收集表单数据
	    $data=$goodsparameterModel->getFieldArray();
	    //2.验证和处理
	    
		//调用模型完成更新
		
		if($goodsparameterModel->update($data)){
		    $data_return["status"]=true;
		    $data_return["msg"]="更新成功";
		    $data_return["code"]=0;
		}else{
		    $data_return["msg"]="更新失败";
		}
		$this->common->ajaxReturn($data_return);
	}

	//定义delete方法，完成规格的删除
	public function deleteAction(){
	   //获取goodsparameter_id
	    $goodsparameter_id = $this->common->Get('id');
		$goodsparameterModel = new goodsparameterModel();
		
		if ($goodsparameterModel->delete($goodsparameter_id)){ 
			    $this->jump("/admin/goodsparameter/index","删除成功",0);
		}else{
			$this->jump("/admin/goodsparameter/index","删除失败",3);
		}
		
	}
}