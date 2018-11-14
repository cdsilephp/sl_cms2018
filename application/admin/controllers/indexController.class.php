<?php
//后台首页控制器
class indexController extends baseController {
	
	//后台首页
	public function indexAction(){
	    $menugroupModel =new menugroupModel();
	    $menulist = $menugroupModel->getmenuByUsergroup($_SESSION["admin"]["group_id"]);
	    include CUR_VIEW_PATH . "index.html";
	}
	
	
	
	public function mainAction(){

	    //查询有哪些表
	    $sortModel=new Model("table");
	    $tableModel=new Model("table");
	    $systemMode=new Model("log");
	    //统计分类  SELECT COUNT(*) as count_id from (SELECT  u3,dtime from sl_system where u1='访客' and u4='访客记录'  GROUP BY u3 )as t
	    $sort=$sortModel->findBySql("select * from sl_table where id in ( 102,89 ,80,75,76)  order by id desc ");
	    //发布时间
	    $dtime=$systemMode->findBySql("SELECT distinct  date_format(dtime,'%y-%m-%d') as dtime  from sl_log where DATE_SUB(CURDATE(), INTERVAL 30 DAY) <= date(dtime)  ORDER BY dtime desc");
	    
	    
	    include CUR_VIEW_PATH . "Sindex" . DS . "main.html";
	}
	
	 
}