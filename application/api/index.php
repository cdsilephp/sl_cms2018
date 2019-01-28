<?php 
if(version_compare(PHP_VERSION,'7.0.0','<'))  die('require PHP > 7.0.0 !');
//自动挂载config文件
$common->autoload_conf(APP_PATH."admin".DS. "config");
$common->autoload_conf(APP_PATH."api".DS. "config");
//自动挂载方法类
$common->autoload_func(APP_PATH."api".DS. "function");


//载入系统model类
include APP_PATH."admin".DS. "models" .DS. "sortModel.class.php";//网站栏目分类类
include APP_PATH."admin".DS. "models" .DS. "tableModel.class.php";//模型类
include APP_PATH."admin".DS. "models" .DS. "filedModel.class.php";//字段类
