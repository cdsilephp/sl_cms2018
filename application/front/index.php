<?php 
if(version_compare(PHP_VERSION,'7.0.0','<'))  die('require PHP > 7.0.0 !');
//自动挂载config文件
$common->autoload_conf(APP_PATH."admin".DS. "config");

//载入系统model类
include APP_PATH."admin".DS. "models" .DS. "sortModel.class.php";//网站栏目分类类
include APP_PATH."admin".DS. "models" .DS. "tableModel.class.php";//模型类
include APP_PATH."admin".DS. "models" .DS. "filedModel.class.php";//字段类

$GLOBALS['site_type']="both"; //值为defualt，m,both  默认值为both，代表包含了PC和WAP两种类型的站点，m只包含手机wap，defualt只包含PC