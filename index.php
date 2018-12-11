<?php
# 前台开启伪静态路由;
define("FRONT_ROUTE_HTML", false);
//入口文件
//引入核心启动类
include "silephp/core/Framework.class.php";
Framework::run();
