<?php
class User_auth_model extends TW_Model {
    // 最终结果
    private $result;

	public function __construct() {
		parent :: __construct();
	}

	public function user_auth(){
		$s_field = 'uid';
		$a_data = $this->db ->from('member as a')
                            ->join('auth_realname as b',['a.id' => 'b.uid'])
                            ->get('', ['auth_status' => 0], $s_field);
        return  $a_data;
	}

    public function user_auth_update($user_auth_id,$auth_status){

        $a_data = $this->db->update('auth_realname',['auth_status' => $auth_status], ['uid' => $user_auth_id]);

        if(empty($a_data)){
            return $this->getError('1');
        }

        $this->result['status']   = true;
        $this->result['tips']     = '审核已修改';
        $this->result['url']      = $this->router->url('user_auth');;

        return $this->result;

    }


    //错误类型统计
    private function getError($errorNum, $url = '1') {
      switch ($errorNum) {
        case 1: $code = '10'; $case = "审核失败，请重新审核！"; break;

        default: $case= "未知错误";
      }
      switch ($url) {
        case 1: $url = $this->router->url('user_auth_update'); break;
        // default: $url= $this->router->url('id_verification');
      }
      $this->result['status'] 	= false;
      $this->result['tips'] 	= $case;
      $this->result['code'] 	= $code;
      $this->result['url'] 		= $url;

      return $this->result;
    }
}
?>
create table new_admin
(
    id mediumint unsigned not null auto_increment comment 'Id',
    username varchar(30) not null comment '用户名',
    password char(32) not null comment '密码',
    role_id char(32) not null comment '角色id',
    primary key (id)
)engine=InnoDB default charset=utf8 comment '管理员';

create table new_auth
(
    auth_id mediumint unsigned not null auto_increment comment 'Id',
    auth_name varchar(30) not null comment '权限名称',
    action_name varchar(30) not null default '' comment '路由名称',
    action_url varchar(30) not null default '' comment '路由地址',
    type varchar(30) not null default '' comment '类型,1、显示菜单,2、不显示菜单',
    parent_id mediumint unsigned not null default '0' comment '上级权限Id',
    primary key (auth_id)
)engine=InnoDB default charset=utf8 comment '权限';

create table `new_role` (
  `role_id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT COMMENT 'Id',
  `role_name` varchar(30) NOT NULL COMMENT '角色名称',
  `role_auth_id` varchar(30) NOT NULL COMMENT '权限id',
  PRIMARY KEY (`role_id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 COMMENT='角色' ;