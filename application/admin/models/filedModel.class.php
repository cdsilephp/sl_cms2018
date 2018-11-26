<?php
// 字段类型模型
class filedModel extends Model
{

    public function __construct()
    {
        parent::__construct("filed");
    }
    
    
    
    public function getfieldlistBytableid($table_id,$page=0,$limit=10)
    {
        $page = $page==""?0:($page-1);
        $limit= $limit==""?0:$limit;
        return  $this->where(["model_id"=>$table_id])->limit($page*$limit,$limit)->all();
        
    }
    
    //获取列表页生成表头
    public  function getFiledJsonByTableid($table_id) {
        
        $filedlist0['type']="checkbox";
        
        $filedlist1['field']="id";
        $filedlist1['width']="80";
        $filedlist1['title']="ID";
        $filedlist1['sort']="true";
        
        $filedlist = $this->find("u1 as field , u9 as width ,u2 as title ,u13 as event,u11 as sort,u12 as align ,u7,u10")->where(["model_id"=>$table_id,"u5"=>"是"])->orderBy('u10 asc , id desc')->all();
        foreach ($filedlist as $k=>$v)
        {
            if($v['width']=='')
            {
                unset($v['width']);
            }
            if($v['align']=='')
            {
                unset($v['align']);
            }
            if($v['event']=='')
            {
                unset($v['event']);
            }
            if($v['sort']=='false' || $v['sort']=='否' )
            {
                unset($v['sort']);
            }else{
                $v['sort']=true;
            }
            
            if($v['u7']=='图片' )
            {
                //{field: '', title: '照片', width: 120,templet:'<div><img src="{{d.imagePath}}"></div>'},
                //$v['templet']='<div><img src="{{d.'.$v['field'].'}}"></div>';
                $v['templet']="#tp_{$v['field']}";//templet: '#tp_cover'
                //$v['style']='img { height: 100%;  max-width: 100%; }  ';
            }
            
            $filedlist[$k]=$v;
        }
        
        array_unshift($filedlist, $filedlist0, $filedlist1);

        //field: 'withdraw_state',
        $btnArr['align']='center';
        $btnArr['fixed']='right';
        $btnArr['toolbar']='#test-table-operate-barDemo';
        $filedlist[] = $btnArr;
        return  json_encode($filedlist) ;
    }
    
    //获取对应表的所有字段
    public  function getallFiledByTableid($table_id) {
        
        $filedlist = $this->where(["model_id"=>$table_id])->orderBy("u10 asc,id desc ")->all();
        return $filedlist;
    }
    
    //得到系统已有的字段类型
    public function getSystemFiledtype()
    {
        $parameterModel = new parameterModel();
        $filedtype = $parameterModel->where(["classid"=>"4" ])->all();
        return $filedtype;
    }
    
    //获取字段显示分类
    public function  getallfiledShowType()
    {
        $parameterModel = new parameterModel();
        $showtypeParameter = $parameterModel->where(["u1"=>"字段显示分类"])->one();
        $showtypeParameterClassid = $showtypeParameter['id'];
        $showtypeList = $parameterModel->getparameterByclassid($showtypeParameterClassid);
        return $showtypeList;
    }
    
    //获取字段显示分类
    public function  getfiledShowTypeBytableid($table_id)
    {
        $parameterModel = new parameterModel();
        $showtypeParameter = $parameterModel->where(["u1"=>"字段显示分类"])->one();
        $showtypeParameterClassid = $showtypeParameter['id'];
        $showtypeList = $parameterModel->getparameterByclassid($showtypeParameterClassid);
        $fieldModel = new filedModel();
        
        $showtypeList_new =[];
        foreach ($showtypeList as $k=>$v)
        {
            if($fieldModel->where(['u15'=>$v['u1'],'model_id'=>$table_id])->count()>0)
            {
                //unset($showtypeList[$k]);
                $showtypeList_new[] =$v;
            }
        }
        //var_dump($showtypeList);die();
        
        return $showtypeList_new;
    }
    
    
    //获取需要查询的字段
    public function  getsearchfiledByTableid($table_id)
    {
        $searchfiledList =  $this->find("*")->where(["model_id"=>$table_id,"u6"=>"是"])->orderBy("u10 asc,id desc ")->all();
        return $searchfiledList;
    }
    
