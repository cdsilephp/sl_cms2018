<?php
/**
 * #辅助函数，全局通用
 * Created by PhpStorm.
 * User: cdsile
 * Date: 2018/12/17
 * Time: 16:22
 */

include LIB_PATH.'/Log/Log.php'; # 日志；
include LIB_PATH.'/Ioc/Ioc.php'; # 依赖注入ioc 容器；
/**
 * 获取admin 模块 config配置项
 */
if (!function_exists('config')) {
    function config($val='account',$M=null){
        $common = new Common();
        $M = $M?: PLATFORM;
        $common->autoload_conf(APP_PATH.$M.DS. "config");

        $configs = $GLOBALS['config_'.$val];
        $arr = explode('.', $val);
        # 多级数组获取
        if ( count($arr)>1) {
            $data = $configs = $GLOBALS['config_'.$arr[0]];
            unset($arr[0]);
            foreach ($arr as  $value ) {
                if (!isset($data[$value])) {
                    return null;
                }
                $data = $data[$value];
            }
            return $data;
        }

        return  $configs;
    }
}

/**
 * 成功数据返回
 */
if(!function_exists("returnSuccess")) {

    function returnSuccess($data, $msg='success',$code=0) {
        header('Access-Control-Allow-Origin:*');
        header('content-type:application/json;charset=utf-8');
        $arr = [
            'data' => $data,
            'msg' => $msg,
            'code' => $code,//200
        ];
        exit(json_encode($arr));
    }

}

/**
 * 失败数据返回
 */
if(!function_exists("returnFail")) {

    function returnFail($data, $msg='fail',$code=1) {
        header('content-type:application/json;charset=utf-8');
        $arr = [
            'data' => $data,
            'msg' => $msg,
            'code' => $code,
        ];
        exit(json_encode($arr));
    }

}
/**
 * table 组件需要返回的数据
 * @param $data
 * @param string $msg
 * @param $code
 */
if(!function_exists("returnTableData"))  {
 function returnTableData($data, $count,$page, $msg ='' , $code=0){
        $arr = [
            'count'=> $count,
            'data' => $data,
            'page' => $page,
            'code' => $code,
            'msg'  => $msg
        ];
     exit(json_encode($arr));
    }
}
/**
 * 写入log
 * @param $log
 */
if(!function_exists('setLog')){
    function setLog($param,$filename='log.log') {
        $class = Request::channel('wechat')->set($param,$filename);
        return $class;
    }

}
/**
 * 设置通道地址
 * @param $stack
 */
if(!function_exists('LogChannel')) {
    function LogChannel($stack)
    {
        $class =   Log::channel($stack);
        return $class;
    }
}
if(!function_exists("cache")) {
    function cache(...$param) {
        $cache = new \Symfony\Component\Cache\Simple\FilesystemCache();

        # 第一个元素是数组，
        if(is_array($param[0])) {
            $cache->setMultiple($param[0]);
            return $cache;
        }
        # 元素数量为2 且第一个不是数组
        if(count($param)>=2&&!is_array($param[0])) {
            $cache->set($param[0],$param[1]);
            return $cache;
        }

        # 取元素
        if (count($param)==1) {
            $caceValue = $cache->get($param[0]);
            return $caceValue;
        }
        return $cache;
    }
}
if(!function_exists("app")) {
    function app($class,$pre='front',$dir='') {
        $arr = explode('_',$class);
        $modelname = implode('/',$arr);
        $dir = $dir?DS.$dir:'';
        $file = APP_PATH.$pre.DS. "models" .$dir.DS.$modelname.'.class.php';

        if(file_exists($file))
        {
            include_once $file;
            $app = Ioc::getInstance($class);

           return $app;
        } else {
            exit($file.' not exists ');
        }

    }
}

/**
 * Ajax 返回
 */
if(!function_exists("returnResponse")) {

    function returnResponse($data) {
        header('content-type:application/json;charset=utf-8');
        exit(json_encode($data));
    }

}

/**
 *  根据2个相同的数据   合并2个数组 1对1的数组
 */
if(!function_exists("mergeOnetMore")) {

    function mergeOnetoMore(array $arr,array $data,$param) {
        $akey = '';
        $dkey = '';

        if(is_array($param)) {
            $akey = $param[0];
            $dkey = $param[1];
        }
        foreach ($arr as $key=> &$value) {
            $value['dev'] = [];
            foreach ($data as $k=>$v) {
                if($value[$akey] == $v[$dkey]) {
                    array_push($value['dev'],$v);
                }
            }
        }
    return $arr;
    }

}


if(!function_exists("mergeOnetoOne")) {

    function mergeOnetoOne(array $arr,array $data,$param) {
        $akey = '';
        $dkey = '';

        if(is_array($param)) {
            $akey = $param[0];
            $dkey = $param[1];
        }
        foreach ($arr as $key=> &$value) {
            foreach ($data as $k=>$v) {
                if($value[$akey] == $v[$dkey]) {
                    $value['dev'] = $v;

                }
            }
        }
        return $arr;
    }

}

# 获取uid
if(!function_exists('getSessionUid')) {
    function getSessionUid(){
        $user_id =  $_SESSION['userinfo']['id'];
        # 测试
        $user_id = 1;
        return $user_id;
//        return 1;
    }
}

# 批量加密
if(!function_exists('encrypt')) {
    function encrypt($data,$paramName,$commonEle){
        foreach ($data as  $key=>$val){
            if (is_array($val)) {
                $data[$key] = encrypt($val,$paramName,$commonEle);
            }else {
                if ($key == $paramName||($key&&is_array($paramName)&&in_array($key, $paramName))) {
                    $data[$key] = $commonEle->encrypt($val);
                }
            }
        }
        return $data;
    }
}

function pr($arr) {
    echo "<pre>";
    print_r($arr);
    echo "</pre>";
}