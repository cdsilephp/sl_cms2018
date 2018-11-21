<?php
//后台管理员控制器
class installController extends baseController {
	
	//后台首页
	public function indexAction(){
	    
	    
	    
	    include CUR_VIEW_PATH . "Sinstall".DS."install_index.html";
	}
	
	 
	 /**
	 
	 * 执行安装操作
	 
	 * @date: 2018年11月6日 下午2:23:17
	 
	 * @author: 龚华尧
	 
	 * @param: variable
	 
	 * @return:
	 
	 */
	public function installsystemAction(){
	    $data_return["status"]=false;
	    $data_return["msg"]="";
	    $data_return["code"]=1;
	    
	    //配置文件地址
	    $filename =  CUR_CONFIG_PATH. "db.config.php";
	    
	    if(file_exists($filename))
	    {
	        $data_return["msg"]="数据库配置文件已存在";
	           //$this->common->ajaxReturn($data_return);
	    }
	    //获取条件及数据
	    $post_data = $_POST;
	    $settingstr = "<?php \n return array(\n";
	    foreach ( $post_data as $key => $v ) {
	        $settingstr .= "\n\t'" . $key . "'=>'" . $v . "',";
	    }
	    $settingstr .= "\n);\n\n";
	    
	    //var_dump($settingstr);die();
	    //创建配置文件
	    $this->common->mkfile($settingstr, $filename);
	    
	    //导入sql文件
	    $sqlfilename = "sl_cms.sql";
	    $sqlstr = $this->common->getfilecontent($sqlfilename);
	    
	    $dbconfig['host'] = $post_data['host'];
	    $dbconfig['user'] = $post_data['user'];
	    $dbconfig['password'] = $post_data['password'];
	    $dbconfig['dbname'] = $post_data['dbname'];
	    $dbconfig['port'] = $post_data['port'];
	    $dbconfig['charset'] = $post_data['charset'];
	    $db = new CPdo(false, $dbconfig);
	    $db->exec($sqlstr);
	    
	    
	    $data_return["status"]=true;
	    $data_return["msg"]="修改成功";
	    $data_return["code"]=0;
	    $this->common->ajaxReturn($data_return);
	    
	    
	}
	
	
	 
}