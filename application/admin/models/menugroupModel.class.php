<?php
//商品类型模型
class menugroupModel extends Model {
    
    public function __construct()
    {
        parent::__construct("menu_group");
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


	 
	 

	
	public  function getmenuByUsergroup($groupid) {
	    $data = $this->find("u3,u1,id,classid,icon")->where(["group_id"=>$groupid,"u4"=>"显示"])->orderBy("u2 asc")->all();
	    $data = $this->child($data);
	    return $data;
	}
	 



}