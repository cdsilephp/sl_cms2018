<?php
// 商品类型模型
class tableModel extends Model
{
    public function __construct()
    {
        parent::__construct("table");
    }
    
    public function getall($page=0,$limit=10)
    {
        $page = $page==""?0:($page-1);
        $limit= $limit==""?0:$limit;
        $tablelist = $this->findBySql("SELECT *,(SELECT u2 from sl_parameter where u1=mx.u3 ) as tablelianjie from sl_table as mx order by id desc limit ".$page*$limit.",".$limit );
        return  $tablelist;
        
    }
    
    public function getTablenameByTableid($table_id) {
        $tabledetail = $this->findOne($table_id);
        if(!empty($tabledetail))
        {
            return $tabledetail['u1'];
        }else{
            return "";
        }
    }
    
    /**
    
    * 判断是否已存在
    
    * @date: 2018年9月28日 下午6:35:04
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    public function isadded($table)
    {
        $data['u1']=$table['u1'];
        $data['u2']=$table['u2'];
        
        if($this->where($data)->all())
        {
            return false;
        }else {
            return true;
        }
    }
    
    // 删除表和sl_fileds 里对应的字段
    function deleteModel($model_id, $model_name)
    {
        $filedModel = new Model("filed");
        $this->db->exec_update_delete("drop table $model_name ");
        $this->db->exec_update_delete("delete from sl_filed where model_id='{$model_id}' ");
    }
    
    // 根据模型类型，添加模型
    public function addtableByType($type, $tableName)
    {
        switch (trim($type)) {
            case "文章模型":
                $this->createArticleModelTable($type, $tableName);
                $this->addFiled($tableName);
                break;
            case "表单模型":
                $this->createBiaodanModelTable($type, $tableName);
                $this->addFiled($tableName);
                break;
                
            case "用户模型":
                $this->createYonghuModelTable($type, $tableName);
                $this->addFiled($tableName);
                break;
                
            case "分类模型":
                $this->createCategoryModelTable($type, $tableName);
                $this->addFiled($tableName);
                break;
            
            default:
                echo "没有这个模型!";
        }
    }

    /*
     * `model_id` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '模型id',
     * `u1` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '数据库字段名',
     * `u2` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '字段名称',
     * `u3` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '字段提示',
     * `u4` varchar(10) CHARACTER SET utf8 DEFAULT '否' COMMENT '是否必填',
     * `u5` varchar(10) CHARACTER SET utf8 DEFAULT '否' COMMENT '是否显示',
     * `u6` varchar(10) CHARACTER SET utf8 DEFAULT '否' COMMENT '是否检索',
     *
     * `u7` varchar(50) CHARACTER SET utf8 DEFAULT '文本框' COMMENT '字段类型',
     * `u8` varchar(50) CHARACTER SET utf8 DEFAULT ' ' COMMENT '默认值',
     * `u9` varchar(50) CHARACTER SET utf8 DEFAULT '10%' COMMENT '列表CSS',
     * `u10` varchar(10) CHARACTER SET utf8 DEFAULT '0' COMMENT '排序',
     */
    public function addFiled($tableName)
    {
        $filed = new Model("filed");
        $table = new Model($tableName);
        $model_id = $this->where(["u1"=>$tableName])->one()['id'];
        $array = $table->getFieldsAndTypes();
        foreach ($array as $v) {
            if ($v['column_name'] != 'id' && $v['column_name'] != 'sort_id' ) {
                
                $data['model_id'] = $model_id;
                $data['u1'] = $v['column_name'];
                $data['u2'] = $v['column_comment'];
                $data['u3'] = "";
                $data['u4'] = ($v['is_nullable'] == 'YES') ? '否' : '是';
                $data['u5'] = '否';
                $data['u6'] = '否';
                $data['u8'] = $v['column_default'];
                $data['u9'] = "80";
                $data['u10'] = $v['id'];
                
                // 得到字段的类型
                $filed_type = "文本框";
                switch ($v['data_type']) {
                    case "int":
                        $filed_type = "数字";
                        break;
                    case "char":
                        if($data['u2']=="密码")
                        {
                            $filed_type = "密码";
                        }else 
                        {
                            $filed_type = "文本框";
                        }
                        
                        break;
                    case "mediumtext":
                        $filed_type = "文本编辑器";
                        break;
                    case "varchar":
                        $filed_type = "文本域";
                        break;
                    case "timestamp":
                            $filed_type = "时间框";
                            break;
                }
                $data['u7'] = $filed_type;
                
                $filed->insert($data);
            }
        }
    }
    
