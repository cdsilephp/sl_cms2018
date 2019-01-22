<?php
//核心启动类
class Framework {
	//定义一个run方法
	public static function run(){

        FRONT_ROUTE_HTML&&self::routeFrontHtml();
		self::init(); 		//初始化方法
        self::loadHelps();  // 挂载其他类
		self::autoload();	//自动加载
		self::dispatch();	//路由方法
		
	}

	//初始化方法
	private static function init(){
		//定义路径常量
		define("DS", '/');
		define("ROOT", getcwd() . DS ); //根目录
		define("APP_PATH", ROOT . 'application' . DS);
		define("FRAMEWORK_PATH", ROOT . "silephp" .DS);
		define("PUBLIC_PATH", ROOT . "public" .DS);
		
		define("CORE_PATH", FRAMEWORK_PATH . "core" .DS);
		define("DB_PATH", FRAMEWORK_PATH . "databases" .DS);
		define("LIB_PATH", FRAMEWORK_PATH . "libraries" .DS);
		define("HELPER_PATH", FRAMEWORK_PATH . "helpers" .DS);
		define("UPLOAD_PATH", PUBLIC_PATH . "uploads" .DS);
		
		
		
		//载入核心类
		include CORE_PATH . "Controller.class.php";
		include CORE_PATH . "Model.class.php";//pdo操作的新model类-->ghy 
		include DB_PATH . "CPdo.class.php";//pdo类-->ghy
		
		//载入库文件
		include LIB_PATH . "Common.class.php";//公共方法类
		include LIB_PATH . "MyException.class.php";//自定义异常类
		// include LIB_PATH . "Page.class.php";
		//include LIB_PATH . "Upload.class.php";
		$common = new Common();
		
		//单独处理路由
		$p="front";
		$c="index";
		$a="index";
		# 如果 路由没有过滤到html 这里进行处理
		$route = self::routeStatic($common->Get("route"));
		if($route!="")
		{
		    $routeArray = explode("/", $route);	//将字符串转为数组
////////////////////////dongdong update ///////////////////////////
            switch (count($routeArray)) {
                case 2:
                    $p = $routeArray[0];
                    $c = $routeArray[1]==""?"index":$routeArray[1];
                    break;
                case 3:
                    $p = $routeArray[0];
                    $c = $routeArray[1];
                    $a = $routeArray[2]==""?"index":$routeArray[2];
                    break;
                case 4: # dongdong 添加
                    $p = $routeArray[0];
                    $c = $routeArray[1].'/'.$routeArray[2];
                    $a = $routeArray[3]==""?"index":$routeArray[3];
                    break;
                default:
                    $p=$route;
                    break;
            }
////////////////////////dongdong update ///////////////////////////
		}
		
		
		//获取参数p、c、a,index.php?p=admin&c=goods&a=add GoodsController中的addAction
		define('PLATFORM',$p);		//模块
		define('CONTROLLER',$c);	//控制器
		define('ACTION',$a);		//方法
		
		//设置当前控制器和视图目录 CUR-- current
		define("CUR_CONFIG_PATH", APP_PATH.PLATFORM.DS. "config" .DS);				//配置文件
		define("CUR_CONTROLLER_PATH", APP_PATH.PLATFORM.DS. "controllers" .DS);		//控制器
		define("CUR_MODEL_PATH", APP_PATH.PLATFORM.DS. "models" .DS);				//模型
		define("CUR_VIEW_PATH", APP_PATH.PLATFORM.DS. "views" .DS);					//视图
		define("CUR_MODULES_PATH", "modules" .DS);				//模块 modules
		//TPLPATH
		define("CUR_TPL_PATH", $common->getHostDomain().DS.'application'.DS.PLATFORM.DS. "views" .DS);

		
		//定义启动文件
		define("CUR_STARTFILE_PATH", APP_PATH.PLATFORM.DS. "index.php" );
		//载入项目启动文件
		if(is_file(CUR_STARTFILE_PATH)){
		    require CUR_STARTFILE_PATH;
		} 
		
		//开启session
		session_start();
		
	}	

