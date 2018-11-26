<?php
class Tree
{
  
  /**
   +------------------------------------------------
   * 生成树型结构所需要的2维数组
   +------------------------------------------------
   * @author abc
   +------------------------------------------------
   * @var Array
   */
  var $arr = array();
  
  /**
   +------------------------------------------------
   * 生成树型结构所需修饰符号，可以换成图片
   +------------------------------------------------
   * @author abc
   +------------------------------------------------
   * @var Array
   */
  //var $icon = array("<em class='ficon ficon-down-open'></em>","<em class='ficon ficon-right-open'></em>","<em class='ficon ficon-up-open'></em>");
  var $icon = array(' &nbsp&nbsp&nbsp│ ',' &nbsp&nbsp&nbsp├─ ',' &nbsp&nbsp&nbsp└─ ');
  //public $icon = array('│','├','└');
  public $nbsp = " ";
  
  /**
  * @access private
  */
  var $ret = '';
  
  /**
  * 构造函数，初始化类
  * @param array 2维数组，例如：
  * array(
  *   1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
  *   2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
  *   3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
  *   4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
  *   5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
  *   6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
  *   7 => array('id'=>'7','parentid'=>3,'name'=>'三级栏目二')
  *   )
  */
  public function __construct($arr=array())
  {
    $this->arr = $arr;
    $this->ret = '';
    return is_array($arr);
  }
  
  /**
  * 得到父级数组
  * @param int
  * @return array
  */
  function get_parent($myid)
  {
    $newarr = array();
    $tree_data = array();
    foreach ($this->arr  as $key=>$value){
        $tree_data[$value['id']]=array(
            'id'=>$value['id'],
            'parentid'=>$value['parentid'],
            'name'=>$value['name']
        );
    }
    
    if(!isset($tree_data[$myid])) return false;
    $pid = $tree_data[$myid]['parentid'];
    $pid = $tree_data[$pid]['parentid'];
    if(is_array($tree_data))
    {
        foreach($tree_data as $id => $a)
          {
            if($a['parentid'] == $pid) $newarr[$id] = $a;
          }
    }
    return $newarr;
  }
  
  
  /**
   * 得到父级ID
   * @param int
   * @return array
   */
  function get_parentID($myid)
  {
      //转换数组
      $tree_data = array();
      foreach ($this->arr  as $key=>$value){
          $tree_data[$value['id']]=array(
              'id'=>$value['id'],
              'parentid'=>$value['parentid'],
              'name'=>$value['name']
          );
      }
      if(!isset($tree_data[$myid])) return false;
      $pid = $tree_data[$myid]['parentid'];
      
      return $pid;
  }
  
  /**
  * 得到子级数组
  * @param int
  * @return array
  */
  function get_child($myid)
  {
    $a = $newarr = array();
    if(is_array($this->arr))
    {
      foreach($this->arr as $id => $a)
      {
        if($a['parentid'] == $myid) $newarr[$id] = $a;
      }
    }
    return $newarr ? $newarr : false;
  }
  
  /**
  * 得到当前位置数组
  * @param int
  * @return array
  */
  function get_pos($myid,&$newarr)
  {
    $a = array();
    if(!isset($this->arr[$myid])) return false;
    $newarr[] = $this->arr[$myid];
    $pid = $this->arr[$myid]['parentid'];
    if(isset($this->arr[$pid]))
    {
      $this->get_pos($pid,$newarr);
    }
    if(is_array($newarr))
    {
      krsort($newarr);
      foreach($newarr as $v)
      {
        $a[$v['id']] = $v;
      }
    }
    return $a;
  }
  
