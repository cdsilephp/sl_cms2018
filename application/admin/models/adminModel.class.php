<?php
//后台管理员模型
class adminModel extends Model {
    
    public function __construct()
    {
        parent::__construct("admin");
    }
    
	 

	//验证用户名和密码
	public function checkUser($username,$password){
	    $common = $this->common;
	    $data["status"]=false;
	    $data["msg"]="";
	    // 验证和处理
	    if (! ($common->isEmpty($username) || $common->isEmpty($password))) {
	        $data["msg"]="用户名或密码不能为空";
	        return $data;
	    }
	    
	    $adminDetail = $this->where(["username"=>$username])->one();
	    if(!empty($adminDetail))
	    { 
	        if($adminDetail["password"] ==md5($password) ) {
	           $data["status"]=true;
	           $adminDetail["access_token"]=$common->encrypt($adminDetail["id"]);
	           $data["msg"]=$adminDetail;
	           $_SESSION['admin']['captcha']="";
	           
	       }else{
	           $data["msg"]="密码错误";
	       }
	       
	    }else{
	        $data["msg"]="用户不存在";
	    }
	    
	    return $data;
	    
	}
	
	
	//save session 
	public function saveAdminSession($admindetal) {
	    $common = $this->common;
	    $admin_arr =$admindetal;
	    $_SESSION['admin']['username'] = $admin_arr['username'];
	    $_SESSION['admin']['user_id'] = $admin_arr['user_id'];
	    $_SESSION['admin']['password'] = $admin_arr['password'];
	    $_SESSION['admin']['pic'] = $admin_arr['pic'];
	    $_SESSION['admin']['group_id'] = $admin_arr['group_id'];
	    //$_SESSION['admin']['zuming'] = $admin_arr['zuming'];
	    $_SESSION['admin']['access_token'] = $admin_arr['access_token'];
	    //更新登录时间和登录IP
	    $admin_arr["last_login_time"]=date("Y-m-d h:i:s",time());
	    $admin_arr["last_login_ip"]=$common->getIP();
	    $admin_arr["user_id"]=$admin_arr['user_id'];
	    $this->update($admin_arr);
	    
	    
	}


	public function getall()
	{
	    $adminlist = $this->findBySql("select a.*  ,g.zuming from sl_admin as a,sl_group as g where g.id =a.group_id ");
	    return  $adminlist;
	    
	}
	
	
}