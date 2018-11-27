<?php
// 后台登录控制器
class loginController extends Controller
{
    
    // 显示登录页面
    public function loginAction()
    {
        
        // 载入登录页面视图
        include CUR_VIEW_PATH . "login.html";
    }
    
    // 验证用户名和密码
    public function signinAction()
    {
        $data["status"]=false;
        $data["msg"]="";
        $data["code"]=1;
        $data["data"]["access_token"]="";
        
        // 获取用户名和密码
        $username = $this->common->Post("username");
        $password = $this->common->Post("password");
        $vercode= $this->common->Post("vercode");
        $vercode= strtolower($vercode);
        //$_SESSION['admin']['captcha']
        
        if($_SESSION['captcha']!==$vercode)
        {
            $data["msg"]="验证码错误";
            $this->common->ajaxReturn($data);
        }
        // 调用模型来完成验证操作并给出提示
        $adminModel = new adminModel();
        $logModel = new logModel();
        $loginResult = $adminModel->checkUser($username, $password);
        if ($loginResult["status"]) {
            $adminModel->saveAdminSession($loginResult["msg"]);
            // 写入日志
            $logModel->addlog($username, $username . ":登录成功,操作页面:" . $this->common->getUrl(), $this->common->getIP(), "管理员登录");
             
             
            $data["status"]=true;
            $data["code"]=0;
            $data["data"]["access_token"]=$loginResult["msg"]["access_token"];
            $data["msg"]="登录成功";
            
        } else {
            // 写入日志
            $logModel->addlog($username, $username . ":登录失败，用户名或密码错误。操作页面:" . $this->common->getUrl(), $this->common->getIP(), "管理员登录");
            // 失败
            $data["msg"]=$loginResult["msg"];
        }
        $this->common->ajaxReturn($data);
    }
    
    // 注销
    public function logoutAction()
    {
        // 删除session中的变量
        unset($_SESSION['admin']);
        // 销毁session
        session_destroy();
        // 跳转
        $this->jump('/admin/login/login', '已安全退出', 3);
    }
    
    // 生成验证码
    public function captchaAction()
    {
        error_reporting(E_ALL & ~E_NOTICE);
        // 引入验证码类
        $this->library('Captcha');
        // 实例化对象
        $captcha = new Captcha();
        // 生成验证码
        $captcha->generateCode();
        // 将验证码保存到session中
        $_SESSION['captcha'] = $captcha->getCode();
    }
}