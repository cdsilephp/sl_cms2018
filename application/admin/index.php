<?php 
// //载入配置文件
// if(file_exists(CUR_CONFIG_PATH. "db.config.php"))
// {
//     $GLOBALS['config_db'] = include CUR_CONFIG_PATH. "db.config.php";
// }
// $GLOBALS['config_cache'] = include CUR_CONFIG_PATH. "cache.config.php";
// $GLOBALS['config_regular'] = include CUR_CONFIG_PATH. "regular.config.php";//正则匹配规则
// $GLOBALS['config_account'] = include CUR_CONFIG_PATH. "account.config.php";//系统账号


//自动挂载config文件
$common->autoload_conf(APP_PATH."admin".DS. "config");
 

 