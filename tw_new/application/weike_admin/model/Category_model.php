<?php
//无线分类类
class Category_model extends TW_Model {


	public function __construct() {
		parent :: __construct();
	}
	
    /**
     * [全部分类]
     */
	public function get_category(){
		$data=$this->db->from("categories")
					   ->order_by(['priority'=>'asc'])
					   ->where(['state'=>'1'])
					   ->get();
		return $data;
	}


    /**
     * [无线分类排序]
     */
	public function tree($list,$pid=0,$level=0,$html='--'){

	    static $tree = array(); 

	    foreach($list as $v){
	        if($v['parent_id'] == $pid){
	            $v['priority'] = $level;
	             $v['html'] = str_repeat($html,$level);
	            $tree[] = $v;
	            $this->tree($list,$v['id'],$level+1);
	        } 
	    }

	    return $tree;

	}

}
