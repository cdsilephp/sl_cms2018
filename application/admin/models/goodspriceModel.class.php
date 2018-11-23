<?php
// 文章分类模型
class goodspriceModel extends Model
{
    private $str;  
    public function __construct()
    {
        parent::__construct("goodsprice");
    }
       
    //获取所有的商品价格
    public function getgoodspriceBygoodsnumber($page=0,$limit=10,$goods_number=""){
        $page = $page==""?0:($page-1);
        $limit= $limit==""?0:$limit;
        $where =$goods_number=="" ?"" :" goods_number='{$goods_number}' ";
        
        return $this->where($where)->limit($page*$limit,$limit)->all();
        
    }
    
    
    //重现计算商品价格
    public function refreshgoodspriceBygoodsnumber($goods_number,$goods_price=0,$goods_stock=0){
        $goodsparameteritemModel = new goodsparameteritemModel();
        //删除原来全部价格
        $this->where("goods_number='{$goods_number}' ")->delete();
        $goodsparameteritemList = $goodsparameteritemModel->find("*, goodsparameter_name as name,goodsparameter_classid as parentid ")->where("goodsnumber='{$goods_number}' ")->all();
        //挂载 TREE 类
        $this->helper('tree');
        $tree =new Tree($goodsparameteritemList) ;
        
        $_array =  array();
        foreach ($goodsparameteritemList as $k=>$v){
            $cur_id= $v["goodsparameter_id"];
            if( !is_array($tree->get_child($cur_id))  ){
                $parentid= $v["parentid"];
                $parent_child_array=$tree->get_child($parentid);
                $_array[$parentid] =$parent_child_array;
                
            }
            
        }
        
        $goodsparameter_names_array = array();
        $goodsparameter_ids_array = array();
        
        foreach ($_array as $k=>$v){
            $goodsparameter_names= "";
            $goodsparameter_ids= "";
            foreach ($v as $k1=>$v1){
                //处理名称
                if($goodsparameter_names=="")
                {
                    $goodsparameter_names=$v1["goodsparameter_name"];
                }else{
                    
                    $goodsparameter_names=$goodsparameter_names."|".$v1["goodsparameter_name"];
                }
                
                //处理IDS 
                if($goodsparameter_ids=="")
                {
                    $goodsparameter_ids=$v1["goodsparameter_id"];
                }else{
                    
                    $goodsparameter_ids=$goodsparameter_ids."|".$v1["goodsparameter_id"];
                }
                
            }
            $goodsparameter_names_array[] =explode('|', $goodsparameter_names);
            $goodsparameter_ids_array[] =explode('|', $goodsparameter_ids);
            
        }
        
        $goodsparameter_names_array=$this->CartesianProduct($goodsparameter_names_array,",");
        $goodsparameter_ids_array=$this->CartesianProduct($goodsparameter_ids_array,",");
        
        //插入价格表
        foreach ($goodsparameter_names_array as $k=>$v)
        {
            $data_goodsprice["goods_number"]=$goods_number;
            $data_goodsprice["goodsparameter_names"]=$goodsparameter_names_array[$k];
            $data_goodsprice["goodsparameter_ids"]=$goodsparameter_ids_array[$k];
            $data_goodsprice["goods_price"]=$goods_price;
            $data_goodsprice["goods_stock"]=$goods_stock;
            $this->insert($data_goodsprice);
        }
        
         
        
    }
    
    
    /**
     * php 计算多个集合的笛卡尔积
     * Date:    2017-01-10
     * Author:  fdipzone
     * Ver:     1.0
     *
     * Func
     * CartesianProduct 计算多个集合的笛卡尔积
     */
    
    /**
     * 计算多个集合的笛卡尔积
     * @param  Array $sets 集合数组
     * @return Array
     */
    function CartesianProduct($sets,$str=""){
        
        // 保存结果
        $result = array();
        
        // 循环遍历集合数据
        for($i=0,$count=count($sets); $i<$count-1; $i++){
            
            // 初始化
            if($i==0){
                $result = $sets[$i];
            }
            
            // 保存临时数据
            $tmp = array();
            
            // 结果与下一个集合计算笛卡尔积
            foreach($result as $res){
                foreach($sets[$i+1] as $set){
                    $tmp[] = $res.$str.$set;
                }
            }
            
            // 将笛卡尔积写入结果
            $result = $tmp;
            
        }
        
        return $result;
        
    } 
   
   
   
}