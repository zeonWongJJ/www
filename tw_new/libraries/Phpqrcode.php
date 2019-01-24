<?php
defined('BASEPATH') OR exit('禁止访问！');

require_once(BASEPATH . '/libraries/pay/phpqrcode.php');

/**
 * 二维码类，基于phpqrcode二次封装
*/
class TW_phpqrcode {
	
	// 生成二维码
	public function qrcode($a_param) {
		ob_clean();
		if ( ! isset($a_param['data']) ) {
			exit('请输入二维码的生成内容');
		}
		if ( ! isset($a_param['level']) ) {
			$a_param['level'] = 'L';
		}
		if ( ! isset($a_param['file_name']) ) {
			$a_param['file_name'] = false;
		}
		if ( ! isset($a_param['size']) ) {
			$a_param['size'] = 50;
		}
		QRcode::png($a_param['data'], $a_param['file_name'], $a_param['level'], $a_param['size']);
	}
	
	// 中间加logo
	public function qrcode_logo($a_param) {
		$this->qrcode($a_param);
		$u_file_resource = imagecreatefromstring(file_get_contents($a_param['file_name']));
		$s_logo = imagecreatefromstring(file_get_contents($a_param['logo']));
		//二维码图片宽度
		$f_img_w = imagesx($u_file_resource);
		//二维码图片高度
		$f_img_h = imagesy($u_file_resource);
		//logo图片宽度
		$f_logo_width = imagesx($s_logo);
		//logo图片高度
		$f_logo_height = imagesy($s_logo);
		$f_logo_qr_width = $f_img_w / 5;
		$f_scale = $f_logo_width / $f_logo_qr_width;
		$f_logo_qr_height = $f_logo_height / $f_scale;
		$f_from_width = ($f_img_w - $f_logo_qr_width) / 2;
		imagecopyresampled($u_file_resource, $s_logo, $f_from_width, $f_from_width, 0, 0, $f_logo_qr_width,	$f_logo_qr_height, $f_logo_width, $f_logo_height);
		if (isset($a_param['file_name_logo'])) {
			imagepng($u_file_resource, $a_param['file_name_logo']);
		} else {
			header('content-type:image/png');
			imagepng($u_file_resource);
		}
		
		if (isset($a_param['del_file']) && $a_param['del_file'] == true) {
			unlink($a_param['file_name']);
		}
	}
}
?>