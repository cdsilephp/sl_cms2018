<?php
//核心启动类
class Framework {
	//定义一个run方法
	public static function run(){
	     
		self::init(); 
		self::autoload();
		self::dispatch();
		
	}

	//初始化方法
	private static function init(){
		//定义路径常量
<<<<<<< HEAD
	    define("DS", "/");
// 		define("DS", DIRECTORY_SEPARATOR);
=======
		define("DS", "/");
		// define("DS", DIRECTORY_SEPARATOR);
>>>>>>> 9157a877a13dc685d06444f889279d43b42412ac
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
		$route = $common->Get("route");
		if($route!="")
		{
		    $routeArray = explode("/", $route);
		    if(count($routeArray)==2)
		    {
		        $p=$routeArray[0];
		        $c=$routeArray[1]==""?"index":$routeArray[1];
		        
		    }else if(count($routeArray)==3)
		    {
		        $p=$routeArray[0];
		        $c=$routeArray[1];
		        $a=$routeArray[2]==""?"index":$routeArray[2];
		        
		    }else {
		        $p=$route;
		    }
		}
		
		
		//获取参数p、c、a,index.php?p=admin&c=goods&a=add GoodsController中的addAction
		define('PLATFORM',$p);
		define('CONTROLLER',$c);
		define('ACTION',$a);
		
		//设置当前控制器和视图目录 CUR-- current
		define("CUR_CONFIG_PATH", APP_PATH.PLATFORM.DS. "config" .DS);
		define("CUR_CONTROLLER_PATH", APP_PATH.PLATFORM.DS. "controllers" .DS);
		define("CUR_MODEL_PATH", APP_PATH.PLATFORM.DS. "models" .DS);
		define("CUR_VIEW_PATH", APP_PATH.PLATFORM.DS. "views" .DS);
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
		if (substr($classname, -10) == 'Controller') {
			//载入控制器
			include CUR_CONTROLLER_PATH . "{$classname}.class.php";
		} elseif (substr($classname, -5) == 'Model') {
			//载入数据库模型 
		    include CUR_MODEL_PATH  . "{$classname}.class.php";
		} else {
			//暂略
		}
	}
	
	 
}
