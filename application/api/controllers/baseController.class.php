<?php
//后台基础控制器
class baseController extends Controller {
    public  $common;
    public  $smarty;
    public  $templates;
    public  $appkey;
    public  $signstate;
    public  $tokentime ;//token有效时间 20分钟
    public  $tableModel;
    
	//构造方法
	public function __construct(){ 
	    $this->appkey=$GLOBALS['config_api']['appkey'];
	    $this->signstate=$GLOBALS['config_api']['signstate'];
	    $this->tokentime=$GLOBALS['config_api']['tokentime'];
	    $this->common = new Common();
	    $this->tableModel = new tableModel();
	}
	
	public function getcodestr($id) {
	    return $GLOBALS['config_code'][$id];
	}
	
	
	/**
	
	* 接口安全过滤方法，处理token,sign
	
	* @date: 2019年1月28日 下午7:29:59
	
	* @author: 龚华尧
	
	* @param: variable
	
	* @return:
	
	*/
	function apisafefilter() {
	    //验证签名开始
	    $token = $this->common->Requert("token");
	    $sign= $this->common->Requert("sign");
	    $check_tokendata = checktoken($token);
	    if(!$check_tokendata['status']){
	        returnSuccess($check_tokendata['status'], $check_tokendata['msg'] ,$code=2003);
	    }
	    
	    //token验证通过后，验证签名是否正确
	    
	    getsign();
	    $check_signdata = checksign($sign);
	    if(!$check_signdata['status']){
	        returnSuccess($check_signdata['status'], $check_signdata['msg'] ,$code=2004);
	    }
	    
	    //验证签名结束
	}
	
	
	/**
	 * 处理查询表名称，防止跨脚本攻击
	 */
	protected function TablenameFilter($t) {
	    //调用common类
	    $commonClass=$this->common;
	    
	    if($t==""){
	        returnSuccess(false, "t参数不能为空",$code=2006);
	    }
	    
	    $table_arr = explode(',',$t);
	    if(count($table_arr)==0)
	    {
	        //待处理的表名
	        $t=$commonClass->SafeFilterStr($t);
	        //增加权限判断
	        if(!$this->tableModel->isableapi($t)){
	            returnSuccess(false, "数据表无权限查询1",$code=2005);
	        }
	        
	    }else
	    {
	        $t="";
	        for($i=0;$i<count($table_arr);$i++)
	        {
	            //增加权限判断
	            if(!$this->tableModel->isableapi($table_arr[$i])){
	                returnSuccess(false, "数据表无权限查询2",$code=2005);
	            }
	            
	            if($t=="")
	            {
	                $t="sl_".$commonClass->SafeFilterStr($table_arr[$i]);
	            }else
	            {
	                $t= $t ." , ". "sl_".$commonClass->SafeFilterStr($table_arr[$i]);
	            }
	            
	        }
	        
	    }
	    
	    return $t;
	    
	}
	
	/**
	 * 处理查询表的查询字段，自动生成查询sql
	 */
	protected function FiledFilter($t) {
	    //调用common类
	    $commonClass=$this->common;
	    if(strpos($t,",")=="")
	    {
	        $t=$commonClass->SafeFilterStr($t);
	        $temp_model=new Model($t);
	        //echo $temp_model->getSqlWhereStr();die();
	        return $temp_model->getSqlWhereStr();
	    }
	    
	    
	}
	
	
	/**
	 * 处理返回的列名称，用于多表查询
	 */
	protected function LiemingchengFilter($liemingcheng) {
	    //调用common类
	    $commonClass=$this->common;
	    if($liemingcheng=="")
	        return "*";
	        $liemingcheng_arr = explode(',',$liemingcheng);
	        if(count($liemingcheng_arr)==0)
	        {
	            //待处理的列名称
	            $liemingcheng=$commonClass->SafeFilterStr($liemingcheng);
	            
	            
	        }else
	        {
	            $liemingcheng="";
	            for($i=0;$i<count($liemingcheng_arr);$i++)
	            {
	                if($liemingcheng=="")
	                {
	                    $liemingcheng=$commonClass->SafeFilterStr($liemingcheng_arr[$i]);
	                }else
	                {
	                    $liemingcheng= $liemingcheng." , ". $commonClass->SafeFilterStr($liemingcheng_arr[$i]);
	                }
	                
	            }
	            
	        }
	        
	        return $liemingcheng;
	        
	}
	
