<?php
// 商品类型控制器
class menuController extends baseController
{
    // 显示商品类型
    public function indexAction()
    {
        
        // 使用模型获取所有栏目
        $menuModel = new menuModel('menu');
        $classidArray = $menuModel->getmenuByclassid("");
        $queryStr = trim( empty($_REQUEST['u1'])? "" : $_REQUEST['u1'] );
        
        $Common = $this->common;
        if ($queryStr != '') {
            if (!($Common->isName($queryStr))) {
                
                $this->jump('admin/menu/index', '输入值不合法');
            } else 
            {
                $data = $menuModel->findBySql(" select id,u1 as name ,u2,u3,classid as parentid from sl_menu where u1 like '%{$queryStr}%' order by id asc,u2 asc ");
                
            }
        }else 
        {
            $data = $menuModel->findBySql(" select *,u1 as name,classid as parentid from sl_menu  order by id asc,u2 asc");
            
        }
        
        
        //挂载 TREE 类
        $this->helper('tree');
        $tree =new Tree($data) ;
        
        
        
        // 如果使用数组, 请使用 getArray方法
        //$tree->getArray();
        // 下拉菜单选项使用 get_tree方法
        
        //$str = "<option value=\$id \$select>\$spacer\$name</option>";
        
        $str = "<tr>
        <td>\$u2</td>
        <td>\$id</td>
        <td>\$spacer \$name</td>
        <td><span class='co8'>\$u4</span></td>
        <td>
            <a title='增加菜单' data-href='/admin/menu/add?id=\$id' data-title='增加菜单'   class='layui-btn layui-btn-xs layui-btn-primary menu_anniu'>增加子类</a>
            <a title='编辑菜单' data-href='/admin/menu/edit?id=\$id' data-title='编辑菜单'  class='layui-btn layui-btn-xs layui-btn-primary menu_anniu'>编辑</a>
            <a title='删除' data-href='/admin/menu/delete?id=\$id'  data-title='删除'  class='layui-btn layui-btn-xs layui-btn-primary menu_anniu'>删除</a></td>
        </tr>";
        

        $html='';
        $html .= $tree->get_tree(0,$str,-1);
         
        
        // 载入模板页面
        include CUR_VIEW_PATH . "Smenu" . DS . "menu_list.html";
    }

    public function addAction()
    {
        $menuModel = new menuModel('menu');
        $id = trim(isset($_GET['id']) ? $_GET['id'] : "0");
        $type= trim(empty($_GET['type']) ? "" : $_GET['type']);
        $model_id= trim(empty($_GET['model_id']) ? "" : $_GET['model_id']);
        $sortid= trim(empty($_GET['sortid']) ? "" : $_GET['sortid']);
        
        $classidArray = $data = $menuModel->findBySql(" select *,u1 as name,classid as parentid from sl_menu  order by id asc,u2 asc");
        //挂载 TREE 类
        $this->helper('tree');
        $tree =new Tree($classidArray) ;
        
        $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
        $html_option='';
        $html_option .= $tree->get_tree(0,$str,$id);
        
        $lianjie = empty($_GET['url'])?"":$_GET['url'];
        $menuName =  empty($_GET['name'])?"":$_GET['name'] ;
        $lianjie = str_replace("ghy123", "?", $lianjie);
        $lianjie = str_replace("ghy321", "&", $lianjie);
        
        include CUR_VIEW_PATH . "Smenu" . DS . "menu_add.html";
    }
    // 完成类型入库操作
    public function insertAction()
    {
        $data_return["status"]=false;
        $data_return["msg"]="";
        $data_return["code"]=1;
        
        $menuModel = new menuModel();
        $data = $menuModel->getFieldArray();
        //var_dump($data);die();
        // 1.收集表单数据
        $data['classid'] = empty($data['classid']) ? '0': $data['classid'];
        
         $data['u4'] = empty($data['u4'])?"隐藏":"显示";
        // 2.验证和处理
        if ($data['u1'] == '') {
            $data_return["msg"]="栏目名称不能为空";
            $this->common->ajaxReturn($data_return);
        }
        if ($data['classid'] == '') {
            $data_return["msg"]="所属栏目不能为空";
            $this->common->ajaxReturn($data_return);
        }
        
        
        // 3.调用模型完成入库并给出提示
       
        if ($menuModel->insert($data)) {
//             // 如果是$_GET['type']=wenzhang 文章模型，将sortid及其子分类都添加到栏目
//             if (isset($_REQUEST['type']) and $_REQUEST['type'] != '') {
//                 $model_id = $_REQUEST['model_id'];
//                 $sortid = $_REQUEST['sortid'];
//                 $sortModel = new SortModel("sort");
//                 $menu_id = $menuModel->select("select * from `sl_menu` where classid = '{$data['classid']}' and u1 = '{$data['u1']}'  ORDER BY id desc LIMIT 1");
//                 $menu_id = $menu_id[0]['id'];
//                 $sortModel->addSubSortTomenu($sortid, $menu_id, $data);
//             }
            $data_return["status"]=true;
            $data_return["msg"]="添加成功";
            $data_return["code"]=0;
            
        } else {
            $data_return["msg"]="添加失败";
        }
        $this->common->ajaxReturn($data_return);
        
    }

    public function editAction()
    {
        $menuModel = new menuModel();
        $id = $this->common->Get("id");
        $classidArray = $menuModel->getmenuByclassid("");
        //挂载 TREE 类
        $this->helper('tree');
        $tree =new Tree($classidArray) ;
        
        $menu_detail = $menuModel->findOne($id);
        
        $str = "<option value=\$id  \$selected >\$spacer\$name</option>";
        $html_option='';
        $html_option .= $tree->get_tree(0,$str,$menu_detail['classid']);
        
        include CUR_VIEW_PATH . "Smenu" . DS . "menu_edit.html";
    }

    public function updateAction()
    {
        $data_return["status"]=false;
        $data_return["msg"]="";
        $data_return["code"]=1;
        
        $menuModel = new menuModel();
        // 1.收集表单数据
        $data = $menuModel->getFieldArray();
        $data['classid'] = empty($data['classid']) ? '0': $data['classid'];
        $data['u4'] = empty($data['u4'])?"隐藏":"显示";
        
        // 3.调用模型完成入库并给出提示
        if ($menuModel->update($data) > 0) {
            $data_return["status"]=true;
            $data_return["msg"]="修改成功";
            $data_return["code"]=0;
            
        } else {
            $data_return["msg"]="修改失败";
        }
        $this->common->ajaxReturn($data_return);
        
    }

    public function deleteAction()
    {
        $Common = $this->common;
        // 1.收集表单数据
        $data['id'] = $Common->Get("id");
        // 2.验证和处理
        
        if (! $Common->isNumber($data['id'])) {
            $this->jump('/admin/menu/index', 'ID不合法');
        }
        
        // 3.调用模型完成入库并给出提示
        $menuModel = new menuModel('menu');
        $menu_detail = $menuModel->findOne($data['id']);
        
        // 如果存在子栏目，则不能删除
        $classidArray = $menuModel->getmenuByclassid($data['id']);
        if (count($classidArray) > 0) {
            $this->jump('/admin/menu/index', '该栏目含有子栏目，请从最底层的栏目开始删除');
        }
        if ($menu_detail['laiyuan'] == "系统") {
            $this->jump('/admin/menu/index', '系统栏目，不能删除');
        } else {
            if ($menuModel->delete($data['id']) > 0) {
                $this->jump('/admin/menu/index', '删除成功',0);
            } else {
                $this->jump('/admin/menu/index', '删除失败');
            }
        }
    }
}