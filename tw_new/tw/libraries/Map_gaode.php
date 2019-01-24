<?php
// 高德地图 web 接口 http://lbs.amap.com/api/webservice/guide/api/georegeo

class TW_map_gaode {
	// 授权key
	private $_s_key = '96089bf909fc81e44d2004b1978f8c47';
	// general类对象
	public $o_general;
	
	public function __construct() {
		global $o_general;
		$this->o_general = $o_general;
	}

	/**
	 * 把地址转换成经纬度
	 * $s_address 需要转换的地址
	 * $a_param 其他可选参数，参数命名及使用参数和高德地图的接口文档一致 http://lbs.amap.com/api/webservice/guide/api/georegeo
	 */
	public function address_to_degree($s_address, $a_param = []) {
		$s_url = 'http://restapi.amap.com/v3/geocode/geo';
		$a_param['key'] = $this->_s_key;
		$a_param['address'] = $s_address;
		$s_result = $this->o_general->request($s_url, $a_param, 'GET');
		$a_result = json_decode($s_result, true);
		if (isset($a_result['geocodes'][0]) && is_array($a_result['geocodes'][0])) {
			$a_result['formatted_address'] = $a_result['geocodes'][0]['formatted_address'];
			$a_result['province'] = $a_result['geocodes'][0]['province'];
			$a_result['citycode'] = $a_result['geocodes'][0]['citycode'];
			$a_result['city'] = $a_result['geocodes'][0]['city'];
			$a_result['district'] = $a_result['geocodes'][0]['district'];
			$a_degree = explode(',', $a_result['geocodes'][0]['location']);
			$a_result['longitude'] = $a_degree[0];
			$a_result['latitude'] = $a_degree[1];
		}
		return $a_result;
	}
	
	/**
	 * 把经纬度转换成地址
	 * $s_degree 需要转换的经纬度
	 * $a_param 其他可选参数，参数命名及使用参数和高德地图的接口文档一致 http://lbs.amap.com/api/webservice/guide/api/georegeo
	 */
	public function degree_to_address($s_degree, $a_param = []) {
		$s_url = 'http://restapi.amap.com/v3/geocode/regeo';
		$a_param['key'] = $this->_s_key;
		$a_param['location'] = $s_degree;
		$s_result = $this->o_general->request($s_url, $a_param, 'GET');
		$a_result = json_decode($s_result, true);
		if (isset($a_result['regeocode']['formatted_address'])) {
			$a_result['address'] = $a_result['regeocode']['formatted_address'];
		}
		return $a_result;
	}
	
	/**
	 * 把IP转换成地址
	 * $s_ip 需要转换的ip
	 * $a_param 其他可选参数，参数命名及使用参数和高德地图的接口文档一致 http://lbs.amap.com/api/webservice/guide/api/ipconfig
	 */
	public function ip_to_address($s_ip = '', $a_param = []) {
		$s_url = 'http://restapi.amap.com/v3/ip';
		$a_param['key'] = $this->_s_key;
		$a_param['ip'] = $s_ip;
		$s_result = $this->o_general->request($s_url, $a_param, 'GET');
		$a_result = json_decode($s_result, true);
		if (isset($a_result['rectangle']) && !empty($a_result['rectangle'])) {
			$a_area = explode(';', $a_result['rectangle']);
			$a_area_lower_left = explode(',', $a_area[0]);
			// 左下的经度
			$a_result['longitude_lower_left'] = $a_area_lower_left[0];
			// 左下的纬度
			$a_result['latitude_lower_left'] = $a_area_lower_left[1];
			
			$a_area_upper_right = explode(',', $a_area[1]);
			// 右上的经度
			$a_result['longitude_upper_right'] = $a_area_upper_right[0];
			// 右上的纬度 
			$a_result['latitude_upper_right'] = $a_area_upper_right[1];
			
			// 折中点
			$a_result['longitude_center'] = round(($a_result['longitude_lower_left'] + $a_result['longitude_upper_right']) / 2, 8);
			$a_result['latitude_center'] = round(($a_result['latitude_lower_left'] + $a_result['latitude_upper_right']) / 2, 8);
		}
		return $a_result;
	}
	
