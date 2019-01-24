<?php
defined('BASEPATH') OR exit('禁止访问！');

/**
 * 分页类
*/
class TW_Pages {
	private $_i_sum_rows = 0;		// 总行数
	private $_i_sum_pages = 0;		// 总页数
	private $_i_page = 1;			// 当前要显示的页
	private $_i_page_rows = 8;		// 每页显示的行数
	private $_i_start = 0;			// 从第几行开始查询
	private $_i_last = 0;			// 到第几行结束
	private $_b_page_out = false;	// 当前是否超出最大页
	
	public function __construct() {
		
	}
	
	/**
	 * 设置参数
	 *
	 * @param int $_i_sum_rows	总数据行数
	 * @param int $page		当前页码
	 * @param int $_i_page_rows	每页显示的行数
	 * @return Pages
	 */
	public function get($i_sum_rows, $i_page, $_i_page_rows = 20) {
		$this->_i_sum_rows = $i_sum_rows;
		$this->_i_page = $i_page;
		$this->_i__i_page_rows = $_i_page_rows;
		return $this->get_total_info();
	}
	
	/**
	 * 获取总页数
	*/
	public function get_sum_page() {
		$this->_i_sum_pages = ceil($this->_i_sum_rows / $this->_i__i_page_rows);
	}
	
	/**
	 * limit 语句的开始行和结束行
	*/
	private function get_offset() {
		if ($this->_i_sum_rows < 1) {
			return false;
		}
		if ($this->_i_page > $this->_i_sum_pages) {
			$this->_i_page = $this->_i_sum_pages;
		}
		if ($this->_i_page == $this->_i_sum_pages && $this->_i_sum_rows % $this->_i__i_page_rows != 0) {
			$last = $this->_i_sum_rows % $this->_i__i_page_rows;
		} else {
			$last = $this->_i__i_page_rows;
		}
		$start = ($this->_i_page - 1) * $this->_i__i_page_rows;
		$this->_i_start = $start;
		$this->_i_last = $last;
	}
	
	/**
	 * 获取总页数，总记录数，查询数据库的开始行，查询数据库的结束行
	 * @param $setPage 如果当前页是大于最后页，则把当前页设为最后页
	 * return array
	*/
	public function get_total_info($setPage = false) {
		$this->get_sum_page();
		// 判断当前页是否已经超过最大页
		$this->check_page_out();
		if ($setPage) {
			$this->set_page_max();
		}
		
		$this->get_offset();
		return array(
			'pages' => $this->_i_sum_pages,
			'rows' => $this->_i_sum_rows,
			'start' => $this->_i_start,
			'last' => $this->_i_last
		);
	}
	
	/**
	 * 返回$i_links个页码链接的首尾页码数
	*/
	public function links($i_links = 8) {
		if ($this->_i_sum_rows < 1) {
			return false;
		}
		//$a_link['start'] = ($this->_i_page > 3) ? $this->_i_page - 2 : 1;
		$i_half = floor(($i_links - 1) / 2);
		$a_link['start'] = $this->_i_page - $i_half;
		$a_link['start'] = $a_link['start'] > 0 ? $a_link['start'] : 1;
		if ($this->_i_page >= $this->_i_sum_pages) {
			$a_link['start'] = $this->_i_sum_pages - $i_links + 1;
			if ($a_link['start'] < 1) {
				$a_link['start'] = 1;
			}
			$a_link['last'] = $this->_i_sum_pages;
			return $a_link;
		}
		$a_link['last'] = $a_link['start'] + $i_links - 1;
		$a_link['last'] = $i_links > $a_link['last'] ? $i_links : $a_link['last'];
		if ($a_link['last'] > $this->_i_sum_pages) {
			$a_link['last'] = $this->_i_sum_pages;
		}
		/*if ($a_link['last'] - $a_link['start'] < $i_links && ($a_link['last'] - $i_links + 1) > 0) {
			$a_link['start'] = $a_link['last'] - $i_links + 1;
		}*/
		return $a_link;
	}
	
