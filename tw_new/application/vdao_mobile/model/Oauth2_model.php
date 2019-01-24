<?php

class Oauth2_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

	// 创建一个资源请求时验证
	public function oauth2_resource() {
		// 引入服务器对象文件
		require_once( PROJECTPATH . '/libraries/OAuth2/myserver.php' );
		if (!$server->verifyResourceRequest(OAuth2\Request::createFromGlobals())) {
		    $server->getResponse()->send();
		    die;
		} else {
			$access_token = $server->getAccessTokenData(OAuth2\Request::createFromGlobals());
			return $access_token;
		}
	}

	// 测试数据
	public function get_user_one($user_id) {
		$a_where = [
			'user_id' => $user_id
		];
		$a_data = $this->db->get_row('user', $a_where);
		return $a_data;
	}

}

?>