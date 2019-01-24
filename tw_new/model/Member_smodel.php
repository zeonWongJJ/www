<?php
/*
  *组件化模块
  *管理会员功能组件
*/
class Member_smodel extends TW_Model {

	//允许使用该组件的项目
	public $a_in_task = array( 'jiajie', 'vdao', '7dugo');

	public $s_task_name = TASKNAME;


	public function __construct() {

		parent :: __construct();
		//加载组件数据库
		$this->load->database('db_task');
	}

	/************************************* 做项目的合法检测 *************************************/

	/**
	 * [check_in_task 检查某个项目是否在组件里有合法数据]
	 * @param  [string] $s_task_names [项目名]
	 * @param  [array]  $a_in_tasks [合法的项目列表]
	 * @return [boolean]             [返回查询到的数据]
	 */	
	private function check_in_task($s_task_names,$a_in_tasks){

		return !in_array($s_task_names,$a_in_tasks)? false: true;
		
	}

	/************************************* 获取某个项目多条用户信息 *************************************/

	/**
	 * [get_member_list 根据条件获取会员信息]
	 * @param  [string] $s_field [查询字段]
	 * @param  [array]  $a_where [查询条件]
	 * @param  [string] $task [传入项目标识 获取对应的项目会员数据 默认为all]
	 * @return [array]               [返回查询到的数据]
	 */
	public function get_member_list($s_field = '' , $a_where = array() ) {
		if( !$this->check_in_task($this->s_task_name,$this->a_in_task) ) {
			return '组件配置里没有该项目!';
			die;
		}		
		//$s_field为空则默认查询所有字段
		$s_field = empty($s_field)?'*':$s_field;
			
		//查询语句
		$a_where['item_type'] = $this->s_task_name;
		$a_data  = $this->db_task->get('user',$a_where , $s_field);
		return $a_data;
	}

/************************************* 获取某一个用户信息 *************************************/

	/**
	 * [get_member_one 根据手机号码或者用户名获取某个会员信息]
	 * @param  [string] $name_or_tel [传入的手机号码或者用户名]
	 * @param  [int]    $type        [type为1表示手机号码，type为2表示用户名]
	 * @return [array]               [返回查询到的数据]
	 */
	public function get_member_one($name_or_tel = '', $type = 1 ) {
		if( !$this->check_in_task($this->s_task_name,$this->a_in_task) ) {
			return '组件配置里没有该项目!';
			die;
		}		
		//检查name_or_tel传空值查询的情况
		if(empty($name_or_tel))return array();
			//查询条件判断
			$a_where['item_type'] = $this->s_task_name;
		if ($type == 1) {
			$a_where['user_phone'] = $name_or_tel;
		} else {
			$a_where['user_name'] = $name_or_tel;
		}
		//查询某条会员数据
		$a_data = $this->db_task->get_row('user', $a_where);
		return $a_data;
	}

	/************************************* 更新某条会员数据 *************************************/

	/**
	 * [update_member 更新会员数据]
	 * @param  [array] $a_where [更新的条件]
	 * @param  [array] $a_data  [更新的数据]
	 * @return [int]            [返回更新的行数]
	 */
	public function update_member( $a_where = array(), $a_data =array() ) {
		if( !$this->check_in_task($this->s_task_name,$this->a_in_task) ) {
			return '组件配置里没有该项目!';
			die;
		}		
		$a_where['item_type'] = $this->s_task_name;
		$i_result = $this->db_task->update('user', $a_data, $a_where);
		return $i_result;
	}

	/*********************************** 插入某个项目的会员数据 ***********************************/

	/**
	 * [insert_member 插入一条数据到user表]
	 * @param  [array] $a_data [要插入的数据]
	 * @param  [string]$s_task [要插入的某个项目的数据标识]
	 * @return [int]           [返回新数据的id]
	 */
	public function insert_member($a_data =array() ) {
		if( !$this->check_in_task($this->s_task_name,$this->a_in_task) ) {
			return '组件配置里没有该项目!';
			die;
		}		
		$a_data['item_type'] = $this->s_task_name;
		$i_result = $this->db_task->insert('user', $a_data);
		return $i_result;
	}

	/*********************************** 插入某个项目的多条会员数据 ***********************************/

	/**
	 * [inserts_member 插入多条数据到user表]
	 * @param  [array] $a_data [要插入的数据]
	 * @param  [string]$s_task [要插入的某个项目的数据标识]
	 * @return [int]           [返回新数据的id]
	 */
	public function inserts_member( $a_data = array() ) {
		
		foreach ($a_data as $key => $value) {
			$value['item_type'] = $this->s_task_name;
			$a_data[$key] = $value;
		}
		$i_result = $this->db_task->inserts('user', $a_data);
		return $i_result;
	}


	/******************************* 获取某个项目的同一用户名总条数 *******************************/

	/**
	 * [get_member_total 根据用户名获取总条数]
	 * @param  [array] $a_where [传入的用户名某个查询条件获取对应条件的总条数]
	 * @param [string] $s_task [某个项目的数据标识]
	 * @return [int]               [返回查询到的总条数]
	 */
	public function get_member_total($a_where =array() ) {
		if( !$this->check_in_task($this->s_task_name,$this->a_in_task) ) {
			return '组件配置里没有该项目!';
			die;
		}		
		$a_where['item_type'] = $this->s_task_name;
		$i_result = $this->db_task->get_total('user', $a_where);
		return $i_result;
	}

/******************************* 获取某个项目的会员信息 *******************************/

	/**
	 * [delete_member 根据用户名获取总条数]
	 * @param  [array] $a_where [传入的用户名某个查询条件]
	 * @param [string] $s_task [某个项目的数据标识]
	 * @return [boolean]        [返回结果]
	 */
	public function delete_member($a_where=array()) {
		if( !$this->check_in_task($this->s_task_name,$this->a_in_task) ) {
			return '组件配置里没有该项目!';
			die;
		}			
		$a_where['item_type'] = $this->s_task_name;
		$i_result = $this->db_task->delete('user', $a_where);
		return $i_result;
	}	
}
?>