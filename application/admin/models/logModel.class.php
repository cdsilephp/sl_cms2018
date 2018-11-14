<?php
//日志模型
class logModel extends Model {
    public function __construct()
    {
        parent::__construct("log");
    }
    
	//获取所有的日志
	public function getall($page=0,$limit=10){
	    $page = $page==""?0:($page-1);
	    $limit= $limit==""?0:$limit;
		return $this->limit($page*$limit,$limit)->all();
		
	}

    //添加日志
	public function addlog($u1,$u2,$u3,$u4)
	{
		$data['u1'] = $u1;
		$data['u2'] = $u2;
		$data['u3'] = $u3;
		$data['u4'] = $u4;
		
		//2.验证和处理
		$this->helper("input");
		
		$data = deepspecialchars($data);
		$data = deepslashes($data);

		$this->insert($data);
	}


}