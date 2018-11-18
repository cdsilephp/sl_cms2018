<?php
//商品的所有规格标签
class goodsparameteritemModel extends Model
{
    private $str;  
    public function __construct()
    {
        parent::__construct("goodsparameter_item");
    }
       
    /**
    
    * 插入具体商品规格
    
    * @date: 2018年11月18日 上午4:04:03
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    public  function insertItemBygoodsparameterids($ids,$goodnumber="") {
        $goodsparameter = new goodsparameterModel();
        $goodsparameterList = $goodsparameter->where("id in ({$ids}) ")->all();
        foreach ($goodsparameterList as $k=>$v)
        {
            $data["goodsparameter_id"]=$v["id"];
            $data["goodsparameter_name"]=$v["u1"];
            $data["goodsnumber"]=$goodnumber;
            $this->insert($data);
        }
        
    }
    
    /**
    
    * 删除某个商品的规格
    
    * @date: 2018年11月18日 上午3:46:40
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    public function deleteItemBygoodnumber($goodnumber) {
        $this->where("goodsnumber = {$goodnumber} ")->delete();
    }
    
    
    
    
    /**
    
    * 获取商品的规格ID
    
    * @date: 2018年11月18日 上午4:32:46
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    
    public function getGoodsparameteridsBygoodnumber($goodnumber) {
        $GoodsparameterList = $this->where("goodsnumber = {$goodnumber} ")->all();
        $ids="";
        foreach ($GoodsparameterList as $k=>$v)
        {
            if($ids=="")
            {
                $ids=$v["goodsparameter_id"];
            }else{
                $ids=$ids.",".$v["goodsparameter_id"];
            }
            
        }
        return $ids;
        
    }
   
}