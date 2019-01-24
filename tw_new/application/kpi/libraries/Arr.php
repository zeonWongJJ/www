<?php
defined('BASEPATH') OR exit('禁止访问！');
//对象转换数组并返回
class Arr{
	
	public function arr_data($a_data) {
		
		$data=array();
	    foreach ($a_data as $v) {
	    	$data[] = $v;
	    }
	    return $data;
	}

}


?>