	/**
	 * 获取天气信息
	 * $s_city 需要查询的城市，通过ip_to_address函数转换得到的adcode字段值
	 * $a_param 其他可选参数，参数命名及使用参数和高德地图的接口文档一致 http://lbs.amap.com/api/webservice/guide/api/weatherinfo
	 */
	public function weather($s_city, $a_param = []) {
		$s_url = 'http://restapi.amap.com/v3/weather/weatherInfo';
		$a_param['key'] = $this->_s_key;
		$a_param['city'] = $s_city;
		$s_result = $this->o_general->request($s_url, $a_param, 'GET');
		$a_result = json_decode($s_result, true);
		return $a_result;
	}
	
	/**
	 * 显示地图
	 * 
	 * $a_param 其他可选参数，参数命名及使用参数和高德地图的接口文档一致 http://lbs.amap.com/api/webservice/guide/api/staticmaps
	 */
	public function map($a_param) {
		header("Content-Type: image/png");
		$s_url = 'http://restapi.amap.com/v3/staticmap';
		$a_param['key'] = $this->_s_key;
		/*$a_param['location'] = $s_degree;*/
		$a_param['markers'] = '-1,http://ico.ooopic.com/ajax/iconpng/?id=158688.png,0:113.6770499,23.3809537';
		echo $this->o_general->request($s_url, $a_param, 'GET');
	}
	
	/**
	 * javascript api 地图定位，参数如下：
	[
	// 定位经度
	'location_longitude' => '',
	// 定位纬度
	'location_latitude' => '',
	// 可选，地图中心点经度，默认以骑手位置为中心点
	'center_longitude' => 113.33343,
	// 可选，地图中心点纬度，默认以骑手位置为中心点
	'center_latitude' => 22.96336,
	// 可选，骑手图标，图片链接
	'img' => 'http://lbs.amap.com/web/public/dist/avatar_default.01b559.png',
	// 可选，图片宽度
	'img_width' => 50,
	// 可选，图片高度
	'img_height' => 50
	]
	*/
	public function location($a_param) {
		$a_html['map_code_head'] = '
			<link rel="stylesheet" href="http://cache.amap.com/lbs/static/main1119.css"/>
			<script type="text/javascript" src="http://webapi.amap.com/maps?v=1.4.3&key=fdddb7546df6ac5254145411eecc7e9d"></script>
			<script type="text/javascript" src="http://cache.amap.com/lbs/static/addToolbar.js"></script>
		';
		// id名称必须为container，更改将不显示
		$s_id_name = empty($a_param['id_name']) ? 'container' : $a_param['id_name'];
		$f_center_longitude = empty($a_param['center_longitude']) ? $a_param['location_longitude'] : $a_param['center_longitude'];
		$f_center_latitude = empty($a_param['center_latitude']) ? $a_param['location_latitude'] : $a_param['center_latitude'];
		$i_img_width = empty($a_param['img_width']) ? 50 : $a_param['img_width'];
		$i_img_height = empty($a_param['img_height']) ? 50 : $a_param['img_height'];
		$s_img = empty($a_param['img']) ? 'http://distribution.7dugo.com/static/style_name/image/rider.png' : $a_param['img'];
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
				position: [' . $a_param['location_longitude'] . ', ' . $a_param['location_latitude'] . '],
				icon: new AMap.Icon({
					size: new AMap.Size(' . $i_img_width . ', ' . $i_img_height . '),  //图标大小
					image: "' . $s_img . '",
					imageOffset: new AMap.Pixel(0, 0)
				})
			});
		</script>
		';
		return $a_html;
	}
}
?>