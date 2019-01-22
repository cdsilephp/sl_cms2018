<?php
/**
 * Created by PhpStorm. 请求实例类
 * User: cdsile
 * Date: 2018/11/22
 * Time: 14:59
 * @method get(...$param )
 * @method getValue($pama = null)
 * @method unsetRoute()
 * @method PostData();
 */
class Request
{
    private static $instace;# Log对象实例
    private static $_meaning = false; # 不转义
    private  static $_decrypt =false;
    private  static $_decrypt_params = 'id';
    /**
     * 获取实例
     */
    public static function getInstace()
    {
        if(!(self::$instace instanceof self)) {
            self::$instace = new Request();
        };
        return self::$instace;
    }
    /**
     * 获取单个数据 或多个数据
     * @param $param
     */
    public static function get(...$param )
    {
        switch (count($param)) {
            case 1:
                self::getValue($param[0]);
                break;
            default :
                return self::getValue();
        }
    }

    /**
     * Notice: 获取所有数据
     * Date: 2018/12/20
     * Time: 16:50
     * @author dongdong
     * @return array|string
     */
    public static  function all()
    {
        return self::getValue();
    }

    private static function getValue($pama = null)
    {

        $common = new Common();
        switch ($method = self::method()) {
            case 'GET':
                $GET =  self::GetData($pama);
                $input = self::getInstace()->getInputAll();
                $GET =  $input&&is_array($input)?array_merge($GET,$input):$GET;
                return $GET;
                break;
            case 'POST':
                $POST = self::PostData($pama);

                $input = self::getInstace()->getInputAll();
//                var_dump($input);die;
                $POST = $input&&is_array($input)?array_merge($POST,$input):$POST;
                return $POST;
                break;
            case 'PUT':
                return 'PUT is not code';
                break;
            default:
                return $method;
                break;
        }
    }

    # GET 获取
    public static function GetData($pama=null) {
        if (self::$_meaning) { # 不转义
            $data =  $pama?$_GET[$pama]:$_GET;
        } else {
            $common = new Common();
            $data = $pama ? $common->SafeFilterStr($_GET[$pama]): $common->SafeFilterArray($_GET);
        }

        if (self::$_decrypt) {
            $data = self::decryptData($data);
        }

        return $data;
    }
    # POST 获取
    public static function PostData($pama=null) {
        if (self::$_meaning) { # 不转义
            $data =  $pama?$_POST[$pama]:$_POST;
        } else {
            $common = new Common();
            $data =  $pama ? $common->SafeFilterStr($_POST[$pama]): $common->SafeFilterArray($_POST);
        }

        if (self::$_decrypt) {
            $data = self::decryptData($data);
        }

        return $data;
    }


    # 删除请求中的路由数据
    public static function unsetRoute()
    {
        unset($_GET['route']);
        return self::getInstace();
    }
    # 获取请求方式
    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }
    # 分页主键数据
    public function paginate()
    {
        $paginate = (object)[];
        $paginate->page  = (self::GetData('page')?:self::PostData('page'))?:1;
//        $paginate->page = ($paginate->page -1)?:0;
        $paginate->limit  = (self::GetData('limit')?:self::PostData('limit'))?:10;

        return $paginate;

    }

    # 不转义字符
    public static function unmeaning()
    {
        self::$_meaning = true;
        return self::getInstace();
    }
    # 解密
    static function decrypt($paramname)
    {
        self::$_decrypt = true;
        self::$_decrypt_params = $paramname?$paramname:self::$_decrypt_params;
        return self::getInstace();
    }

    static function decryptData($data)
    {
        foreach ($data as  $key=>$val){
            if (is_array($val)) {
                $data[$key] = self::decryptData($val);
            }elseif(is_array($arr = json_decode($val,true))){
                $data[$key] = self::decryptData($arr);
            }else {
                if ($key == self::$_decrypt_params||(is_array( self::$_decrypt_params)&&in_array($key,  self::$_decrypt_params))) {
                    $data[$key] = (new Common())->decrypt($val);
                }
            }
        }

        return $data;
    }

    /**
     * 获取自定义的header数据
     */
    public function get_all_headers()
    {

        // 忽略获取的header数据
        $ignore = array('host', 'accept', 'content-length' ); # 'content-type'

        $headers = array();

        foreach ($_SERVER as $key => $value) {
            if (substr($key, 0, 5) === 'HTTP_') {
                $key = substr($key, 5);
                $key = str_replace('_', ' ', $key);
                $key = str_replace(' ', '-', $key);
                $key = strtolower($key);

                if (!in_array($key, $ignore)) {
                    $headers[$key] = $value;
                }
            }
        }

        return $headers;
    }

    /**
     * Notice: 获取input 输入体的数据
     * Date: 2018/12/20
     * Time: 16:48
     * @author dongdong
     * @return bool|mixed|string
     */
    public function getInputAll()
    {
        $data = file_get_contents('php://input');
        $res = json_decode($data, true);
        $data = $res?$res:$data;
        if (self::$_decrypt) {
            $data = self::decryptData($data);
        }
        return  $data;
    }
}
