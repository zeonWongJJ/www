<?php
class TW_Captcha {
	// 用来生成验证码的字符
	private $_s_string = 'abcdefghkmnprstuvwxyzABCDEFGHKMNPRSTUVWXYZ0123456789';
	// 验证码
	private $_s_code;
	// 验证码长度
	private $_i_code_length = 4;
	// 宽度
	private $_i_width = 130;
	// 高度
	private $_i_height = 50;
	// 图形资源句柄
	private $_o_image;
	// 指定的字体
	private $_s_font = BASEPATH . 'core/calibriz.ttf';
	// 指定字体大小，单位“磅”
	private $_i_font_size = 20;
	// 指定字体颜色，使用负的颜色索引值具有关闭防锯齿的效果，10进制颜色代码
	private $_i_font_color;
	// 干扰素雪花和点的数量
	private $_i_snowflake_num = 100;
	// 干扰素直线和椭圆弧线数量
	private $_i_line_num = 10;
	
	// 构造方法初始化
	public function __construct() {
		
	}
	
	// 设置干扰素雪花和点的数量
	public function snowflake($i_snowflake) {
		if ( ! empty($i_snowflake) ) {
			$this->_i_snowflake_num = $i_snowflake;
		}
		return $this;
	}
	
	// 设置干扰素直线和椭圆弧线数量
	public function line($i_line) {
		if ( ! empty($i_line) ) {
			$this->_i_line_num = $i_line;
		}
		return $this;
	}
	
	// 设置随机字符
	public function rand_string($s_string) {
		if ( ! empty($s_string) ) {
			$this->_s_string = $s_string;
		}
		return $this;
	}
	
	// 设置验证码
	public function code($s_code) {
		if ( ! empty($s_code) ) {
			$this->_s_code = $s_code;
		}
		return $this;
	}
	
	// 设置验证码长度
	public function length($i_length) {
		if ( ! empty($i_length) ) {
			$this->_i_code_length = $i_length;
		}
		return $this;
	}
	
	// 设置验证码宽度
	public function width($i_width) {
		if ( ! empty($i_width) ) {
			$this->_i_width = $i_width;
		}
		return $this;
	}
	
	// 设置验证码高度
	public function height($i_height) {
		if ( ! empty($i_height) ) {
			$this->_i_height = $i_height;
		}
		return $this;
	}
	
	// 设置验证码字体
	public function font($s_font) {
		if ( ! empty($s_font) ) {
			$this->_s_font = $s_font;
		}
		return $this;
	}
	
	// 设置验证码字体大小，单位“磅”
	public function size($i_size) {
		if ( ! empty($i_size) ) {
			$this->_i_font_size = $i_size;
		}
		return $this;
	}
	
	// 设置验证码字体颜色，使用负的颜色索引值具有关闭防锯齿的效果，10进制颜色代码
	public function color($i_color) {
		if ( ! empty($i_color) ) {
			$this->_i_font_color = $i_color;
		}
		return $this;
	}
	
	// 生成随机码
	private function random() {
		$i_code_length = strlen($this->_s_string) - 1;
		for ($i = 0; $i < $this->_i_code_length; $i++) {
			$this->_s_code .= $this->_s_string[mt_rand(0, $i_code_length)];
		}
	}
	
	// 生成背景
	private function create_back() {
		$this->_o_image = imagecreatetruecolor($this->_i_width, $this->_i_height);
		$s_color = imagecolorallocate($this->_o_image, mt_rand(157, 255), mt_rand(157, 255), mt_rand(157, 255));
		imagefilledrectangle($this->_o_image, 0, $this->_i_height, $this->_i_width, 0, $s_color);
	}
	
	// 生成文字
	private function create_font() {
		$i_color = $this->_i_font_color;
		$f_x = $this->_i_width / $this->_i_code_length;
		for ($i = 0; $i < $this->_i_code_length; $i++) {
			if ( empty($this->_i_font_color) ) {
				$i_color = imagecolorallocate($this->_o_image, mt_rand(0, 156), mt_rand(0, 156),mt_rand(0, 156));
			}	
			imagettftext($this->_o_image, $this->_i_font_size, mt_rand(-30, 30), $f_x * $i + mt_rand(1, 5), $this->_i_height / 1.4, $i_color, $this->_s_font, $this->_s_code[$i]);
		}
	}
	
	// 生成线条、雪花
	private function create_line() {
		// 加上点数
		for($i = 0; $i < $this->_i_snowflake_num; $i++) {
			$s_color = imagecolorallocate($this->_o_image, rand(0, 255), rand(0, 255), rand(0, 255)); 
			imagesetpixel($this->_o_image, rand(1, $this->_i_width - 2), rand(1, $this->_i_height - 2), $s_color);
		}
		// 加线条
		for ($i = 0; $i < $this->_i_line_num; $i++) {
			$s_color = imagecolorallocate($this->_o_image, mt_rand(0, 156), mt_rand(0, 156), mt_rand(0, 156));
			// 画直线
			imageline($this->_o_image, mt_rand(0, $this->_i_width), mt_rand(0, $this->_i_height), mt_rand(0, $this->_i_width), mt_rand(0, $this->_i_height), $s_color);
			// 画椭圆弧线
			imagearc($this->_o_image, rand(-10, $this->_i_width + 10), rand(-10, $this->_i_height + 10), rand(30, 300), rand(30, 300), 55, 44, $s_color);
		}
		// 加雪花
		for ($i = 0; $i < $this->_i_snowflake_num; $i++) {
			$s_color = imagecolorallocate($this->_o_image, mt_rand(200, 255), mt_rand(200, 255), mt_rand(200, 255));
			imagestring($this->_o_image, mt_rand(1, 5), mt_rand(0, $this->_i_width), mt_rand(0, $this->_i_height), '*', $s_color);
		}
	}
	
	// 输出
	private function print_image() {
		if (imagetypes() & IMG_GIF) {
			header("Content-Type:image/gif");
			imagepng($this->_o_image);
		} else if(imagetypes() & IMG_JPG) {
			header("Content-Type:image/jpeg");
			imagepng($this->_o_image);
		} else if(imagetypes() & IMG_PNG) {
			header("Content-Type:image/png");
			imagepng($this->_o_image);
		} else if(imagetypes() & IMG_WBMP) {
			header("Content-Type:image/vnd.wap.wbmp");
			imagepng($this->_o_image);
		}
		imagedestroy($this->_o_image);
	}
	
	// 对外生成
	public function image($i_width = '', $i_height = '', $i_font_size = '', $s_font = '', $i_font_color = '') {
		$this->width($i_width);
		$this->height($i_height);
		$this->font($s_font);
		$this->size($i_font_size);
		$this->color($i_font_color);
		
		$this->create_back();
		$this->random();
		$this->create_line();
		$this->create_font();
		$this->print_image();
	}
	
	// 获取验证码
	public function get_code() {
		return strtolower($this->_s_code);
	}
	
	// 析构函数
	public function __destruct(){
		
	}
}
?>