  /**
   * -------------------------------------
   * 得到树型结构
   * -------------------------------------
   * @author abc
   * @param $myid 表示获得这个ID下的所有子级
   * @param $str 生成树形结构基本代码, 例如: "<option value=\$id \$select>\$spacer\$name</option>"
   * @param $sid 被选中的ID, 比如在做树形下拉框的时候需要用到
   * @param $adds
   * @param $str_group
   */
  function get_tree($myid, $str, $sid = 0, $adds = '', $str_group = '')
  {
    $number=1;
    $child = $this->get_child($myid);
    if(is_array($child)) {
      $total = count($child);
      foreach($child as $id=>$a) {
         // var_dump($a);flush();
        $j=$k='';
        if($number==$total) {
          $j .= $this->icon[2];
        } else {
          $j .= $this->icon[1];
          $k = $adds ? $this->icon[0] : '';
        }
        $spacer = $adds ? $adds.$j : '';
        $selected = $a['id']==$sid ? 'selected' : '';
        eval("\$nstr = \"$selected\";");
        
        @extract($a);
        $parentid == 0 && $str_group ? eval("\$nstr = \"$str_group\";") : eval("\$nstr = \"$str\";");
        $this->ret .= $nstr;
        $this->get_tree($id, $str, $sid, $adds.$k.' ',$str_group);
        $number++;
      }
    }
    return $this->ret;
  }
  
  /**
  * 同上一方法类似,但允许多选
  */
  function get_tree_multi($myid, $str, $sid = 0, $adds = '')
  {
    $number=1;
    $child = $this->get_child($myid);
    if(is_array($child))
    {
      $total = count($child);
      foreach($child as $id=>$a)
      {
        $j=$k='';
        if($number==$total)
        {
          $j .= $this->icon[2];
        }
        else
        {
          $j .= $this->icon[1];
          $k = $adds ? $this->icon[0] : '';
        }
        $spacer = $adds ? $adds.$j : '';
  
        $selected = $this->have($sid,$a['id']) ? "checked": '';
        eval("\$nstr = \"$selected\";");
        @extract($a);
        eval("\$nstr = \"$str\";");
        $this->ret .= $nstr;
        $this->get_tree_multi($id, $str, $sid, $adds.$k.' ');
        $number++;
      }
    }
    return $this->ret;
  }
  
  function have($list,$item){
    return(strpos(',,'.$list.',',','.$item.','));
  }
  
  /**
   +------------------------------------------------
   * 格式化数组
   +------------------------------------------------
   * @author abc
   +------------------------------------------------
   */
  function getArray($myid=0, $sid=0, $adds='')
  {
    $number=1;
    $child = $this->get_child($myid);
    if(is_array($child)) {
      $total = count($child);
      foreach($child as $id=>$a) {
        $j=$k='';
        if($number==$total) {
          $j .= $this->icon[2];
        } else {
          $j .= $this->icon[1];
          $k = $adds ? $this->icon[0] : '';
        }
        $spacer = $adds ? $adds.$j : '';
        @extract($a);
        $a['name'] = $spacer.' '.$a['name'];
        $this->ret[$a['id']] = $a;
        $fd = $adds.$k.' ';
        $this->getArray($id, $sid, $fd);
        $number++;
      }
    }
  
    return $this->ret;
  }
}



// 调用方法
// $data=array(
//     1 => array('id'=>'1','parentid'=>0,'name'=>'一级栏目一'),
//     2 => array('id'=>'2','parentid'=>0,'name'=>'一级栏目二'),
//     3 => array('id'=>'3','parentid'=>1,'name'=>'二级栏目一'),
//     4 => array('id'=>'4','parentid'=>1,'name'=>'二级栏目二'),
//     5 => array('id'=>'5','parentid'=>2,'name'=>'二级栏目三'),
//     6 => array('id'=>'6','parentid'=>3,'name'=>'三级栏目一'),
//     7 => array('id'=>'7','parentid'=>3,'name'=>''),
//     8 => array('id'=>'8','parentid'=>3,'name'=>'三级栏目三'),
//     9 => array('id'=>'9','parentid'=>7,'name'=>'四级分类三'),
// );
// $tree = new Tree;
// $tree->tree($data);

// // 如果使用数组, 请使用 getArray方法
// //$tree->getArray();
// // 下拉菜单选项使用 get_tree方法
// $html='<select name="tree">';
// $str = "<option value=\$id \$select>\$spacer\$name</option>";
// $html .= $tree->get_tree(0,$str,-1).'</select>';
// echo $html;



?>