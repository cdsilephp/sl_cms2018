<?php
//模型控制器
class tableController extends baseController{
	
	//显示模型列表
	public function indexAction(){
	    
		include CUR_VIEW_PATH ."Stable".DS. "table_list.html";
	}

	
	public function gettablelistAction(){
	    $page = $this->common->Get("page");
	    $limit= $this->common->Get("limit");
	    
	    //先获取用户组信息
	    $tableModel = new tableModel();
	    $tableList = $tableModel->getall($page,$limit);
	    
	    
	    $tableList["data"]=$tableList;
	    $tableList["code"]="0";
	    $tableList["msg"]="";
	    $tableList["count"]=$tableModel->getCountNum();
	    
	    $this->common->ajaxReturn($tableList);
	}
	
	//更具表的ID查询需要显示的数据
	public function gettablelistbytableidAction(){
	    
	    $tableModel = new tableModel();
	    $table_id = $this->common->Get('table_id');
	    $tableName = $tableModel->getTablenameByTableid($table_id);
	    
	    //echo $tableModel->getSqlWhereStr_new($table_id);die();
	    
	    $_tableModel = new Model($tableName);
	    
	    $page = $this->common->Get("page");
	    $limit= $this->common->Get("limit");
	    $page = ($page-1)*$limit;
	    $table_sql = $tableModel->getSqlWhereStr_new($table_id);
	     
	    if($table_sql=="")
	    {
	        $table_sql = " 1=1 ";
	    }
	    $_tableList1 = $_tableModel->findBySql("select * from {$tableName} where {$table_sql} limit {$page},{$limit} ");
	    
	    //挂载控件类
	    $this->library("Component");
	    $ComponentClass = new Component();
	    $filedModel=new filedModel();
	    $filedAraay=$filedModel->getallFiledByTableid($table_id);
	    foreach ($filedAraay as $v)
	    {
	        //处理不同字段的显示数据
	        foreach ($_tableList1 as $k1=>$v1) {
	            $v1[$v['u1']] =$ComponentClass->showKj($v['u7'],$v['u2'],$v['u1'] ,$v1[$v['u1']],$v['u3'] ,$v['id']) ;
	            $_tableList1[$k1]=$v1;
	        }
	    }
	    
	    $_tableList["data"]=$_tableList1;
	    $_tableList["code"]="0";
	    $_tableList["msg"]="";
	    $_tableList["count"]=$_tableModel->getCountNum();
	    
	    $this->common->ajaxReturn($_tableList);
	}
	
	
	//载入添加模型页面
	public function addAction(){
	    $parameterModel = new parameterModel();
	    $u3=$parameterModel->getparameterByclassid(1);
	    
	    $sortModel = new sortModel();
	    $classidArray = $sortModel->getsortByclassid("");
	    //挂载 TREE 类
	    $this->helper('tree');
	    $tree =new Tree($classidArray) ;
	    $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
	    $html_option='';
	    $html_option .= $tree->get_tree(0,$str,-1);
	    
		include CUR_VIEW_PATH . "Stable".DS. "table_add.html";
	}

	//载入编辑模型页面
	public function editAction(){
		//获取该模型信息
		$tableModel = new tableModel();
		//条件
		$table_id =  $this->common->Get('id'); 
		//使用模型获取
		$table = $tableModel->findOne($table_id);
		//初始化其他选项
		$parameterModel = new parameterModel();
		$u3=$parameterModel->getparameterByclassid(1);
		
		$sortModel = new sortModel();
		$classidArray = $sortModel->getsortByclassid("");
		//挂载 TREE 类
		$this->helper('tree');
		$tree =new Tree($classidArray) ;
		$str = "<option value=\$id  \$selected >\$spacer\$name</option>";
		$html_option='';
		$html_option .= $tree->get_tree(0,$str,$table['u10']);
		
		include CUR_VIEW_PATH ."Stable".DS. "table_edit.html";
	}

	//定义insert方法，完成模型的插入
	public function insertAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $tableModel = new tableModel();
	    //1.收集表单数据
	    $data=$tableModel->getFieldArray();
	    $data['u4'] = empty($data['u4'])?"off":"on";
	    $data['u1']=$GLOBALS['config_db']['prefix'].$data['u1'];
	    $data['u10'] = $data['u10']=="" ?0:$data['u10'];
	    
	    if(!$tableModel->isadded($data))
	    {
	        $data_return["msg"]="型名或模型别名已存在";
	        $this->common->ajaxReturn($data_return);
	    }
	    
	   $tableModel->start_T();
	   
