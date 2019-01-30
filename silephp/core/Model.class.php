<?php
// 模型类基类
class Model
{
    // 数据库连接对象
    protected $db;

   
    // 表的主键
    protected $pk = "id";
    // 字段列表
    protected $fields = array();
    
     /**
     * 20180122
     * ghy
     * 链式查询参数
     */
    public $table;

    protected $column = "*";

    protected $condition = array();
    
    protected $condition_str = "";

    protected $group;

    protected $order;

    protected $having;

    protected $startSet;

    protected $endSet;
    protected $wherestr;

    // 查询参数
    protected $options = [];
    // 当前数据表名称（不含前缀）
    protected $name = '';
    // 当前数据表前缀
    protected $prefix = '';
    
    //查询返回结果
    protected $result = array();
    
    public  $common;

    public function __construct($table="")
    {
        
        // var_dump($dbconfig);die();
        //$this->db = new CPdo(false, $dbconfig);

        $this->db = CPdo::getInstance();
        if($table!="")
        {
            $this->M($table);
        }
        $this->common  = new Common();
    }

    /**
     * 获取表主键
     */
    private function getPK()
    {
        if ($this->table != $GLOBALS['config_db']['prefix'] && ! empty($this->table)) {
            $sql = "DESC " . $this->table;
            
            $result = $this->db->getValueBySelfCreateSql($sql);
            foreach ($result as $v) {
                $this->fields[] = $v['Field'];
                if ($v['Key'] == 'PRI') {
                    // 如果存在主键的话，则将其保存到变量$pk中
                    $pk = $v['Field'];
                }
            }
            // 如果存在主键，则将其加入到字段列表fields中
            if (isset($pk)) {
                $this->fields['pk'] = $pk;
                $this->pk = $pk;
            }
            
        }
    }
    
    
    

    /**
     * 设置模型的表明
     * 
     * @param unknown $table            
     */
    public function M($table)
    {
        $table = str_replace($GLOBALS['config_db']['prefix'], "", $table);
        $this->table = $GLOBALS['config_db']['prefix'] . $table;
        // 设置主键
        $this->getPK();
        return $this;
    }

    /**
     * 筛选返回字段
     * @param string $column
     */
    public function find($column = '*')
    {
         if($column!="" || !empty($this->column ))
         {
             $this->column = $column;
         }
        
        return $this;
    }

    /**
     *  增加条件
     * @param unknown $condition
     */
    public function where($condition )
    {
        if ($condition != null && !is_array($condition)) {
            if($this->condition_str=="")
            {
                $this->condition_str= $condition ;
            }else{
                $this->condition_str= $this->condition_str." ". $condition ;
            }
            
            $data=["condition_str"=>$this->condition_str];
            if (count($this->condition) == 0) {
                $this->condition = $data;
            } else {
                $this->condition = $this->condition." ". $data;
            }
            
        }else{

            if (count($this->condition) == 0) {
                $this->condition = $condition;
            } else {
                $this->condition = $this->condition ." ".$condition;

            }

        }

        # dongdong 添加
        $where = $this->wherestr;
        $type = gettype($condition);

        switch (gettype($condition)) {
            case 'string':
                if (strpos($where,'where') === false) {
                    $where = ' where '.$condition;
                    $this->wherestr = $where;
                } else {
                    $this->wherestr .= ' and '. $condition;
                }
                break;
            case 'array':
                $wherearr = explode('and', $where);
                foreach ($condition as $key=>$val) {
                    $wherearr[] = $key.' = \''.$val.'\'';
                }
                if (strpos($where,'where') === false) {
                    $where = ' where '.$wherearr[0];
                    unset($wherearr[0]);
                    $where_dev = implode(' and ', $wherearr);
                    $this->wherestr = $where.$where_dev ;
                } else {
                    $where_dev = implode(' and ', $wherearr);
                    $this->wherestr = $where_dev ;
                }

                break;
        }

        
        //print_r($this) ;die;
        return $this;
    }
    
    

