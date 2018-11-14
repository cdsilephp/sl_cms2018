<?php
//商品类型模型
class groupModel extends Model {
    
    public function __construct()
    {
        parent::__construct("group");
    }
    
    
    public function getall()
    {
        $grouplist = $this->all();
        foreach ($grouplist as $k=>$v)
        {
            $adminModel = new adminModel();
            $grouplist[$k]["memberNum"]=count($adminModel->where(["group_id"=>$v['id']])->all());
        }
        
        return  $grouplist;
        
    }
	


}