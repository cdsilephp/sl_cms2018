<?php
// 文章分类模型
class parameterModel extends Model
{
    private $str;  
    public function __construct()
    {
        parent::__construct("parameter");
    }
       
    //
    public function getparameterByclassid($classid){
        $sql = "SELECT *, u1 as name,classid as parentid  FROM {$this->table}  " ;
        if($classid!='')
        {
            $sql.=" where classid='$classid' ";
        }
        $sql.=" order by u4 asc,id asc";
        
        return $this->db->getAll($sql);
        //对获取的分类进行重新排序
        
    }
   
   //得到当前parameter_id到底层的json
   public function getparameterName($parameterId,$temp_arr)
   {
      
       $Currentparameter=$this->findBySql("select id as value, u1 as text from sl_parameter where id={$parameterId}");
       $Childrenparameter=$this->findBySql("select * from sl_parameter where classid={$Currentparameter[0]['value']}");
       if($temp_arr=="")
       {
           $temp_arr=$Currentparameter;
       }
       if(count($Childrenparameter)>0)
       {
           //该parameter_id的父级存在
           $temp_arr["children"]=$Childrenparameter;
           $this->getparameterNames($parentparameter[0]['value'],$temp_arr);
       } else 
       {
           $this->str=$temp_arr;
           
       }
   }
   
   
   public function getparameterNames($curparameterId,$ChildparameterNames)
   {
      $this->getparameterName($curparameterId,$ChildparameterNames);
      return $this->str;
   }
   
   
   
}