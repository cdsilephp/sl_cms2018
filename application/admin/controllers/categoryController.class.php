<?php
//分类控制器
class categoryController extends baseController{
	
	//显示文章列表
	public function indexAction(){
	    $table_id = $this->common->Get('table_id');
	    if($table_id=="")
	        die("table_id 不能为空");
        $class_id= $this->common->Get('class_id');
        $class_id = $class_id==""?0:$class_id;
	    $filedModel = new filedModel();
	    $filedlistJson =$filedModel->getFiledJsonByTableid($table_id); 
	    
	    $filedSearchList = $filedModel->getsearchfiledByTableid($table_id);
	    //会显示出来的字段
	    $filedShowList = $filedModel->getshowfiledByTableid($table_id);
	    //挂载  组件类
	    $this->library('Component');
	    $component = new Component();
	    
	     
		include CUR_VIEW_PATH ."Scategory".DS."category_list.html";
	}
	
	//显示文章列表
	public function addAction(){
	    $table_id = $this->common->Get('table_id');
	    if($table_id==""){
	        die("table_id 不能为空");
	    }
	    $class_id= $this->common->Get('class_id');
	    $class_id = $class_id==""?0:$class_id;
	    
	    $filedModel = new filedModel();
	    $filedList = $filedModel->getallFiledByTableid($table_id);
	    $filedshowtypeList = $filedModel->getfiledShowTypeBytableid($table_id);
	    
	    $tableModel = new tableModel();
	    $tableDetail = $tableModel->findOne($table_id);
	    
	    //挂载  组件类
	    $this->library('Component');
	    $component = new Component();

	        
	    include CUR_VIEW_PATH ."Scategory".DS."category_add.html";
	}
	
	
	//显示文章列表
	public function editAction(){
	    $table_id = $this->common->Get('table_id');
	    $id = $this->common->Get('id');
	    if($table_id==""){
	        die("table_id 不能为空");
	    }
	    
	    $filedModel = new filedModel();
	    $filedList = $filedModel->getallFiledByTableid($table_id);
	    $filedshowtypeList = $filedModel->getfiledShowTypeBytableid($table_id);
	    
	    $tableModel = new tableModel();
	    $tableDetail = $tableModel->findOne($table_id);
	    $tablename = $tableModel->getTablenameByTableid($table_id);
	    $_tableModel = new Model($tablename);
	    $_tableDetail = $_tableModel->findOne($id);
	    
	    //挂载  组件类
	    $this->library('Component');
	    $component = new Component();
	    
	    
	    include CUR_VIEW_PATH ."Scategory".DS."category_edit.html";
	}

	
	// 定义insert方法，完成文章模型的插入
	public function insertAction()
	{
	    //获取该用户组信息
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $table_id = $this->common->Requert('table_id');
	    // 获得当前表名
	    $tableModel = new tableModel();
	    $tableName = $tableModel->getTablenameByTableid($table_id);
	    //先获取文章信息
	    $_tableModel = new Model($tableName);
	    
	    //1.收集表单数据
	    $data=$_tableModel->getFieldArray();
	    
	    //2.验证和处理
	    
	    $this->helper('input');
	    $data = deepspecialchars($data);
	    $data = deepslashes($data);
	    
	    
	    $filedModel=new filedModel();
	    $filedAraay=$filedModel->getallFiledByTableid($table_id);
	     
	    
	    //处理表单验证===>正则匹配
	    foreach ($filedAraay as $v)
	    {
	        //设置了不为空
	        if($v['u4']=="是")
	        {
	            if($data[$v['u1']]=="" || $data[$v['u1']]==null)
	            {
	                $data_return["msg"]="操作失败:".$v['u2']."不能为空";
	                $this->common->ajaxReturn($data_return);
	                
	            }
	            
	        }
	        
	        if(isset($v['u14']) && $GLOBALS['config_regular'][$v['u14']]!="无" && $GLOBALS['config_regular'][$v['u14']]!="")
	        {
	            $n = preg_match($GLOBALS['config_regular'][$v['u14']], $data[$v['u1']] , $array);
	            /*接下来的正则表达式("/131,132,133,135,136,139开头随后跟着任意的8为数字 '|'(或者的意思)
	             * 151,152,153,156,158.159开头的跟着任意的8为数字
	             * 或者是188开头的再跟着任意的8为数字,匹配其中的任意一组就通过了
	             * /")*/
	            //var_dump($array); //看看是不是找到了,如果找到了,就会输出电话号码的
	            if(count($array)==0)
	            {
	                //改字段不合法
	                $data_return["msg"]=$v['u2']."字段不合法";
	                $this->common->ajaxReturn($data_return);
	                 
	            }
	        }
	    }
	    
	    
	    foreach ($filedAraay as $v)
	    {
	        $filedList=$filedModel->findBySql("select * from sl_filed where  u7='时间框' and u8='CURRENT_TIMESTAMP' and model_id='{$table_id}' and u1='{$v['u1']}' ");
	        if(count($filedList)>0)
	        {
	            $data[$v['u1']]= date('Y-m-d H:i:s',time());
	        }
	    }
	    
	    
	    //单独处理密码
	    foreach ($filedAraay as $v)
	    {
	        $filedList=$filedModel->findBySql("select * from sl_filed where  u7='密码' and model_id='{$table_id}' and u1='{$v['u1']}' ");
	        if(count($filedList)>0)
	        {
	            $data[$v['u1']]=md5($data[$v['u1']]);
	        }
	    }
	    foreach ($filedAraay as $v)
	    {
	        $filedList=$filedModel->findBySql("select * from sl_filed where  u7='文本编辑器' and model_id='{$table_id}' and u1='{$v['u1']}' ");
	        if(count($filedList)>0 && !empty($data[$v['u1']]))
	        {
	            $data[$v['u1']]=html_entity_decode($data[$v['u1']]);
	        }
	    }
	    
	    
	    
	    //3调用模型完成入库并给出提示
	    if ($_tableModel->insert($data)) {
	        $data_return["status"]=true;
	        $data_return["msg"]="添加成功";
	        $data_return["code"]=0;
	        
	    } else {
	        $data_return["msg"]="添加失败";
	        
	    }
	    $this->common->ajaxReturn($data_return);
	    
	}
	
	
	// 定义insert方法，完成文章模型的插入
	public function updateAction()
	{
	    //获取该用户组信息
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    $id = $this->common->Requert('id');
	    $table_id = $this->common->Requert('table_id');
	    if($id=="")
	    {
	        $data_return["msg"]="id 不能为空";
	        $this->common->ajaxReturn($data_return);
	    }
	    // 获得当前表名
	    $tableModel = new tableModel();
	    $tableName = $tableModel->getTablenameByTableid($table_id);
	    //先获取文章信息
	    $_tableModel = new Model($tableName);
	    
	    //1.收集表单数据
	    $data=$_tableModel->getFieldArray();
	    
	    //2.验证和处理
	    
	    $this->helper('input');
	    $data = deepspecialchars($data);
	    $data = deepslashes($data);
	    
	    $filedModel=new filedModel();
	    $filedAraay=$filedModel->getallFiledByTableid($table_id);
	    
	    
	    //处理表单验证===>正则匹配
	    foreach ($filedAraay as $v)
	    {
	        //设置了不为空
	        if($v['u4']=="是")
	        {
	            if($data[$v['u1']]=="" || $data[$v['u1']]==null)
	            {
	                $data_return["msg"]="操作失败:".$v['u2']."不能为空";
	                $this->common->ajaxReturn($data_return);
	                
	            }
	            
	        }
	        
	        if(isset($v['u14']) && $GLOBALS['config_regular'][$v['u14']]!="无" && $GLOBALS['config_regular'][$v['u14']]!="")
	        {
	            $n = preg_match($GLOBALS['config_regular'][$v['u14']], $data[$v['u1']] , $array);
	            /*接下来的正则表达式("/131,132,133,135,136,139开头随后跟着任意的8为数字 '|'(或者的意思)
	             * 151,152,153,156,158.159开头的跟着任意的8为数字
	             * 或者是188开头的再跟着任意的8为数字,匹配其中的任意一组就通过了
	             * /")*/
	            //var_dump($array); //看看是不是找到了,如果找到了,就会输出电话号码的
	            if(count($array)==0)
	            {
	                //改字段不合法
	                $data_return["msg"]=$v['u2']."字段不合法";
	                $this->common->ajaxReturn($data_return);
	                
	            }
	        }
	    }
	    
	    
	    //单独处理密码
	    foreach ($filedAraay as $v)
	    {
	        $filedList=$filedModel->findBySql("select * from sl_filed where  u7='密码' and model_id='{$table_id}' and u1='{$v['u1']}' ");
	        if(count($filedList)>0 && $data[$v['u1']]!="")
	        {
	            $data[$v['u1']]=md5($data[$v['u1']]);
	        }
	    }
	    
	    //var_dump($data);die();
	    
	    foreach ($filedAraay as $v)
	    {
	        $filedList=$filedModel->findBySql("select * from sl_filed where  u7='文本编辑器' and model_id='{$table_id}' and u1='{$v['u1']}' ");
	        if(count($filedList)>0 && !empty($data[$v['u1']]))
	        {
	            $data[$v['u1']]=html_entity_decode($data[$v['u1']]);
	        }
	    }
	    
	    
	    
	    //3调用模型完成入库并给出提示
	    if ($_tableModel->update($data)) {
	        $data_return["status"]=true;
	        $data_return["msg"]="更新成功";
	        $data_return["code"]=0;
	        
	    } else {
	        $data_return["msg"]="更新失败";
	        
	    }
	    $this->common->ajaxReturn($data_return);
	    
	}
	
	
	//定义delete方法，完成文章的删除
	public function deleteAction(){
	    $data_return["status"]=true;
	    $data_return["msg"]="添加成功";
	    $data_return["code"]=0;
	    
	    $ids = $this->common->Requert('id');
	    $table_id = $this->common->Requert('table_id');
	    if($ids=="")
	    {
	        $data_return["msg"]="id 不能为空";
	        $this->common->ajaxReturn($data_return);
	    }
	    if($table_id=="")
	    {
	        $data_return["msg"]="table_id不能为空";
	        $this->common->ajaxReturn($data_return);
	    }
	    
	    $tableModel = new tableModel();
	    $tableName = $tableModel->getTablenameByTableid($table_id);
		 
	    $array_id=explode(",", $ids);
		$array_id=array_unique($array_id);
		
		$_tableModel = new Model($tableName);
		
		
		if($_tableModel->delete($array_id)!="false")
		{
		    $data_return["status"]=true;
		    $data_return["msg"]="删除成功";
		    $data_return["code"]=1;
		    
		}
		else 
		{
		    $data_return["msg"]="删除成功";
		    
		}
		$this->common->ajaxReturn($data_return);
		
	}
	
	
	
}