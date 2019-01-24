<?php
defined('BASEPATH') or exit('禁止访问！');

/**
 * 本类负责地图相关处理
 */
class Map_model extends TW_Model {
	
	// 授权key
	private $_s_key = 'fdddb7546df6ac5254145411eecc7e9d';
	// 骑手定位图片
	private $_s_rider_img = '';
	
	public function __construct() {
		parent :: __construct();
		$this->_s_rider_img = get_config_item('domain') . '/static/style_name/image/rider.png';
	}
	
	// 地图定位
	public function location($a_param) {
		$this->load->library('map_gaode');
		$a_param['location_longitude'] = $a_param['rider_longitude'];
		$a_param['location_latitude'] = $a_param['rider_latitude'];
		$a_html = $this->map_gaode->location($a_param);
		return $a_html;
		
		
		/*
		$a_html['map_code_head'] = '
			<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
			<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.4.3&key=' . $this->_s_key . '"></script>
			<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
		';
		// id名称必须为container，更改将不显示
		$s_id_name = empty($a_param['id_name']) ? 'container' : $a_param['id_name'];
		$f_center_longitude = empty($a_param['center_longitude']) ? $a_param['rider_longitude'] : $a_param['center_longitude'];
		$f_center_latitude = empty($a_param['center_latitude']) ? $a_param['rider_latitude'] : $a_param['center_latitude'];
		$i_img_width = empty($a_param['img_width']) ? 50 : $a_param['img_width'];
		$i_img_height = empty($a_param['img_height']) ? 50 : $a_param['img_height'];
		$s_img = empty($a_param['img']) ? $this->_s_rider_img : $a_param['img'];
		$a_html['map_code_body'] = '
			<div id="' . $s_id_name . '"></div>
			<script type="text/javascript">
			//初始化地图对象，加载地图
			var map = new AMap.Map("' . $s_id_name . '", {
				resizeEnable: true,
				center: [' . $f_center_longitude . ', ' . $f_center_latitude . '],//地图中心点
				zoom: 15 //地图显示的缩放级别
			});
			//添加点标记，并使用自己的icon
			new AMap.Marker({
				map: map,
				position: [' . $a_param['rider_longitude'] . ', ' . $a_param['rider_latitude'] . '],
				icon: new AMap.Icon({
					size: new AMap.Size(' . $i_img_width . ', ' . $i_img_height . '),  //图标大小
					image: "' . $s_img . '",
					imageOffset: new AMap.Pixel(0, 0)
				})
			});
		</script>
		';
		return $a_html;*/
	}
}
?>