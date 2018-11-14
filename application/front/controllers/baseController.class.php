<?php
//后台基础控制器
class baseController extends Controller {
    public  $common;
    public  $smarty;
    public  $templates;
	//构造方法
	public function __construct(){ 
		$this->checkLogin();
		$this->common = new Common();
		
		
		//载入smarty模版引擎
		/* 并指定了Smarty.class.php所在位置，注意'S'是大写的*/
		require LIB_PATH.'smarty'.DS.'Smarty.class.php';
		/* 实例化Smarty类的对象$smarty */
		$this->smarty = new Smarty();
		// 设置模板目录和编译目录
		$this->smarty->template_dir = CUR_VIEW_PATH . "templates";
		$this->smarty->compile_dir = CUR_VIEW_PATH . "templates_c";
		$this->smarty->setCacheDir(CUR_VIEW_PATH.'cache'); //设置缓存文件存放目录
		$this->smarty->debugging = false;
		
		$this->smarty->caching = false;//设置Smarty缓存开关功能
// 		$this->smarty->cache_lifetime = 60*60*24;//设置模板缓存有效时间段的长度为1天
		$this->smarty->cache_lifetime = 60;//设置模板缓存有效时间段的长度为1分钟
		$this->smarty->left_delimiter = '<{';//设置模板语言中的左结束符
		$this->smarty->right_delimiter = '}>'; //设置模板语言中的右结束符
		
		
		if($GLOBALS['site_type']=="defualt")
		{
		    $this->templates="defualt";
		}else if($GLOBALS['site_type']=="m"){
		    $this->templates="m";
		}else{
		    if($this->common->is_mobile())
		    {
		        $this->templates="m";
		    }else
		    {
		        $this->templates="defualt";
		    }
		}
		
		
		//加载系统变量
		$this->smarty->assign('CUR_TPL_PATH', CUR_TPL_PATH."templates".DS.$this->templates.DS);
		// 加载网站信息
		$this->smarty->assign('WEB_INFO', $GLOBALS['config_cache']);
		
		//加载网站栏目
		$sortModel = new sortModel();
		$sortList = $sortModel->getsortByclassid("");
		//处理连接包含的 ? &
		foreach ($sortList as $k=>$v){
		    if(strpos($v['u5'],"?")){
		        $v['u5'] = $v['u5']."&sort_id={$v['id']}";
		    }else{
		        if($v['u5']!="/"){
		            $v['u5'] = $v['u5']."?sort_id={$v['id']}";
		        }
		       
		    }
		    $sortList[$k]=$v;
		}
		$sortList = $sortModel->child($sortList,1);
		$this->smarty->assign('sortList', $sortList);
		
		//加载seo到TDK参数
		$sort_id = $this->common->Get("sort_id");
		$search_value= $this->common->Get("search_value");
		$seodata = $sortModel->getSEOBysort_id($sort_id);
		$this->smarty->assign('seodata', $seodata);
		$this->smarty->assign('sort_id', $sort_id);
		$this->smarty->assign('search_value', $search_value);
		 
		/*      自定义变量         */
// 		//加载友情连接
// 		$youqinglianjieModel = new youqinglianjieModel();
// 		$youqinglianjieList = $youqinglianjieModel->getallBypaixu();
// 		$this->smarty->assign('youqinglianjieList', $youqinglianjieList);
		
// 		//加载合作伙伴
// 		$hezuohuobanModel = new hezuohuobanModel();
// 		$hezuohuobanList = $hezuohuobanModel->getallBypaixu();
// 		$this->smarty->assign('hezuohuobanList', $hezuohuobanList);
		
// 		//加载新闻列表按照新闻类型
// 		$xinwenzixunModel = new xinwenzixunModel();
// 		$xinwenzixunListBysort = $xinwenzixunModel->getallGroupbySort(0,11);
// 		$this->smarty->assign('xinwenzixunListBysort', $xinwenzixunListBysort);
		
// 		//加载设计师推荐
// 		$shejishiModel = new shejishiModel();
// 		$shejishiTuijianList = $shejishiModel->gettuijian(0,5);
// 		$this->smarty->assign('shejishiTuijianList', $shejishiTuijianList);
		
// 		//加载推荐产品
// 		$chanpinzhongxinModel = new chanpinzhongxinModel();
// 		$tuijianchanpinList = $chanpinzhongxinModel->getalltuijianBypaixu();
// 		$this->smarty->assign('tuijianchanpinList', $tuijianchanpinList);
		
// 		//加载banner和广告图片
// 		$tupianModel = new Model("tupian");
// 		$tupiandetail = $tupianModel->findOne(1);
// 		$datatupian['banner']=$tupiandetail['banner'];
// 		$datatupian['guanggao']=$tupiandetail['guanggao'];
// 		$this->smarty->assign('datatupian', $datatupian);
	}
	
	//验证用户是否登录
	public function checkLogin(){
	    $common = new Common();
	    if (ACTION == "kefulogin" || ACTION == "yonghulogin" ) {
            //第三方登录接口不用判断登录；
           
        } else { 
            //注意，此处的admin是我在登录成功时保存的登录标识符
            if ($common->get_seesion("kefuinfo")=="" && $common->get_seesion("yonghuinfo")=="" ) {
                //$this->jump('http://sale.cdbl.cn/kefulogin','你还没有登录呢');
            }
        }
 
		
	}
	
	 
		
	
}