	   //var_dump($data);die();
	    //3调用模型完成入库并给出提示
	    if ($tableModel->insert($data)) {
	        //4.创建数据表 
	        $tableModel->addtableByType($data['u3'], $data['u1']);
	        $data_return["status"]=true;
	        $data_return["msg"]="添加成功";
	        $data_return["code"]=0;
	        
	    } else {
	        $tableModel->roll_T();
	        $data_return["msg"]="添加失败";
	    }
	    $this->common->ajaxReturn($data_return);
	    $tableModel->comit_T();
	}

	//定义update方法，完成模型的更新
	public function updateAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $tableModel = new tableModel();
	    //1.收集表单数据
	    $data=$tableModel->getFieldArray();
	    $data['u4'] = empty($data['u4'])?"off":"on";
	    $data['u10'] = $data['u10']=="" ?0:$data['u10'];
	    
	   
		
		//调用模型完成更新
		
		if($tableModel->update($data)){
		    $data_return["status"]=true;
		    $data_return["msg"]="更新成功";
		    $data_return["code"]=0;
		    
		    
		    //生成自定义的控制器和试图
		    if($data['u4']=="off" && $data['u8']!="autotable" && $data['u8']!="article" )
		    {
		        $_controller ="autotable";
		        $_view ="Sautotable";
		        
		        if($data['u3']=="文章模型"){
		            $_controller ="article";
		            $_view ="Sarticle";
		        }
		        
		        //复制控制器
		        $_controllerSrc=CUR_CONTROLLER_PATH.$_controller."Controller.class.php";
		        $_controllerSrcNew=CUR_CONTROLLER_PATH.$data['u8']."Controller.class.php";
		        if(file_exists($_controllerSrcNew) )
		        {
		            $_controllerSrcNew=CUR_CONTROLLER_PATH.$data['u8'].time()."Controller.class.php";;
		        }
		        //copy($_controllerSrc,$_controllerSrcNew);
		        $_controllerfile = fopen($_controllerSrc, "r") or die("Unable to open file: {$_controllerSrc}!");
		        $_controllerContent = fread($_controllerfile,filesize($_controllerSrc));
		        $_controllerContent =str_replace($_controller,$data['u8'],$_controllerContent);
		        //fwrite($_controllerfile,$_controllerContent);
		        file_put_contents($_controllerSrcNew, $_controllerContent); 
		        
		        //复制view
		        $list_html = file_get_contents($this->common->getHostDomain()."/admin/{$_controller}/index?table_id={$data['id']}");
		        $add_html = file_get_contents($this->common->getHostDomain()."/admin/{$_controller}/add?table_id={$data['id']}");
		        $edit_html = $add_html;
		        //替换关键词
		        $list_html=str_replace($_controller,$data['u8'],$list_html);
		        $add_html=str_replace($_controller,$data['u8'],$add_html); 
		        
		        $list_html=str_replace($this->common->getHostDomain(),'',$list_html);
		        $add_html=str_replace($this->common->getHostDomain(),'',$add_html); 
		        
		        
		        $edit_html = $add_html;
		        
		        
		        if (!file_exists(CUR_VIEW_PATH.$data['u9'])){
		            mkdir (CUR_VIEW_PATH.$data['u9'],0777,true);
		        }else{
		            mkdir (CUR_VIEW_PATH.$data['u9'].time(),0777,true);
		        }  
		        
		        $_listviewSrc=CUR_VIEW_PATH.$data['u9'].DS.$data['u8']."_list.html";
		        $_addviewSrc=CUR_VIEW_PATH.$data['u9'].DS.$data['u8']."_add.html";
		        $_editviewSrc=CUR_VIEW_PATH.$data['u9'].DS.$data['u8']."_edit.html";
		        
		        $list_file = fopen($_listviewSrc, "w") or die("Unable to open file!{$_listviewSrc}"); 
		        fwrite($list_file, $list_html);
		        
		        $add_file = fopen($_addviewSrc, "w") or die("Unable to open file!{$_addviewSrc}");
		        fwrite($add_file, $add_html);
		        
		        $edit_file = fopen($_editviewSrc, "w") or die("Unable to open file!{$_editviewSrc}");
		        fwrite($edit_file, $edit_html);
		        
		        
		    }
		    
		    
		}else{
		    $data_return["msg"]="更新失败";
		}
		$this->common->ajaxReturn($data_return);
		
	}

	//定义delete方法，完成模型的删除
	public function deleteAction(){
		//获取brand_id
	    $table_id = $this->common->Get('id');
		$tableModel = new tableModel();
		$table_name=$tableModel->findOne($table_id)['u1'];
		//删除表和sl_fileds 里对应的字段
		$tableModel ->deleteModel($table_id,$table_name);
		
		if ($tableModel->delete($table_id)){ 
			$this->jump("/admin/table/index","删除成功",0);
		}else{
			$this->jump("/admin/table/index","删除失败",3);
		}
	}
}