<?php
class Collect_model extends TW_Model {
	private $user_id;
    public function __construct() {
    	$this->userid=$_SESSION['user_id'];

    }

    public function collect_controller($type) {
    	switch ($type) {
    		case 1:

    			return $this->select_server();
    			break;
    		case 2:
    			return $this->select_xuqiu();
    			break;
    	}
    }
    //查询服务者
    public function select_server() {
    	$fields = 'name_user';
    	$table= 'collection as a';
    	$join_on=['a.collect_id' => 'b.id'];
    	$where=['a.member_id' => $this->userid,'a.type'=>'1'];
    	//查出所有数据
    	$data = $this->db->from($table)
			                   ->join('member as b',$join_on,INNER)
			                   ->where($where)
			                   ->get();
    	return $data;
    }
    //查询需求者
    public function select_xuqiu() {
    	$fields = 'name_user';
    	$table = 'collection as a';
    	$join_on = ['a.collect_id' => 'b.id'];
    	$where = ['a.member_id' => $this->userid, 'a.type'=>'2'];
    	//查出所有数据
    	$data = $this->db->from($table)
			                   ->join('member as b', $join_on, INNER)
			                   ->where($where)
			                   ->get();
    	return $data;
    }
    //删除收藏
	public function delete_xuqiu($id){
		$del_id = $this->db->delete('collection', ['id' => $id,'member_id'=>$this->userid]);
		return $del_id;
	}
    //收藏添加
	public function inserts_xuqiu($collect_id,$type) {
		$a_data = [
			'member_id' => $this->userid,
			'collect_id' => $collect_id,
			'collect_time' => $_SERVER['REQUEST_TIME'],
			'type' => $type
		];
		$inserts_xuqiu =  $this->db->insert('collection', $a_data);
		return $inserts_xuqiu;
	}
}
?>