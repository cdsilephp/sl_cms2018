<?php
// 文章分类模型
class sortModel extends Model
{
    private $str;   
    public function __construct()
    {
        parent::__construct("sort");
    }
    
    //
    public function getsortByclassid($classid){
        $sql = "SELECT *, u1 as name,classid as parentid  FROM {$this->table}  " ;
        if($classid!='')
        {
            $sql.=" where classid='$classid' ";
        }
        $sql.=" order by u4 asc,id asc";
        
        return $this->db->getAll($sql);
        //对获取的分类进行重新排序
        
    }
    
    
    /*
     * 把sort 及其子级添加到栏目
     * id 当前sort 的id
     * date 为添加的栏目数组
     */
   public  function addSubSortTomenu($sortid,$menu_id,$data) {
      
      $menuModel=new menuModel();
      
       //如果当前的sort所在id还有子级
       $sort=$this->selectByArrayAnd(array("sort_id"=>$sortid));
      
       if(count($sort)>0)
       {
           foreach ($sort as $v)
           {
               //print_r($v);
               $temp_data=$data;
               //将本级sort添加到栏目
               $temp_data['classid']=$menu_id;
               $temp_data['u1']=$v['u1'];
               $temp_data['u3']=str_replace("sort_id={$sortid}", "sort_id={$v['id']}", $temp_data['u3']);
               
               $menuModel->insert($temp_data);
               $menu_id_next=$menuModel->select("select * from `sl_column` where  u1 = '{$v['u1']}'   ORDER BY id desc LIMIT 1");
               $menu_id_next=$menu_id_next[0]['id']==''?$temp_data['classid']:$menu_id_next[0]['id'];

               $this->addSubSortTomenu($v['id'],$menu_id_next,$temp_data);
               
           }
          
       }
       
   }

/*
    * 将model 及其所有sort全部添加到栏目
    * 
    * 
    */
  /* public function addModelTomenu($model_id,$menu_id,$data) {
        $menuModel=new menuModel();
        $sort=$this->selectByArrayAnd(array("model_id"=>$model_id,"sort_id"=>0));
        
        //如果这个模型存在分类
        if(count($sort)>0)
        {
            foreach ($sort as $v)
            {
            $temp_date=$data;
            $temp_date['u3']= $temp_date['u3'].$v['id'];
            $temp_date['u1']=$v['u1'];
            $temp_date['classid']=$menu_id;
            
            //将第一级sort插入栏目
            $menuModel->insert($temp_date);
            $menu_id=$menuModel->select("select * from `sl_column` where classid = '{$temp_date['classid']}' and u1 = '{$temp_date['u1']}'  ORDER BY id desc LIMIT 1");
            $menu_id=$menu_id[0]['id'];
            
            $this->addSubSortTomenu($v['id'], $menu_id, $temp_date);
            }
        }
        
        
   } */
   
   
   //得到当前sort_id到顶级的字符串
   public function getSortName($curSortId,$ChildSortNames)
   {
      
       $CurrentSort=$this->select("select * from sl_sort where id={$curSortId}");
       $parentSort=$this->select("select * from sl_sort where id={$CurrentSort[0]['sort_id']}");
       if(count($parentSort)>0)
       {
           //该sort_id的父级存在
           $sortNames="<a href='/index.php?c=list&sort_id={$parentSort[0]['id']}'>".$parentSort[0]['u1']."</a>".">". $CurrentSort[0]['u1'];
          $this->getSortNames($parentSort[0]['id'],$sortNames);
       } else 
       {
           $this->str=$ChildSortNames;
           
       }
   }
   
   
   public function getSortNames($curSortId,$ChildSortNames)
   {
      $this->getSortName($curSortId,$ChildSortNames);
      return $this->str;
   }
   
   
   //对给定的数组进行重新排序
   public function tree($arr,$pid = 0,$level = 0){
       static $res = array();
       foreach ($arr as $v){
           if ($v['classid'] == $pid) {
               //说明找到，先保存
               $v['level'] = $level;
               $res[] = $v;
               //改变条件，递归查找
               $this->tree($arr,$v['id'],$level+1);
           }
       }
       return $res;
   }
   
   
   //将平行的二维数组，转成包含关系的多维数组
   public function child($arr,$pid = 0){
       $res = array();
       foreach ($arr as $v) {
           if ($v['classid'] == $pid) {
               //找到了，继续查找其后代节点
               //$temp = $this->child($arr,$v['cat_id']);
               //将找到的结果作为当前数组的一个元素来保存，其下标是child
               //$v['child'] = $temp;
               $v['child'] = $this->child($arr,$v['id']);
               $res[] = $v;
               unset($v);
           }
           
       }
       return $res;
   }
   
   
   public function getSEOBysort_id($sort_id){
       $data["t"]="";
       $data["d"]="";
       $data["k"]="";
       if($sort_id==""){
           $data["t"]=$GLOBALS['config_cache']['SEOTITLE'];
           $data["d"]=$GLOBALS['config_cache']['SEODESCRIPTION'];
           $data["k"]=$GLOBALS['config_cache']['SEOKEYWORDS'];
       }else{
           $sortdetail = $this->findOne($sort_id);
           $data["t"]=$sortdetail['u6'];
           $data["d"]=$sortdetail['u8'];
           $data["k"]=$sortdetail['u7'];
           
       }
       return $data;
       
   }
   
   public function getsortNameBysortid($sort_id){
       
       return $this->findOne($sort_id)['u1'];
       
   }
   
}