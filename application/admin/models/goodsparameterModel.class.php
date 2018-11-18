<?php
// 文章分类模型
class goodsparameterModel extends Model
{
    private $str;  
    public function __construct()
    {
        parent::__construct("goodsparameter");
    }
       
    //
    public function getgoodsparameterByclassid($classid){
        $sql = "SELECT *, u1 as name,classid as parentid  FROM {$this->table}  " ;
        if($classid!='')
        {
            $sql.=" where classid='$classid' ";
        }
        $sql.=" order by u4 asc,id asc";
        
        return $this->db->getAll($sql);
        //对获取的分类进行重新排序
        
    }
   
   //得到当前goodsparameter_id到底层的json
   public function getgoodsparameterName($goodsparameterId,$temp_arr)
   {
      
       $Currentgoodsparameter=$this->findBySql("select id as value, u1 as text from sl_goodsparameter where id={$goodsparameterId}");
       $Childrengoodsparameter=$this->findBySql("select * from sl_goodsparameter where classid={$Currentgoodsparameter[0]['value']}");
       if($temp_arr=="")
       {
           $temp_arr=$Currentgoodsparameter;
       }
       if(count($Childrengoodsparameter)>0)
       {
           //该goodsparameter_id的父级存在
           $temp_arr["children"]=$Childrengoodsparameter;
           $this->getgoodsparameterNames($parentgoodsparameter[0]['value'],$temp_arr);
       } else 
       {
           $this->str=$temp_arr;
           
       }
   }
   
   
   public function getgoodsparameterNames($curgoodsparameterId,$ChildgoodsparameterNames)
   {
      $this->getgoodsparameterName($curgoodsparameterId,$ChildgoodsparameterNames);
      return $this->str;
   }
   
   
   
}