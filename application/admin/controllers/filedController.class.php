<?php
// 字段控制器
class filedController extends baseController
{
    
    // 显示字段列表
    public function indexAction()
    {
        // 先获取字段信息
        $table_id = $this->common->Get('table_id');
        
        include CUR_VIEW_PATH . "Sfiled" . DS . "filed_list.html";
    }
    
    public function getfiledlistAction(){
        $table_id = $this->common->Get('table_id');
        $page = $this->common->Get("page");
        $limit= $this->common->Get("limit");
        $filedModel = new filedModel();
        $filedList= $filedModel->getfieldlistBytableid($table_id,$page,$limit);
        $filedList["data"]=$filedList;
        $filedList["code"]="0";
        $filedList["msg"]="";
        $filedList["count"]=count($filedModel->where(["model_id"=>$table_id])->all());
        
        $this->common->ajaxReturn($filedList);
    }
    
    // 载入添加字段页面
    public function addAction()
    { 
        $filedModel = new filedModel();
        $table_id = $this->common->Get('table_id');
        
        $fileType = $filedModel->getSystemFiledtype();
        $filedshowtypeList = $filedModel->getallfiledShowType();
        
        $fileShowType="";
        include CUR_VIEW_PATH . "Sfiled" . DS . "filed_add.html";
    }
    
    // 载入编辑字段页面
    public function editAction()
    {
        $filedModel = new filedModel();
        $table_id = $this->common->Get('table_id');
        $fileType = $filedModel->getSystemFiledtype();
        
        $filed_id = $this->common->Get('id');
        $filedModel = new filedModel();
        $filed = $filedModel->findOne($filed_id);
        $filedshowtypeList = $filedModel->getallfiledShowType();
        
        if(empty($filed))
            die("filed_id={$filed_id} 字段不存在");
        include CUR_VIEW_PATH . "Sfiled" . DS . "filed_edit.html";
    }
    
    // 定义insert方法，完成字段的插入
    public function insertAction()
    {
        $data_return["status"]=false;
        $data_return["msg"]="";
        $data_return["code"]=1;
        
        $filedModel = new filedModel();
        $table_id = $this->common->Get('table_id');
        // 1.收集表单数据
        $data = $filedModel->getFieldArray();
        $data['u4'] = empty($data['u4'])?"否":"是";
        $data['u5'] = empty($data['u5'])?"否":"是";
        $data['u6'] = empty($data['u6'])?"否":"是";
        $data['u11'] = empty($data['u11'])?"否":"是";
        $data['model_id']=$table_id;
        
        //判断字段是否已经存在
        if(count($filedModel->findBySql("select * from sl_filed where model_id={$table_id} and u1='{$data['u1']}' "))>0 )
        {
            $data_return["msg"]="该字段已经存在";
            $this->common->ajaxReturn($data_return);
            
        }
        
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        
        
        // 加载字段名和其所属表名
        $filed_u1 = $data['u1']; // 字段名 如： biaoti
        $tableModel = new tableModel();
        $table_name = $tableModel->getTablenameByTableid($table_id);
        //$table_name1 = str_replace("sl_", "", $table_name);
        $_tableModel = new Model($table_name);
        // 拼接数据库新添加字段的SQL
        $commom = $this->common;
        $filedTpye = $commom->getFiledType($data['u7']);
        $bitian = $data['u4'] == "是" ? "not null" : "null";
        if ($filedTpye != "mediumtext") {
            $defultValue = $data['u8'];
        }

        $sql = "alter table `{$table_name}`  Add column {$filed_u1} {$filedTpye} {$bitian}  COMMENT '{$data['u2']}' ";

        
        // 3调用模型完成入库并给出提示
       if ($filedModel->insert($data)) {
           // 4.创建数据表的字段
           $tableModel->query($sql);
           $data_return["status"]=true;
           $data_return["msg"]="添加成功";
           $data_return["code"]=0;

       } else {
           $data_return["msg"]="添加失败";
       }
       $this->common->ajaxReturn($data_return);

    }