	/**
	 * 返回条数
	 */
	protected function NumberFilter($number) {
	    //调用common类
	    $commonClass=$this->common;
	    if ($number=="")
	    {
	        $number="0";
	    }
	    else if(!$commonClass->isNumber($number))
	    {
	        $number="0";
	    }
	    return  $number;
	}
	
	/**
	 * 默认查询方式
	 * 如果有多个用逗号分隔，“|”会替换成=号
	 * 多个字使用逗号“，”分开
	 * 如果是or，比如sqlvalue=biaoti|'姓名/shouji|‘15982851365’，使用“/”分隔
	 */
	protected function SqlvalueFilter($sqlvalue) {
	    //调用common类
	    $commonClass=$this->common;
	    $sqlvalue=str_replace("|"," = ",$sqlvalue);
	    $sqlvalue=str_replace(","," and ",$sqlvalue);
	    $sqlvalue=str_replace("/"," or ",$sqlvalue);
	    $sqlvalue=str_replace("dh"," , ",$sqlvalue);//把逗号替换为，
	    $sqlvalue=str_replace("{bdy}"," <> ",$sqlvalue);//替换不等于
	    //处理模糊查询
	    $sqlvalue=str_replace("{like}"," like ",$sqlvalue);
	    $sqlvalue=str_replace("{bfb}","%",$sqlvalue);
	    
	    // dtime between '2017-08-27 00:00' and '2017-08-27 23:59'
	    $sqlvalue=str_replace("{between}"," between ",$sqlvalue);
	    $sqlvalue=str_replace("{and}"," and ",$sqlvalue);
	    
	    //验证字符合法性
	    
	    if($sqlvalue!="")
	    {
	        $sqlvalue=" (".$sqlvalue.") ";
	    }
	    return $sqlvalue;
	}
	
	/**
	 * 自动拼接sql 语句
	 *
	 */
	protected function getSql($t,$liemingcheng,$number,$page=0,$ordertype,$orderby,$sqlvalue) {
	    //调用common类
	    $commonClass=$this->common;
	    
	    $_sql="select ";
	    if($sqlvalue=="")
	    {
	        $_sql=$_sql." ".$liemingcheng." from {$t} ";
	    }else
	    {
	        $_sql=$_sql." ".$liemingcheng." from {$t} where {$sqlvalue}  ";
	    }
	    
	    
	    
	    if($this->FiledFilter($t)!="")
	    {
	        if($sqlvalue=="")
	        {
	            $_sql=$_sql." where  ".$this->FiledFilter($t);
	        }else
	        {
	            
	            $_sql=$_sql." and  ".$this->FiledFilter($t);
	        }
	    }
	    
	    
	    
	    if($ordertype!="")
	    {
	        if($ordertype=="id")
	        {
	            $_sql=$_sql." order by ".$ordertype." ".$orderby ;
	        }else if(strlen(strstr($t, ','))>0)
	        {
	            
	            $_sql=$_sql." order by ".$ordertype." ".$orderby ;
	            
	        }else
	        {
	            $_sql=$_sql." order by ".$ordertype." ".$orderby ."  , id desc ";
	        }
	    }else
	    {
	        $_sql=$_sql." order by id desc ";
	    }
	    
	    if($number!="0")
	    {
	        if($page<=1)
	        {
	            $a=0;
	        }else
	        {
	            $a=$number * ($page-1);
	        }
	        
	        $b=$number ;
	        $_sql=$_sql . " limit  $a , $b ";
	    }
	    
	    //$_sql="select {$liemingcheng} from {$t} where {$sqlvalue} order by id desc";
	    
	    //验证字符合法性
	    //echo $_sql;die();
	    return $_sql;
	}
	
	
	
	
}