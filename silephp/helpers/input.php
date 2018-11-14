<?php
//批量实体转义
function deepspecialchars($data){
	if (empty($data)) {
		return $data;
	}
	//中高级程序员的写法
	return is_array($data) ? array_map('deepspecialchars',$data) : htmlspecialchars($data);
	/*
	//初级程序员的写法
	// array('username'=>'zs','email'=>'zs@163.com')
	if (is_array($data)) {
		//数组
		foreach ($data as $k => $v) {
			$data[$k] = deepspecialchars($v);
		}
		return $data;

	} else {
		//单个变量
		return htmlspecialchars($data);
	}
	*/
}

//批量单引号转义
function deepslashes($data){
	if (empty($data)) {
		return $data;
	}
	return is_array($data) ? array_map('deepslashes', $data) : addslashes($data);
}