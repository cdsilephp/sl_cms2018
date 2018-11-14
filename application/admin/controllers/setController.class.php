<?php
//后台首页控制器
class setController extends baseController {
	
	//后台首页
	public function indexAction(){
	     
	    include CUR_VIEW_PATH . "Sset".DS."index.html";
	}
	
	public function accountAction(){
	    
	    include CUR_VIEW_PATH . "Sset".DS."account.html";
	}
	
	
	public function updateAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    //配置文件地址
	    $filename =  CUR_CONFIG_PATH. "cache.config.php";
	    //检查文件是否可写
	    if (is_writable($filename) == false) {
	        $data_return["msg"]="请检查配置文件权限是否可写";
	        $this->common->ajaxReturn($data_return);
	        
	    }
	    
	    //获取条件及数据
	    $post_data = $_POST;

	    $settingstr = "<?php \n return array(\n";
	    foreach ( $post_data as $key => $v ) {
	        $settingstr .= "\n\t'" . $key . "'=>'" . $v . "',";
	    }
	    $settingstr .= "\n);\n\n";
	    
	    
	    file_put_contents ( $filename, $settingstr ); // 通过file_put_contents保存setting.config.php文件；
	    $data_return["status"]=true;
	    $data_return["msg"]="修改成功";
	    $data_return["code"]=0;
	    $this->common->ajaxReturn($data_return);

	}

	public function updateAccountAction(){
		$data_return["status"]=false;
		$data_return["msg"]="";
		$data_return["code"]=1;

		//配置文件地址
		$filename =  CUR_CONFIG_PATH. "account.config.php";
		//检查文件是否可写
		if (is_writable($filename) == false) {
			$data_return["msg"]="请检查配置文件权限是否可写";
			$this->common->ajaxReturn($data_return);

		}

		//获取条件及数据
		$post_data = $_POST;

		$settingstr = "<?php \n return array(\n";
		foreach ( $post_data as $key => $v ) {
			$settingstr .= "\n\t'" . $key . "'=>'" . $v . "',";
		}
		$settingstr .= "\n);\n\n";


		file_put_contents ( $filename, $settingstr ); // 通过file_put_contents保存setting.config.php文件；
		$data_return["status"]=true;
		$data_return["msg"]="修改成功";
		$data_return["code"]=0;
		$this->common->ajaxReturn($data_return);

	}
	 
	
	 
}