<?php
//商品类型模型
class menuModel extends Model {
    
    public function __construct()
    {
        parent::__construct("menu");
    }
    
    
	//
	public function getmenuByclassid($classid){
		$sql = "SELECT *,u1 as name,classid as parentid  FROM {$this->table}  " ;
		if($classid!='')
		{
			$sql.=" where classid='$classid' ";
		}
		$sql.=" order by u2 asc,id asc";

		return $this->db->getAll($sql);
		//对获取的分类进行重新排序
		
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


	public function tree_ghy($arr,$pid = 0,$level = 0){
				//$res = array(); //$res是一个局部变量
		static $res = array();
				//global $res;
		foreach ($arr as $v) {
			if ($v['classid'] == $pid ) {
				//说明找到,首先保存
				$v['level'] = $level;
				$res[] = $v;
				$this->load_lianmuList($v,$level);
				//改变添加，找当前分类的后代分类，就是递归
				$this->tree_ghy($arr,$v['id'],$level + 1);
				//load_html($v,$level);
			}
		}
		
	}
	


}