    // 创建文章模型表的SQL
    public function createArticleModelTable($type, $tableName)
    {
        $sql = "
        CREATE TABLE `{$tableName}` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `sort_id` char(100) DEFAULT '0' COMMENT '分类id',
        `biaoti` char(100) NOT NULL DEFAULT '' COMMENT '标题',
        `laiyuan` char(100)  NULL DEFAULT '' COMMENT '来源',
        `status`char(100) NULL DEFAULT '终审' COMMENT '状态：待审,终审,回收站',
        `paixu` int(10) unsigned DEFAULT '1' COMMENT '排序',
        `url` char(100) DEFAULT NULL COMMENT '链接',
        `suolutu` char(100) DEFAULT NULL COMMENT '缩略图',
        `description` varchar(250) DEFAULT NULL COMMENT '文章摘要',
        `content` mediumtext COMMENT '详细内容',
        `seokeywords` varchar(250) DEFAULT NULL COMMENT 'seo关键字',
        `seodescription` varchar(250) DEFAULT NULL COMMENT 'seo描述',
        `seotitle` varchar(250) DEFAULT NULL COMMENT 'SEO标题',
        `username` char(100) DEFAULT NULL COMMENT '用户名',
        `dtime` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP COMMENT '添加时间',
        PRIMARY KEY (`id`)
        ) ENGINE=INNODB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 COMMENT='{$tableName}模型主表';";
        
        if ($this->db->exec_update_delete($sql)) {
            return true;
        } else {
            // 失败返回false
            return false;
        }
    }
    
    // 创建表单模型表的SQL
    public function createBiaodanModelTable($type, $tableName)
    {
        $sql = "
        CREATE TABLE `{$tableName}` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        
        `dtime` timestamp NULL DEFAULT now() COMMENT '添加时间',
        PRIMARY KEY (`id`)
        ) ENGINE=INNODB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 COMMENT='{$tableName}模型主表';";
        
        if ($this->db->exec_update_delete($sql)) {
            // 成功，并判断受影响的记录数
            return true;
        } else {
            // 失败返回false
            return false;
        }
    }
    
    
    // 创建用户模型表的SQL
    public function createYonghuModelTable($type, $tableName)
    {
        $sql = "
        CREATE TABLE `{$tableName}` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `yonghuming` char(100) NOT NULL DEFAULT '' COMMENT '用户名',
        `mima` char(200) NOT NULL DEFAULT '' COMMENT '密码',
        `dtime` timestamp NULL DEFAULT now() COMMENT '添加时间',
        PRIMARY KEY (`id`)
        ) ENGINE=INNODB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 COMMENT='{$tableName}模型主表';";
        
        if ($this->db->exec_update_delete($sql)) {
            return true;
        } else {
            // 失败返回false
            return false;
        }
    }
    
    
    // 创建分类模型表的SQL
    public function createCategoryModelTable($type, $tableName)
    {
        $sql = "
        CREATE TABLE `{$tableName}` (
        `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
        `class_id` char(100) DEFAULT '0' COMMENT '分类id',
        `biaoti` char(100) NOT NULL DEFAULT '' COMMENT '标题',
        `paixu` int(10) unsigned DEFAULT '1' COMMENT '排序',
        `dtime` timestamp NULL DEFAULT now() COMMENT '添加时间',
        PRIMARY KEY (`id`)
        ) ENGINE=INNODB  DEFAULT CHARSET=utf8  AUTO_INCREMENT=1 COMMENT='{$tableName}模型主表';";
        
        if ($this->db->exec_update_delete($sql)) {
            // 成功，并判断受影响的记录数
            return true;
        } else {
            // 失败返回false
            return false;
        }
    }
    
    
    /**
    
    * 根据传递的参数，自动获得SQL的条件语句
    
    * @date: 2018年10月5日 下午8:32:41
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    public function getSqlWhereStr_new($table_id ,$andOror="and",$nosort_id=true)
    {
        $filedModel=new filedModel();
        $filedAraay=$filedModel->getallFiledByTableid($table_id);
        $search_value=$this->common->Requert("search_value");
        $sql="";
        
        foreach ($filedAraay as $v)
        {
            if (!empty($this->common->Requert($v['u1'])) && $this->common->Requert($v['u1']) != '') {
                if($v['u7']=='时间框')
                {
                    $sql .= $this->getDtimeSql($v['u1'])." {$andOror} ";
                }else{
                    $sql = $sql . $v['u1']. " like '%{$this->common->Requert($v['u1'])}%' {$andOror} ";
                }
                
            }
            
            
            //组合统一查询
            if($search_value!="" && $v['u6']=="是")
            {
                $sql = $sql . $v['u1']. " like '%{$search_value}%' {$andOror} ";
            }
            
        }
        
        
        
        if(!empty($this->common->Requert("sort_id")) && $nosort_id)
        {
            $sql = $sql ." sort_id ={$this->common->Requert("sort_id")}  {$andOror}  ";
        }
        
        if( $this->common->Requert("class_id")=='0' )
        {
            $sql = $sql ." class_id ={$this->common->Requert("class_id")}  {$andOror}  ";
        }
         
        
        
        if($sql!="")
        {
            if($andOror=="and")
            {
                $sql.="  1=1";
            }else{
                $sql.="  1=2";
            }
        }
        
        //echo $sql."asdf";die();
        
        return $sql;
    }
    
    
}