    // 定义update方法，完成字段的更新
    public function updateAction()
    {
        $data_return["status"]=false;
        $data_return["msg"]="";
        $data_return["code"]=1;
        
        $filedModel = new filedModel();
        $table_id = $this->common->Get('table_id');
        // 1.收集表单数据
        $data = $filedModel->getFieldArray();
        $data['u4'] = empty($data['u4'])?"否":"是";
        $data['u5'] = empty($data['u5'])?"否":"是";
        $data['u6'] = empty($data['u6'])?"否":"是";
        $data['u11'] = empty($data['u11'])?"否":"是";
        $data['model_id']=$table_id;
        
        //判断字段是否已经存在
        if(count($filedModel->findBySql("select * from sl_filed where model_id={$table_id} and u1='{$data['u1']}' "))>1 )
        {
            $data_return["msg"]="该字段已经存在";
            $this->common->ajaxReturn($data_return);
            
        }
        
        $this->helper('input');
        $data = deepspecialchars($data);
        $data = deepslashes($data);
        
        
        // 加载字段名和其所属表名
        $filed_u1 = $data['u1']; // 字段名 如： biaoti
        $tableModel = new tableModel();
        $table_name = $tableModel->getTablenameByTableid($table_id);
        //$table_name1 = str_replace("sl_", "", $table_name);
        $_tableModel = new Model($table_name);
        // 拼接数据库新添加字段的SQL
        $commom = new Common();
        $filedTpye = $commom->getFiledType($data['u7']);
        $bitian = $data['u4'] == "是" ? "not null" : "null";
        
        $filed_u1_old = $filedModel->findOne($data['id'])['u1'];
        
        $sql = "alter table `{$table_name}` change column {$filed_u1_old} {$filed_u1} {$filedTpye} {$bitian}  COMMENT '{$data['u2']}'";
        // 4.创建数据表的字段
        $tableModel->query($sql);
        
        // 3调用模型完成入库并给出提示
        if ($filedModel->update($data)) {
            $data_return["status"]=true ;
            $data_return["msg"]="修改成功";
            $data_return["code"]=0;
        } else {
            $data_return["msg"]="修改失败";
        }
        $this->common->ajaxReturn($data_return);
        
    }
    
    // 定义delete方法，完成字段的删除
    public function deleteAction()
    {
        // 获取filed_id
        $filed_id = $this->common->Get('id');
        $table_id = $this->common->Get('table_id') ;
        $filedModel = new filedModel();
        $filed_u1 = $filedModel->findOne($filed_id)['u1']; // 字段名 如： biaoti
        
        $tableModel = new tableModel();
        $table_name =$tableModel->getTablenameByTableid($table_id);
        $tableModel = new Model($table_name);
        
        // 删除sl_filed 表的数据，同时删除对应表的字段
        if ($filedModel->delete($filed_id)) {
            // 同时删除对应表的字段
            $tableModel->query("alter table `{$table_name}` drop column {$filed_u1}  ");
            
            $this->jump("/admin/filed/index?table_id={$table_id}", "删除成功", 0);
        } else {
            $this->jump("/admin/filed/index?table_id={$table_id}", "删除失败", 3);
        }
    }

    //ajax 中文转拼音
    public function zh2pyAction()
    {
        //挂载中文转拼音类
        include LIB_PATH . "CUtf8_PY.class.php";
        $ch2ypClass =new CUtf8_PY();
        //接收参数
        $temp_str=$this->common->Get('Zh_str');
        $table_id=$this->common->Get('table_id');
        $type=$this->common->Get('type'); 

        //转换后的参数
        $temp_str=$ch2ypClass->encode($temp_str,"all");
        
        if($table_id=="")
        {
            echo '{"status": "true","content": "'.$temp_str.'"}';die();
            //echo '{"status": "false","content": "table_id参数不能为空"}';
        }
        //转换后的参数
        $temp_str=$ch2ypClass->encode($temp_str,"all");
        //检查该model下的字端是否已经存在
        $filedModel = new filedModel();
        //
        if(count($filedModel->findBySql("select * from sl_filed where model_id={$table_id} and u1='{$temp_str}' "))>0 && $type=="add")
        {
            echo '{"status": "false","content": "该字段已经存在"}';
            
        }else
        {
            echo '{"status": "true","content": "'.$temp_str.'"}';
        }
        
        
    }

}