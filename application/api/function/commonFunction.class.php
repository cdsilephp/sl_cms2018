<?php
 


/**

* 验证token

* @date: 2019年1月28日 下午2:48:59

* @author: 龚华尧

* @param: $GLOBALS

* @return:

*/
function checktoken($tokenstr) {
    $common = new Common();
    $appkey=$GLOBALS['config_api']['appkey'];
    $tokentime=$GLOBALS['config_api']['tokentime'];
    
    $tokenArray =unserialize($common->decryptByqingmiphp($tokenstr));
    $data["appkey"] = $tokenArray['appkey'];
    $data["time"] = $tokenArray['time'];
    
    $returndata['status']=false;
    $returndata['msg']="error";
    
    if($data["appkey"]!=$appkey){
        $returndata['msg']="appkey 不匹配";
        return $returndata;
    }
    
    if($data['time']<time()){
        $returndata['msg']="token 超时";
        return $returndata;
        
    }
    
    $returndata['status']=true;
    $returndata['msg']="token 合法";
    return $returndata;
    
   
}

/**

* 验证签名是否正确

* @date: 2019年1月28日 下午7:01:24

* @author: 龚华尧

* @param: $GLOBALS

* @return:

*/
function checksign($signstr){
    
    $returndata['status']=false;
    $returndata['msg']="error";
    
    if($signstr!=getsign())
    {
        $returndata['msg']="签名错误";
        return $returndata;
    }else{
        $returndata['status']=true;
        $returndata['msg']="签名正确";
        return $returndata;
    }
    
}

/**

* 生成签名

* @date: 2019年1月28日 下午6:16:47

* @author: 龚华尧

* @param: $GLOBALS

* @return:

*/
function getsign(){
    
   $data= Request::unsetRoute()->all();
   //去掉sign和token    
   if (array_key_exists("sign",$data ) ) {
       unset($data['sign']);
   }
   if (array_key_exists("token",$data ) ) {
       //unset($data['token']);
   }
   
   $ASCIIstr= strtolower(ASCII($data));
   
  //echo strtoupper(md5($ASCIIstr));die();
   return strtoupper(md5($ASCIIstr));
}


//自定义ascii排序
function ASCII($params = array()){
    if(!empty($params)){
        $p =  ksort($params);
        if($p){
            $str = '';
            foreach ($params as $k=>$val){
                $str .= $k  . $val;
            }
            $strs =$str;
            return $strs;
        }
    }
    return '参数错误';
}




