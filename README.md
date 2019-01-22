# sl_cms2018 test222222
 
https://www.kancloud.cn/book/wahson-gong/silecms_php_2018/preview/content/%E6%A6%82%E8%BF%B0.md###


## log 的使用 
```
LogChannel('sql')->setTitle('title')->info(msg); msg 可以是 array string 
LogChannel('sql')->info(); waring() error();   # LogChannel 通道的意识。写入那一个通道，自动创建文件夹；

```
## request
```
  $request = Request::all(); #取所有数据
  Request::unsetRoute()->all()  # 去除框架路由的参数 route 
  Request::unmeaning()->all();  # 不对数据进行强制转义
  Request::get('id'); # 获取单个数据 
  Request::decrypt('id')->all(); # 解密
  Request::decrypt(['id'])->all(); # 解密 多个参数 
   
```

## helps
```
$paramid = config('kecheng.param_id','front'); #读配置 多维数组 用.的形式取; 第二个参数 为模块名称
returnSuccess($data, $msg='success',$code=0)
returnFail($data, $msg='fail',$code=1) 
encrypt($data,'id',$this->common) # 加密   第一个参数 为数据源， 第一个参数可以 （array ,string）,第三个参数为 comm类的实例化对象； 

```