	//路由方法,说白了，就是实例化对象并调用方法
	private static function dispatch(){
		//获取控制器名称
		$controller_name = CONTROLLER . "Controller";
		
		//获取方法名
		$action_name = ACTION . "Action";

//        var_dump($controller_name);
//////////////// 多级 文件夹路由处理 dongdong //////////////////////////
        if (strpos($controller_name,'/')) {
            $file = CUR_CONTROLLER_PATH . "{$controller_name}.class.php";
            $file = str_replace('/', '\\', $file);
            if (file_exists($file)) {
                require_once($file);

                $urlarr = explode('\\',$file);
                $controller_name = explode('/', $controller_name)[1];
                $controller = new $controller_name();
                $controller->$action_name();
                return false;
            }
        }
////////////////多级 文件夹路由处理 dongdong //////////////////////////


		//实例化控制器对象
		$controller = new $controller_name();
		//调用方法
		$controller->$action_name();
	}

	//注册为自动加载
	private static function autoload(){
		// $arr = array(__CLASS__,'load');
		spl_autoload_register('self::load');
	}

	//自动加载功能,此处我们只实现控制器和数据库模型的自动加载
	//如GoodsController、 GoodsModel
	private static function load($classname){
	    $file="";
		if (substr($classname, -10) == 'Controller') {
			//载入控制器
		    $file = CUR_CONTROLLER_PATH . "{$classname}.class.php";
		   
			    
		} elseif (substr($classname, -5) == 'Model') {
			//载入数据库模型 
		    $file = CUR_MODEL_PATH  . "{$classname}.class.php";
		     
		} elseif (substr($classname, -6) == 'Module') {
		    //载入模块
		    $file = CUR_MODULES_PATH. "{$classname}.class.php";
		     
		} else {
			//暂略
		}
		
		if(file_exists($file))
		{
		    require_once($file);
		    if(class_exists($classname,false))
		    {
		        return true;
		    }
		}
		
	}

    /**
     * Notice: 前台判断是否处理为 伪静态路由
     * Date: 2018/12/11
     * Time: 10:24
     * @author dongdong
     */
    private static function routeStatic($route)
    {

        if ($route && (strpos('.html',$route)||strpos('.htm',$route)) ) {
            $rule = ['.html','htm'];
            $replace = ['',''];
            $route = str_replace($rule, $replace, $replace);
        }
        return $route;

    }

    /**
     * Notice: 伪静态路由处理，路由重定向；
     * Date: 2018/12/11
     * Time: 14:37
     * @author dongdong
     */
    private static function routeFrontHtml()
    {
        if ($_SERVER['REQUEST_METHOD'] == 'GET') {
            if(strpos('ss'.$_GET['route'],'admin')) {
                return;
            }
            $html = strpos($_SERVER['REQUEST_URI'],'.html');
            if (!$html) {
                    $param =$_GET;
                    unset($param['route']);
                    $str = '/';
                    foreach ($param as $key=>$val) {
                        $str .= $key.'/'.$val.'/';
                    }
                    #参数拼接
                    $str = substr($str,0,-1);
                    $route = $_GET['route'];
                    $route = str_replace('front/','',$route);
                    $route = $route?'/'.$route:'';
                    $redirct = 'http://'.$_SERVER['HTTP_HOST'].$route.'/indexs'.$str.'.html';
                    header("Location:$redirct");

                } else {

                    $str = $_GET['route'];
                    $str = str_replace('.html','',$str);
                    $dataarr = explode('/indexs',$str);
                    $_GET['route']  = $dataarr[0];
                    $route = isset($dataarr[1])?explode('/',$dataarr[1]):[];

                    # 过滤无参数状态
                    if (count($route) > 1) {
                        unset($route[0]);
                        $index = '';
                        foreach ($route as $key=>$val) {
                            if ($key%2==0) {
                                $_GET[$index] = $val;
                            } else {
                                $index = $val;
                            }
                        }
                    }

                }
            }
   }

    /**
     * Notice:挂载其他类
     * Date: 2018/12/20
     * Time: 16:07
     * @author dongdong
     */
    public static function loadHelps()
    {
        //
        $file = HELPER_PATH . 'helps.php';
        if (file_exists($file) ) {
            include $file;
        };

//        // 请求处理类
        $file = LIB_PATH . '/Request/Request.php';
        if (file_exists($file) ) {
            include $file;
        };
    }


	
	
	
	 
}
