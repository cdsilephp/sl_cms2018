<?php

class Page{
	private $total;     // 总共有多少条记录
	private $pagenum;   // 分成多少页
	private $pagesize;  // 每页多少条记录
	private $current;   // 当前所在的页数
	private $url;       // url
	private $first;	    // 首页
	private $last;	    // 末页
	private $prev;	    // 上一页
	private $next;	    // 下一页
	
	/*
	 * $show_pages
	 * 页面显示的格式，显示链接的页数为2*$show_pages+1。
	 * 如$show_pages=2那么页面上显示就是[首页] [上页] 1 2 3 4 5 [下页] [尾页]
	 */
	private $show_pages;
	private $myde_page_count;     //总页数
	/**
	 * 构造函数
	 * @access public
	 * @param $total number 总的记录数
	 * @param $pagesize number 每页的记录数
	 * @param $current number 当前所在页
	 * @param $script string 当前请求的脚本名称,默认为空
	 * @param $params array url所携带的参数,默认为空
	 */
	public function __construct($total,$pagesize,$current,$script = '',$params = array(),$show_pages=2){
		$this->total = $total;
		$this->pagesize = $pagesize;
		$this->pagenum = $this->getNum();
		$this->current = $current;
		$this->show_pages=$show_pages;
		
		//设置url
		$p = array();
		foreach ($params as $k => $v) {
			$p[] = "$k=$v";
		}
		$this->url = $script . '?' . implode('&', $p) . '&page=';

		$this->first = $this->getFirst();
		$this->last = $this->getLast();
		$this->prev = $this->getPrev();
		$this->next = $this->getNext();
		
		
	}

	private function getNum(){
		return ceil($this->total / $this->pagesize);
	}

	private function getFirst(){
		if ($this->current == 1) {
			return '首页';
		} else {
			return "<a href='{$this->url}1'>首页<a/>";
		}
		
	}

	private function getLast(){
		if ($this->current == $this->pagenum) {
			return  '尾页';
		} else {
			return  "<a href='{$this->url}{$this->pagenum}'>尾页</a>";
		}
		
	}

	private function getPrev(){
		if ($this->current == 1) {
			return  '上一页';
		} else {
			return  "<a href='{$this->url}".($this->current - 1)."'>上一页</a>";
		}
		
	}

	private function getNext(){
		if ($this->current == $this->pagenum ){
			return  '下一页';
		} else {
			return  "<a href='{$this->url}".($this->current+1)."'>下一页</a>";
		}
		
	}

	/**
	 * getPage方法，得到分页信息
	 * @access public
	 * @return string 分页信息字符串
	 */
	public function showPage(){
	    //20161029 ghy
	    $this->myde_page_count = ceil($this->total / $this->pagesize);
	    $this->myde_i = $this->current - $this->show_pages;
	    $this->myde_en = $this->current + $this->show_pages;
	    
	    if ($this->myde_i < 1) {
	        $this->myde_en = $this->myde_en + (1 - $this->myde_i);
	        $this->myde_i = 1;
	    }
	    if ($this->myde_en > $this->myde_page_count) {
	        $this->myde_i = $this->myde_i - ($this->myde_en - $this->myde_page_count);
	        $this->myde_en = $this->myde_page_count;
	    }
	    if ($this->myde_i < 1)
	        $this->myde_i = 1;
	    
	    
	    
		if ($this->pagenum > 1){
		    $str="{$this->first} {$this->prev}";
		    //20161029 ghy
		    //echo $this->myde_en;
		    if ($this->myde_i > 1) {
		        $str.="<a>...</a>";
		    }
		    //echo $this->myde_i."  ".$this->myde_en;
		    for ($i = $this->myde_i; $i <= $this->myde_en; $i++) {
		        if ($i == $this->current) {
		            $str.="<a href='" . $this->url.$i . "' title='第" . $i . "页' class='on'>$i</a>";
		        } else {
		            $str.="<a href='" . $this->url.$i . "' title='第" . $i . "页' >$i</a>";
		        }
		    }
		    if ($this->myde_en < $this->myde_page_count) {
		        $str.="<a >...</a>";
		    }
		    
		    
			return $str." {$this->next} {$this->last}<a>每页 {$this->pagesize} 条，共有 {$this->total} 条,共{$this->myde_page_count}页</a> ";
		}else{
			return "共有 {$this->total} 条记录";
		}
		
	}
}

//使用：配合mysql操作类一起使用
/*
$total = $db->total();
$pagesize = 3;

$current = isset($_REQUEST['page']) ? $_REQUEST['page'] : 1;

$offset = ($current - 1) * $pagesize;
$rows = $db->getAll("SELECT * FROM category limit $offset,$pagesize" );

$page = new page($total,$pagesize,$current,'test.php',array('goods_id'=>2));

$str = "<table width='400' border='1'>";
$str .= "<tr><th>编号</th><th>名称</th><th>父编号</th></tr>";
foreach ($rows as $v) {
	$str .= '<tr>';
	$str .= "<td>{$v['cat_id']}</td>";
	$str .= "<td>{$v['cat_name']}</td>";
	$str .= "<td>{$v['parent_id']}</td>";
	$str .= '</tr>';
}
$str .= "</table>";

echo $str;

echo $page->showPage();
*/