    /**
     * 增加条件
     * @param unknown $condition
     */
//     public function andwhere($condition = array())
//     {
//         if (count($this->$condition) == 0) {
//             $this->condition = $condition;
//         } else {
//             $this->condition = $this->$condition + $condition;
//         }
        
//         return $this;
//     }

    /**
     * having字句可以让我们筛选成组后的各种数据，where字句在聚合前先筛选记录，也就是说作用在group by和having字句前。而 having子句在聚合后对组记录进行筛选。
     * 
     * @param string $column            
     */
    public function having($having)
    {
        if($this->having=="" || empty($this->having ))
        {
            $this->having = $having;
        }else 
        {
            $this->having =$this->having. " and " . $having;
            
        }
       
        return $this;
    }

    /**
     * 此方法是排序查询；
     * @param string $order
     */
    public function orderBy($order = '{$this->pk} desc')
    {
        if($this->order=="" || empty($this->order ))
        {
            $this->order = $order;
        }else
        {
            $this->order = $this->order .",". $order;
        }
       
        return $this;
    }
    
    /**
     * 此方法是group查询；
     * @param string $order
     */
    public function groupBy($group = '')
    {
        if($this->group=="" || empty($this->group ))
        {
             $this->group = $group;
             $this->column = $group;
        }else
        {
            $this->group =$this->group .",". $group;
            $this->column =$this->group .",". $group;
        }
        
       
        return $this;
    }

    /**
     * 设置返回数量
     * 
     * @param number $startSet            
     * @param number $endSet            
     */
    public function limit($startSet = 0, $endSet = 10)
    {
        $this->startSet = $startSet;
        $this->endSet = $endSet;
        return $this;
    }

    /**
     * 返回所有
     */
    public function all()
    {
        if(count($this->result)==0)
        {
            $result = $this->do_sql();
        }else
        {
            $result=$this->result;
        }
        $this->clearData();
        return $result;
    }

    /**
     * 返回所有
     */
    public function get()
    {
        if(count($this->result)==0)
        {
            $result = $this->do_getsql();

        }else
        {
            $result=$this->result;

        }
        $this->clearData();
        return $result;
    }
    private function do_getsql()
    {
        $where = str_replace('where','', $this->wherestr);

//        echo "\n\rAAA".$this->wherestr."AAA$where \n\r";
        $result = $this->db->query($this->table, $this->column, $where, $this->group, $this->order, $this->having, $this->startSet, $this->endSet, "assoc",null);
        return $result;
    }
    /**
     * 执行查询
     */
    private function do_sql()
    {

        $result = $this->db->query($this->table, $this->column, $this->condition, $this->group, $this->order, $this->having, $this->startSet, $this->endSet, "assoc",null);
        return $result;
    }
    
    
    /**
     * 返回主键的值等于 $pk_val的记录
     * @param unknown $pk_val
     */
    public function findOne($pk_val)
    {
        $this->condition = [$this->pk => $pk_val];
        $result = $this->all();
        if(empty($result))
            return "";
        return $result[0];
    }


    /**
     * 返回字段值
     * @param $pk_val
     * @return mixed|string
     */
    public function value($pk_val){
        $this->condition = $pk_val;
        $result = $this->all();
        if(empty($result))
            return "";
        return $result[0];
    }
    
    
    
    /**
     * 此方法返回记录的数量
     */
    public function count()
    {
        if(count($this->result)==0)
        {
            $result = $this->all();
            
        }else
        {
            $result=$this->result;
        
        }
        
        $num = count($result);
        return $num;
        
    }
    
