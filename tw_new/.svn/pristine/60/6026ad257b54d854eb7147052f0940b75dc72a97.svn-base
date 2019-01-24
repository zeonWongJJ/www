<?php
class Manager_model extends TW_Model {


	public function __construct() {
		parent :: __construct();
	}
	
	//管理员列表信息
	public function list(){
		$s_field = 'a.id,a.username,b.role_name';
		return $this->db->from('admin as a')
                        ->join('role as b', ['a.role_id' => 'b.role_id'])
                        ->get('', '', $s_field);
	}

	// 添加管理员
	public function manager_add($post_data){
		$post_data['role_id']=1;
		$post_data['username']=1;
		$post_data['password']=1;

		return $this->db->insert('admin',$post_data);
	}

	//删除管理员
	public function manager_delete($id){
		$where['id']=$id;
		return $this->db->delete('admin',$where);
	}

}
?>