    //获取需要显示的字段的字段
    public function  getshowfiledByTableid($table_id)
    {
        $showfiledList =  $this->find("*")->where(["model_id"=>$table_id,"u5"=>"是"])->orderBy("u10 asc,id desc ")->all();
        return $showfiledList;
    }
    
    //获取需要导出的字段
    public function  getexportfiledByTableid($table_id)
    {
        $showfiledList =  $this->find("*")->where(["model_id"=>$table_id,"u16"=>"是"])->orderBy("u10 asc,id desc ")->all();
        return $showfiledList;
    }
    
     
    
    public function getFiledDefaultValue($filed_id)
    {
        $defaultValueArray=array();
        $filedDetail=$this->findOne($filed_id);
        $defaultValue=$this->findOne($filed_id)['u8'];
        
        if($filedDetail["u7"]=="下拉框" || $filedDetail["u7"]=="单选"||$filedDetail["u7"]=="多选")
        {
            
            //匹配正则查询
            $result = array();
            preg_match_all("/(?:sql{)(.*)(?:})/i",$defaultValue, $result);
            if(!empty($result[1][0]))
            {
                $sql_string=$result[1][0]; 
            }else{
                $sql_string=""; 
            }
            
            
            if(strlen($sql_string)>0)
            {
                // sql{sl_zhuanjia|where 1=1|order by id desc|id,xingming}
                //sl_qudao|where id>0|order by id desc|ziyuanmingcheng
                $sql_array=explode("|", $sql_string);
                $table_name=$sql_array[0];
                $temp_model = new Model($table_name);
                //判断返回的select的 key 和 value
                $key_array=explode(",", $sql_array[3]);//查询的返回字段
                if(count($key_array)==0)
                {
                    $sql_array[3]=$sql_array[3].','.$sql_array[3];
                }
                $temp_array=$temp_model->findBySql(" select ".$sql_array[3]." from  "." ".$sql_array[0]." ".$sql_array[1]." ".$sql_array[2] );
                
                foreach ($temp_array as $k=>$v)
                {
                    //echo $v[$key_array[0]] ;die();
                    $defaultValueArray[$k]["key"]=$v[trim($key_array[0])];
                    $defaultValueArray[$k]["value"]=$v[trim($key_array[1])];
                }
                
            }else
            {
                $_defaultValueArray["key"]=explode("\n", $defaultValue);
                $_defaultValueArray["value"]=$_defaultValueArray["key"];
                foreach (explode("\n", $defaultValue) as $k=>$v)
                {
                    $defaultValueArray[$k]["key"]=$v;
                    $defaultValueArray[$k]["value"]=$v;
                }
            }
            return $defaultValueArray;
        }else  if($filedDetail["u7"]=="多条记录")
        {
            $tempArray=explode("|", $defaultValue);
            //多条字段默认通过 laiyuanbianhao 进行关联，也可自定义
            if(count($tempArray)==0)
            {
               $defaultValueArray["modelid"]=$tempArray[0];
               $defaultValueArray["fieldname"]="laiyuanbianhao";
            }else 
            {
                $defaultValueArray["modelid"]=$tempArray[0];
                $defaultValueArray["fieldname"]=$tempArray[1];
            }
            return $defaultValueArray;
              
        }else 
        {
            
            return $defaultValue;
            
        }
        
       
        
    }



    /**
    
    * 通过fieldID查询表名的ID
    
    * @date: 2018年11月19日 上午3:28:26
    
    * @author: 龚华尧
    
    * @param: variable
    
    * @return:
    
    */
    public function getTableidByFieldid($fieldid){
        $fieldDetail= $this->findOne($fieldid);
        if(empty($fieldDetail))
        {
            return "";
        }else{
            return $fieldDetail["model_id"];
        }
        
        
    }


}