    /**
     * 此方法返回一条数据
     */
    public function one()
    {
        if(count($this->result)==0)
        {
            $this->startSet = 0;
            $this->endSet = 1;
            $result = $this->all();
        }else 
        {
            $result=$this->result;
            
        }
        $this->clearData();
        return isset($result[0])?$result[0]:$result;
    }
    
    
    /**
     * 此方法是用 sql  语句查询 ；
     * @param unknown $sql_str
     */
    public function findBySql($sql_str)
    {
        //echo "<br>".$sql_str;flush();
        $result = $this->db->getValueBySelfCreateSql($sql_str);
        $this->result = $result;
        return $this->result;
    }
    
    
    /**
     *  此方法是用 like , in , <> 查询 数据
     * @param unknown $condition
     */
    public function andFilterWhere($condition = array())
    {
       //['like', 'name', '小伙儿']
       $_condition = $condition[0];
       $_k = $condition[1];
       $_v = $condition[2];
       
       if($_condition=="like")
       {
       $_having_str = " {$_k} {$_condition} '%{$_v}%' ";    
       }
       
       if($_condition=="<>")
       {
           $_having_str = " {$_k} {$_condition} '{$_v}' ";
       }
       
       if($_condition=="in")
       {
           $_having_str = " {$_k} {$_condition} ({$_v}) ";
       }
       $this->having($_having_str);
       
        return $this;
    }
    
    /**
     *  此方法是用 sql 直接 查询 数据
     * @param unknown $condition
     */
    public function andStringWhere($condition = "")
    { 
        
        $this->having($condition);
         
        return $this;
    }
    
    
    
