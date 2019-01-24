<?php
defined('BASEPATH') OR exit('禁止访问！');
/**
 * 搜索查询类
 */


class TW_Search {
	// 迅搜对象
	private $_o_xs;
	// 文档对象
	private $_o_xs_doc;
	// 迅搜索引对象
	private $_o_xs_index;
	// 迅搜查询对象
	private $_o_xs_search;
	// 当前支持的项目
	private $_a_project = ['wangyi120', '7dugo'];
	// 框架错误处理类对象
	private $_o_error;
	// 搜索词
	private $_s_keyword;
	
	public function __construct() {
		global $_o_error;
		$this->_o_error =& $_o_error;
		
		if (file_exists('/usr/local/webserver/xunsearch/sdk/php/lib/XS.php')) {
			require('/usr/local/webserver/xunsearch/sdk/php/lib/XS.php');
		} else {
			TW_Error :: debug('请在服务器上使用！');
		}
    }
    
	// 设置操作的项目
    public function project($s_project) {
		if ( ! in_array($s_project, $this->_a_project) ) {
			$this->_o_error->debug('项目不存在！');
		}
		
		$this->_o_xs = new XS($s_project);
		$this->_o_xs_index =& $this->_o_xs->index;
		$this->_o_xs_search =& $this->_o_xs->search;
		
		$this->_o_xs_doc = new XSDocument;
		
		$this->set_charset();
		return $this;
    }
	
	// 设置字符集
    public function set_charset($s_char = 'UTF-8') {
		$this->_o_xs->setDefaultCharset($s_char);
		$this->_o_xs_search->setCharset($s_char);
	}
	
	// 强制刷新缓存
    public function flush() {
		$this->_o_xs_index->flushIndex();
	}
	
	// 搜索词高亮，传入要进行高亮的字符串，高亮的词将加上em标签
    public function highlight($s_string) {
		return $this->_o_xs_search->highlight($s_string);
	}
	
	// 设置搜索词
    public function query($s_keyword = '') {
		// 最长只支持80个字符
		if (strlen($s_keyword) > 80) {
			$s_keyword = substr($s_keyword, 0, 80);
		}
		$this->_s_keyword = $s_keyword;
		$this->_o_xs_search->setQuery($this->_s_keyword);
		return $this;
	}
	
	// 开启模糊搜索
    public function fuzzy($b_unlock = true) {
		$this->_o_xs_search->setFuzzy($b_unlock);
		return $this;
	}
	
	// 开启同义词搜索
	public function synonym($b_unlock = true) {
		$this->_o_xs_search->setAutoSynonyms($b_unlock);
		return $this;
	}
	
	// 范围搜索，必须在query函数之后
	public function range($s_filed, $i_start, $i_end) {
		$this->_o_xs_search->addRange($s_filed, $i_start, $i_end);
		return $this;
	}
	
	// 排序，默认从小到大，false表示从大到小
	public function sort($s_filed, $b_sort = true) {
		$this->_o_xs_search->setSort($s_filed, $b_sort);
		return $this;
	}
	
	// 获取数据范围, $i_limit表示获取多少行，$i_offset表示从多少行开始
	public function limit($i_limit, $i_offset = 0) {
		$this->_o_xs_search->setLimit($i_limit, $i_offset);
		return $this;
	}
	
	// 获取匹配的数据
	public function get($s_project = '', $s_keyword = '', $i_limit = 0, $i_offset = 0) {
		if ( ! empty($s_project) ) {
			$this->project($s_project);
		}
		if ($this->_s_keyword === NULL) {
			$this->query($s_keyword);
		}
		if ($i_limit) {
			$this->limit($i_limit, $i_offset);
		}
		return $this->_o_xs_search->search();
	}
	
	// 获取匹配的总数量
	public function count() {
		return $this->_o_xs_search->count();
	}
	
	// 获取和 "搜索词" 相关的搜索词
	public function related($num = 10) {
		return $this->_o_xs_search->getRelatedQuery($this->_s_keyword, $num);
	}
	
	// 总索引数
	public function total() {
		return $this->_o_xs_search->getDbTotal();
	}
	
	// 更新索引
	public function update($a_data) {
		$this->_o_xs_doc->setFields($a_data);
		// 添加到索引数据库中
		$this->_o_xs_index->update($this->_o_xs_doc);
	}
	
	// 删除索引
	public function delete($m_data) {
		$this->_o_xs_index->del($m_data);
	}
}
?>