	/**
	 * 获得链接页码数组
	 * links() 函数返回的首尾页码
	 * @return array
	*/
	public function get_link_array($a_link) {
		$a_links = array();
		if (is_array($a_link)) {
			$j = 0;
			for ($i = $a_link['start']; $i <= $a_link['last']; $i++) {
				$a_links[$j] = $i;
				$j++;
			}
		}
		return $a_links;
	}
	
	/**
	 * 判断当前页是否已超出最大页
	 */
	private function check_page_out() {
		if ($this->_i_sum_pages > $this->_i_page) {
			$this->_i__b_page_out = true;
		}
	}
	
	/**
	 * 返回当前页是否已超出最大页
	 */
	public function get_page_out() {
		return $this->_i__b_page_out;
	}
	
	/**
	 * 把当前页设为最后页（最大页）
	 */
	private function set_page_max() {
		$this->_i__b_page_out = $this->_i_sum_pages;
	}
		
	/**
	 * 效果：首页  <<上一页  1  [2]  [3]  下一页>> 末页
	 * 返回处理好的HTML 链接
	 * $url string 例：index.php?page=
	 * $i_links int 最多显示页码链接数
	 * return string
	*/
	public function link_style_one($url, $i_links = 8, $suffix = '.html') {
		$a_link = $this->links($i_links);
		if (empty($a_link['last'])) {
			return '';
		}
		$s_links = '';
		if ($this->_i_page != 1) {
			$s_links = '<a href="' . $url . '1' . $suffix . '">首页</a>';
			$s_links .= '<a href="' . $url . (($this->_i_page - 1) ? ($this->_i_page - 1) : '1') . $suffix . '">上一页</a>';
		}
		for ($i = $a_link['start']; $i <= $a_link['last']; $i++) {
			if ($i == $this->_i_page) {
				$s_links .= '<a href="#"><b>' . $i . '</b></a>';
			} else {
				$s_links .= '<a href="' . $url . $i . $suffix . '">' . $i . '</a>';
			}
		}
		$s_links .= '<a href="' . $url . ((($this->_i_page + 1) > $this->_i_sum_pages) ? $this->_i_sum_pages : ($this->_i_page + 1)) . $suffix . '">下一页</a>';
		$s_links .= '<a href="' . $url . $this->_i_sum_pages . $suffix . '">末页</a>';
		return $s_links;
	}
	
	/**
	 * 效果：共1036条 - 第0-15条 - 第 1/70 页 转到第 页 共有记录: 1036 首页 上一页 下一页 尾页
	 * $url 例：index.php?page=
	*/
	public function link_style_two($url, $s_links = 8) {
		$a_link = $this->links($s_links);
		$s_links = '共' . $this->_i_sum_pages . '页 - ';
		$s_links .= '第' . $this->_i_start . '-' . ($this->_i_start + $this->_i_last) . '条 - ';
		$s_links .= '第 ' . $this->_i_page . '/' . $this->_i_sum_pages . ' 页  ';
		$s_links .= '转到第<input type="text" name="jump" size="5" onkeydown="if(event.keyCode==13) location=\'' . $url . '\'+this.value+\'\';" />页 ';
		$s_links .= '<input type="button" value="跳转" onclick="location=\'' . $url . '\'+document.getElementById(\'jump\').value+\'\';" />';
		$s_links .= '共有记录：' . $this->_i_sum_rows . ' ';
		$s_links .= '<a href="' . $url . '1" target="_self">首页</a>&nbsp;&nbsp;';
		$s_links .= '<a href="' . $url . (($this->_i_page - 1) ? ($this->_i_page - 1) : '1') . '" target="_self"><<上一页</a>&nbsp;&nbsp;';
		$s_links .= '<a href="' . $url . ((($this->_i_page + 1) > $this->_i_sum_pages) ? $this->_i_sum_pages : ($this->_i_page + 1)) . '" target="_self">下一页>></a>&nbsp;&nbsp;';
		$s_links .= '<a href="' . $url . $this->_i_sum_pages . '" target="_self">尾页</a>';
		return $s_links;
	}
}
?>