    /**
     * 自动插入记录[单条]
     *
     * @access public
     * @param $list array
     *            关联数组
     * @return mixed 成功返回插入的id，失败则返回false
     */
    public function insert($list,$type=true)
    {
        //验证和处理
        $this->helper('input');
        if ($type) {
            $list= deepspecialchars($list);
            $list= deepslashes($list);
        }

        $field_list = ''; // 字段列表字符串
        $value_list = ''; // 值列表字符串
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields)) {
                $field_list .= "`" . $k . "`" . ',';
                $value_list .= "'" . $v . "'" . ',';
            }
        }
        // 去除右边的逗号
        $field_list = rtrim($field_list, ',');
        $value_list = rtrim($value_list, ',');
        // 构造sql语句
        $sql = "INSERT INTO `{$this->table}` ({$field_list}) VALUES ($value_list)";

        if ($this->db->exec($sql)) {
            // 插入成功,返回最后插入的记录id
            $this->clearData();
            return $this->db->getInsertId();
            // return true;
        } else {
            // 插入失败，返回false
            return false;
        }
    }
    
    
    /**
     * 自动更新记录
     *
     * @access public
     * @param $list array
     *            需要更新的关联数组
     * @return mixed 成功返回受影响的记录行数，失败返回false
     */

    public function update($list,$type=true)
    {
        //验证和处理
        $this->helper('input');

        if ($type) {
            $list= deepspecialchars($list);
            $list= deepslashes($list);
        }


        $uplist = ''; // 更新列表字符串
        $where = 0; // 更新条件,默认为0
        foreach ($list as $k => $v) {
            if (in_array($k, $this->fields)) {
                if ($k == $this->fields['pk']) {
                    // 是主键列，构造条件
                    $where = "`$k`=$v";
                } else {
                    // 非主键列，构造更新列表
                    $uplist .= "`$k`='$v'" . ",";
                }
            }
        }
        
        //链式查询where start
        if (is_array($this->condition) && count($this->condition)>0) {
            foreach ($this->condition as $key => $value) {
                if($key=="condition_str")
                {
                    if($where=='0')
                    {
                        $where = $value;
                    }
                    else {
                        $where = $where . $value;
                    }
                    continue;
                }
                
                if($where=='0')
                {
                    $where = " {$key} = '{$value}'  ";
                }
                else {
                    $where = $where . " and {$key} = '{$value}'  ";
                }
                
            }
            
        }
        
         
        
         
        
        if ($this->having != "") {
            if($where=='0')
            {
                $where = "  having {$this->having}  ";
            }
            else {
                $where = $where ." and   having {$this->having}   ";
            }
             
        }
        //链式查询where end
        
        // 去除uplist右边的
        $uplist = rtrim($uplist, ',');
        // 构造sql语句
        $sql = "UPDATE `{$this->table}` SET {$uplist} WHERE {$where}";
        // echo $sql;die();
        if ($rows = $this->db->exec_update_delete($sql)) {
            // 成功，并判断受影响的记录数
            if ($rows ) {
                // 有受影响的记录数
                $this->clearData();
                return $rows;
            } else {
                // 没有受影响的记录数，没有更新操作
                $this->clearData();
                return false;
            }
        } else {
            // 失败，返回false
            $this->clearData();
            return false;
        }
    }
    
    
    
    /**
     * 自动删除
     *
     * @access public
     * @param $pk mixed
     *            可以为一个整型，也可以为数组
     * @return mixed 成功返回删除的记录数，失败则返回false
     */
    public function delete($pk="")
    {
        $where = 0; // 条件字符串
        
        if(!empty($pk) && $pk!="")
        {
            // 判断$pk是数组还是单值，然后构造相应的条件
            if (is_array($pk)) {
                // 数组
                $where = "`{$this->fields['pk']}` in (" . implode(',', $pk) . ")";
                //echo $where;die();
            } else {
                // 单值
                $where = "`{$this->fields['pk']}`=$pk";
            }  
        }
        
        
        
        //链式查询where start
        if (is_array($this->condition) && count($this->condition)>0) {
            foreach ($this->condition as $key => $value) {
                if($key=="condition_str")
                {
                    if($where=='0')
                    {
                        $where = $value;
                    }
                    else {
                        $where = $where . $value;
                    }
                    continue;
                }
                
                if($where=='0')
                {
                    $where = " {$key} = '{$value}'  ";
                }
                else {
                    $where = $where . " and {$key} = '{$value}'  ";
                }
                
            }
            
        }
        
         
        
        
        
        
        if ($this->having != "") {
            if($where=='0')
            {
                $where = "  having {$this->having}  ";
            }
            else {
                $where = $where ." and   having {$this->having}   ";
            }
             
        }
        //链式查询where end
        
        
        
        // 构造sql语句
        $sql = "DELETE FROM `{$this->table}` WHERE $where";
        //die($sql);
        if ($rows =$this->db->exec_update_delete($sql)) {
            // 成功，并判断受影响的记录数
            if ($rows) {
                // 有受影响的记录
                $this->clearData();
                return $rows;
            } else {
                // 没有受影响的记录
                return false;
            }
        } else {
            // 失败返回false
            return false;
        }
    }
    
    
    
    /**
     * 根据传递的参数，返回接收数组
     */
    public function getFieldArray()
    {
        $fields_temp = $this->fields;
        $fields_temp = array_unique($fields_temp);
        foreach ($fields_temp as $k => $v) {//
            if (isset($_REQUEST[$v]) ) {
                $data[$v] = $_REQUEST[$v];
            }else if( $k != $this->pk)
            {
                //$data[$v]='';
            }
        }

        //var_dump($data);die();
        return $data;
    }
    
    
    /**
     * 根据传递的参数，自动获得SQL的条件语句
     */
    public function getSqlWhereStr($andOror="and")
    {
        $sql="";
        $fields_temp = $this->fields;
        $fields_temp = array_unique($fields_temp);
        foreach ($fields_temp as $k => $v) {
            if (isset($_REQUEST[$v]) && $_REQUEST[$v] != '') {
                $sql = $sql . $v . "='{$_REQUEST[$v]}' {$andOror} ";
            }
        }
        $sql .= " 1=1 ";
        return $sql;
    }
    
    /**
    
    * 自动组合时间查询
    
    * @date: 2018年10月4日 上午11:14:38
    
    * @author: 龚华尧
    
    * @param: 字段名称
    
    * @return:
    
    */
    public function getDtimeSql($time_str = 'dtime')
    {
        $dateArr =  explode(" - ",$this->common->Requert($time_str));
        $dtime_str = $dateArr[0];
        $dtime_end = $dateArr[1];
        
        $sql=" ";
        if (isset($dtime_str) && $dtime_str!= '') {
            $dtime_str = $dtime_str."  00:00:00";
        }
        if (isset($dtime_end) && $dtime_end!= '') {
            $dtime_end = $dtime_end."  23:59:59";
        }
        if ((isset($dtime_str) && $dtime_str != '') && (! isset($dtime_end) && $dtime_end == '')) {
            $sql = " {$time_str} >= '{$dtime_str}' and  {$time_str} <= NOW() ";
        } else
            if ((isset($dtime_str) && $dtime_str != '') && (isset($dtime_end) && $dtime_end != '')) {
                $sql = "  {$time_str} >= '{$dtime_str}' and  {$time_str} <= '{$dtime_end}'  ";
            }
        return $sql;
    }
    
    
    /**
     * 此方法是用 sql  语句查询 ；
     * @param unknown $sql_str
     */
    public function query($sql_str)
    {
        $result = $this->db->exec_update_delete($sql_str);
       return $result;
    }
    
    public function start_T() {
        $this->db->begin();//开始事务
    }
    
    public function roll_T() {
        $this->db->rollback();//回滚事务
    }
    
    public function comit_T() {
        $this->db->commit();//提交事务
    }
    
    
    
    /**
     * 获取表字段和类型列表
     */
    public function getFieldsAndTypes()
    {
        $sql = "SELECT ORDINAL_POSITION as id , column_name ,data_type ,character_maximum_length ,numeric_precision,numeric_scale,is_nullable ,column_default ,column_comment
        FROM
        Information_schema.columns
        WHERE TABLE_NAME='{$this->table}'";
        $result = $this->db->getValueBySelfCreateSql($sql);
        /*
         * foreach ($result as $v) {
         * $this->fieldsandtpyes[]=array("{$v['Field']}"=>array("type"=>"{$v['Type']}"));
         *
         * }
         */
        return $result;
    }
    
    //获取所有的数据
    public function getlistBylimit($page=0,$limit=10){
        $page = $page==""?0:($page-1);
        $limit= $limit==""?0:$limit;
        return $this->limit($page*$limit,$limit)->all();
        
    }
    
    
    //清空数据
    public function clearData(){
         $this->condition = array();

         $this->condition_str ="";
        
         $this->group="";
        
         $this->order="";
        
         $this->having="";
        
         $this->startSet="";
        
         $this->endSet="";

         $this->wherestr = '';

         $this->column = '*';
        
    }
    
    /**
    
    * 打印当前sql
    
    * @date: 2018年9月18日 下午4:42:14
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    public function printSql()
    {
        $sqlstr = $this->db->printSql($this->table, $this->column, $this->condition, $this->group, $this->order, $this->having, $this->startSet, $this->endSet, "assoc",null);
        echo $sqlstr;
        $this->clearData();
        die();
    }
    
    //引入辅助函数方法
    public function helper($helper){
        include_once HELPER_PATH . "{$helper}.php";
    }
    
    
    public  function getCountNum()
    {
        $sql = "select count(id) as countnum from {$this->table} ";
        return $this->db->getAll($sql)[0]['countnum'];
        
    }
    
    
    /**
     * 获取总的记录数
     *
     * @param string $where
     *            查询条件，如"id=1"
     * @return number 返回查询的记录数
     */
    public function total($where)
    {
        if (empty($where)) {
            $sql = "select {$this->fields['pk']} from {$this->table}";
        } else {
            $sql = "select {$this->fields['pk']} from {$this->table} where $where";
        }
        return count($this->db->getValueBySelfCreateSql($sql));
    }
    
    
    /**
     * 分页获取信息
     *
     * @param $offset int
     * 偏移量
     * @param $limit int
     * 每次取记录的条数
     * @param $where string
     * where条件,默认为空
     */
    public function pageRows($offset, $limit, $where = '', $orderby = 'id desc')
    {
        $temp_orderby=$orderby ;
        
        if (empty($where)) {
            $sql = "select * from {$this->table} " . "  order by $temp_orderby   " . " limit $offset, $limit";
        } else {
            $sql = "select * from {$this->table}  where $where " . "  order by  $temp_orderby  " . " limit $offset, $limit";
        }
        
        return $this->db->getValueBySelfCreateSql($sql);
    }

    /**
     *  批量插入数据
     * @param $table 表名
     * @param array $data
     * @return string
     */
    public function addAll(array $data)
    {
        $table = $this->table;
        $clons = $this->db->getColumns($data);
        $values =$this->db->getValues($data);
        $sql = "insert into {$table}({$clons})values{$values}";
        return $this->query($sql);
    }

    /**
     * Notice:分页数据
     * Date: 2018/12/20
     * Time: 17:15
     * @author dongdong
     */
    public  function paginate($limit=null)
    {
        $data =  $this->condition;
        $where = $this->wherestr;

        $order =  $this->order;
        $painate = Request::getInstace()->paginate();
        $offset = ($painate->page - 1) * $painate->limit;
        $limit = $limit?:$painate->limit;
//        var_dump($order);die;
        $temp_orderby = $order?'order by'.$order:'';

        if (empty($where)) {
            $sql = "select * from {$this->table} " . "   $temp_orderby   " . " limit $offset, $limit";
            $numsql = "select count(1) as num from {$this->table} ";
        } else {
            $sql = "select * from {$this->table}   $where " . "    $temp_orderby  " . " limit $offset, $limit";
            $numsql= "select count(1) as num from {$this->table}   $where ";
        }

        $data =  $this->db->getValueBySelfCreateSql($sql);
        # 总数量
        $datanNum = $this->db->getValueBySelfCreateSql($numsql);
        $num = isset($datanNum[0]['num'])? $datanNum[0]['num'] : 0;

        # current page
        return [
            'data'=> $data,
            'count' => $num,
            'current_page' => $painate->page?:1,
            'limit' => $limit,
            'allpage' => floor($num/$limit)?:1
        ];
    }

    public function whereIn($filed,$data)
    {   $where = $this->wherestr;

        # dongdong 添加
        $where = $this->wherestr;
        if (strpos($where, 'where') === false) {
            $where = ' where 1=1 '.$where;
        }
        $wherearr = explode('and', $where);

        $str = implode(',', $data);
        $wherearr[] = $filed." in (".$str.")";
        $where = implode(' and ', $wherearr);
        $this->wherestr = $where;
//        var_dump($this->wherestr);
        return $this;
    }

    public function whereNotIn($filed,$data) {
        if (!$data||empty($data)) {
            return $this;
        }
        $where = $this->wherestr;
        # dongdong 添加
        $where = $this->wherestr;
        if (strpos($where, 'where') === false) {
            $where = ' where 1=1 '.$where;
        }
        $wherearr = explode('and', $where);

        $str = implode(',', $data);
        $wherearr[] = $filed." Not in (".$str.")";
        $where = implode(' and ', $wherearr);
        $this->wherestr = $where;
        echo $where;die;
//        var_dump($this->wherestr);
        return $this;
    }

    /**
     * Notice: 求平均数
     * Date: 2019/1/28
     * Time: 17:08
     * @author dongdong
     */
    public function avg($filed)
    {
        $data =  $this->condition;
        $where = $this->wherestr;

        $order =  $this->order;
        $painate = Request::getInstace()->paginate();
        $offset = ($painate->page - 1) * $painate->limit;
        $temp_orderby = $order?'order by'.$order:'';
        if (empty($where)) {
            $sql = "select avg({$filed}) as avgdata from {$this->table}  " .$temp_orderby ;
        } else {
            $sql = "select avg({$filed}) as avgdata from {$this->table}   $where " .$temp_orderby  ;
        }
        $data =  $this->db->getValueBySelfCreateSql($sql);
        return $data[0]['avgdata'];
        # 总数量
    }

}