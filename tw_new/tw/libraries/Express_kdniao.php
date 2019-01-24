<?php
// 快递鸟文档 http://www.kdniao.com/file/%E5%BF%AB%E9%80%92%E9%B8%9F%E6%8E%A5%E5%8F%A3%E6%8A%80%E6%9C%AF%E6%96%87%E6%A1%A3v5.01.pdf

class TW_express_kdniao {
	// 用户ID
	private $_api_id = '1318495';
	// API key
	private $_api_key = '14e66802-6303-450f-972a-f266d1fadf87';
	// API URL
	private $_api_url = 'http://api.kdniao.cc/Ebusiness/EbusinessOrderHandle.aspx';
	// 物流公司对应代码的json数据
	private $_s_company_data = '';
	// 物流公司对应代码的数组
	private $_a_company_data = [];

	public function __construct() {
		$this->company_data();
	}

	// 物流信息查询文档： http://www.kdniao.com/api-track
	public function query($s_company, $s_number) {
		$a_param = [
			'OrderCode' => '',
			'ShipperCode' => $s_company,
			'LogisticCode' => $s_number,
		];
		$s_param = json_encode($a_param);
		$a_data = array(
			'EBusinessID' => $this->_api_id,
			'RequestType' => '1002',
			'RequestData' => urlencode($s_param),
			'DataType' => '2',
			'DataSign' => $this->encrypt($s_param)
		);
		$a_result = $this->get($a_data);
		
		return $a_result;
	}
	
	// 单号识别
	public function number_recognition($s_number) {
		$a_param = [
			'LogisticCode' => $s_number
		];
		$s_param = json_encode($a_param);
		$a_data = array(
			'EBusinessID' => $this->_api_id,
			'RequestType' => '2002',
			'RequestData' => urlencode($s_param),
			'DataType' => '2',
			'DataSign' => $this->encrypt($s_param)
		);
		$a_result = $this->get($a_data);
		return $a_result;
	}
	
	
	// 跟踪接口，需要数据存储支持，暂时不方便开发
	// 文档： http://www.kdniao.com/api-follow
	public function follow($s_company, $s_number) {
		
		$a_param = [
			'OrderCode' => '',
			'ShipperCode' => '',
			'LogisticCode' => '',
			'PayType' => '',
			'ExpType' => '',
			'IsNotice' => '',
			'Cost' => '',
			'OtherCost' => '',
			'Sender' => json_encode(),
			'Receiver' => json_encode(),
			'Commodity' => [json_encode()],
			'Weight' => '',
			'Quantity' => '',
			'Volume' => '',
			'Remark' => ''
		];
		$s_param = json_encode($a_param);
		$a_data = array(
			'EBusinessID' => $this->_api_id,
			'RequestType' => '1008',
			'RequestData' => urlencode($s_param),
			'DataType' => '2',
			'DataSign' => $this->encrypt($s_param)
		);
		$result=sendPost(ReqURL, $datas);	

		//根据公司业务处理返回的信息......

		return $result;
	}
	
	// 物流公司对应数据
	public function company_data() {
		$this->_s_company_data = '{"SF":"\u987a\u4e30\u901f\u8fd0","HTKY":"\u767e\u4e16\u5feb\u9012","ZTO":"\u4e2d\u901a\u5feb\u9012","STO":"\u7533\u901a\u5feb\u9012","YTO":"\u5706\u901a\u901f\u9012","YD":"\u97f5\u8fbe\u901f\u9012","YZPY":"\u90ae\u653f\u5feb\u9012\u5305\u88f9","EMS":"EMS","HHTT":"\u5929\u5929\u5feb\u9012","JD":"\u4eac\u4e1c\u7269\u6d41","QFKD":"\u5168\u5cf0\u5feb\u9012","GTO":"\u56fd\u901a\u5feb\u9012","UC":"\u4f18\u901f\u5feb\u9012","DBL":"\u5fb7\u90a6","FAST":"\u5feb\u6377\u5feb\u9012","ZJS":"\u5b85\u6025\u9001","AJ":"\u5b89\u6377\u5feb\u9012","AMAZON":"\u4e9a\u9a6c\u900a\u7269\u6d41","AOMENYZ":"\u6fb3\u95e8\u90ae\u653f","ANE":"\u5b89\u80fd\u7269\u6d41","AXD":"\u5b89\u4fe1\u8fbe\u5feb\u9012","AYCA":"\u6fb3\u90ae\u4e13\u7ebf","BDT":"\u516b\u8fbe\u901a","BFDF":"\u767e\u798f\u4e1c\u65b9","BHGJ":"\u8d1d\u6d77\u56fd\u9645","BQXHM":"\u5317\u9752\u5c0f\u7ea2\u5e3d","BFAY":"\u516b\u65b9\u5b89\u8fd0","BTWL":"\u767e\u4e16\u5feb\u8fd0","CCES":"CCES\u5feb\u9012","CG":"\u7a0b\u5149","CITY100":"\u57ce\u5e02100","CJKD":"\u57ce\u9645\u5feb\u9012","CNPEX":"CNPEX\u4e2d\u90ae\u5feb\u9012","COE":"COE\u5feb\u9012","CSCY":"\u957f\u6c99\u521b\u4e00","CDSTKY":"\u6210\u90fd\u5584\u9014\u901f\u8fd0","CTG":"\u8054\u5408\u8fd0\u901a","CBO":"CBO\u948f\u535a\u7269\u6d41","DSWL":"D\u901f\u7269\u6d41","DLG":"\u5230\u4e86\u6e2f","D4PX":"\u9012\u56db\u65b9\u901f\u9012","DTWL":"\u5927\u7530\u7269\u6d41","DJKJWL":"\u4e1c\u9a8f\u5feb","DEKUN":"\u5fb7\u5764","EWE":"EWE","FEDEX":"FEDEX\u8054\u90a6(\u56fd\u5185\u4ef6\uff09","FEDEX_GJ":"FEDEX\u8054\u90a6(\u56fd\u9645\u4ef6\uff09","CRAZY":"\u75af\u72c2\u5feb\u9012","FKD":"\u98de\u5eb7\u8fbe","FTD":"\u5bcc\u817e\u8fbe","GD":"\u51a0\u8fbe","GDEMS":"\u5e7f\u4e1c\u90ae\u653f","GSD":"\u5171\u901f\u8fbe","GTONG":"\u5e7f\u901a","GAI":"\u8fe6\u9012\u5feb\u9012","GTSD":"\u9ad8\u94c1\u901f\u9012","HFWL":"\u6c47\u4e30\u7269\u6d41","HGLL":"\u9ed1\u72d7\u51b7\u94fe","HLWL":"\u6052\u8def\u7269\u6d41","HOAU":"\u5929\u5730\u534e\u5b87","HOTSCM":"\u9e3f\u6865\u4f9b\u5e94\u94fe","HPTEX":"\u6d77\u6d3e\u901a\u7269\u6d41\u516c\u53f8","hq568":"\u534e\u5f3a\u7269\u6d41","HQSY":"\u73af\u7403\u901f\u8fd0","HXLWL":"\u534e\u590f\u9f99\u7269\u6d41","HXWL":"\u8c6a\u7fd4\u7269\u6d41","HYLSD":"\u597d\u6765\u8fd0\u5feb\u9012","JAD":"\u6377\u5b89\u8fbe","JGSD":"\u4eac\u5e7f\u901f\u9012","JIUYE":"\u4e5d\u66f3\u4f9b\u5e94\u94fe","JJKY":"\u4f73\u5409\u5feb\u8fd0","JLDT":"\u5609\u91cc\u56fd\u9645","JTKD":"\u6377\u7279\u5feb\u9012","JXD":"\u6025\u5148\u8fbe","JYKD":"\u664b\u8d8a\u5feb\u9012","JYM":"\u52a0\u8fd0\u7f8e","JGWL":"\u666f\u5149\u7269\u6d41","JYWL":"\u4f73\u6021\u7269\u6d41","KYSY":"\u8de8\u8d8a\u901f\u8fd0","LB":"\u9f99\u90a6\u5feb\u9012","LHT":"\u8054\u660a\u901a\u901f\u9012","MB":"\u6c11\u90a6\u5feb\u9012","MHKD":"\u6c11\u822a\u5feb\u9012","MK":"\u7f8e\u5feb","MDM":"\u95e8\u5bf9\u95e8\u5feb\u9012","MLWL":"\u660e\u4eae\u7269\u6d41","NF":"\u5357\u65b9","NEDA":"\u80fd\u8fbe\u901f\u9012","PADTF":"\u5e73\u5b89\u8fbe\u817e\u98de\u5feb\u9012","PANEX":"\u6cdb\u6377\u5feb\u9012","PJ":"\u54c1\u9a8f","PCA":"PCA Express","QCKD":"\u5168\u6668\u5feb\u9012","QRT":"\u5168\u65e5\u901a\u5feb\u9012","QXT":"\u5168\u4fe1\u901a","RFD":"\u5982\u98ce\u8fbe","RFEX":"\u745e\u4e30\u901f\u9012","SAD":"\u8d5b\u6fb3\u9012","SAWL":"\u5723\u5b89\u7269\u6d41","SBWL":"\u76db\u90a6\u7269\u6d41","SDWL":"\u4e0a\u5927\u7269\u6d41","SFWL":"\u76db\u4e30\u7269\u6d41","SHWL":"\u76db\u8f89\u7269\u6d41","ST":"\u901f\u901a\u7269\u6d41","STWL":"\u901f\u817e\u5feb\u9012","SUBIDA":"\u901f\u5fc5\u8fbe\u7269\u6d41","SDEZ":"\u901f\u9012e\u7ad9","SCZPDS":"\u901f\u5448\u5b85\u914d","SURE":"\u901f\u5c14\u5feb\u9012","TAIWANYZ":"\u53f0\u6e7e\u90ae\u653f","UAPEX":"\u5168\u4e00\u5feb\u9012","UEQ":"UEQ Express","WJK":"\u4e07\u5bb6\u5eb7","WJWL":"\u4e07\u5bb6\u7269\u6d41","WXWL":"\u4e07\u8c61\u7269\u6d41","XBWL":"\u65b0\u90a6\u7269\u6d41","XCWL":"\u8fc5\u9a70\u7269\u6d41","XFEX":"\u4fe1\u4e30\u5feb\u9012","XYT":"\u5e0c\u4f18\u7279","XJ":"\u65b0\u6770\u7269\u6d41","YADEX":"\u6e90\u5b89\u8fbe\u5feb\u9012","YCWL":"\u8fdc\u6210\u7269\u6d41","YCSY":"\u8fdc\u6210\u5feb\u8fd0","YDH":"\u4e49\u8fbe\u56fd\u9645\u7269\u6d41","YDT":"\u6613\u8fbe\u901a","YFEX":"\u8d8a\u4e30\u7269\u6d41","YFHEX":"\u539f\u98de\u822a\u7269\u6d41","YFSD":"\u4e9a\u98ce\u5feb\u9012","YTKD":"\u8fd0\u901a\u5feb\u9012","YXKD":"\u4ebf\u7fd4\u5feb\u9012","YUNDX":"\u8fd0\u4e1c\u897f","YMDD":"\u58f9\u7c73\u6ef4\u7b54","YZBK":"\u90ae\u653f\u56fd\u5185\u6807\u5feb","YFSUYUN":"\u9a6d\u4e30\u901f\u8fd0","ZENY":"\u589e\u76ca\u5feb\u9012","ZHQKD":"\u6c47\u5f3a\u5feb\u9012","ZTE":"\u4f17\u901a\u5feb\u9012","ZTKY":"\u4e2d\u94c1\u5feb\u8fd0","ZTWL":"\u4e2d\u94c1\u7269\u6d41","ZYWL":"\u4e2d\u90ae\u7269\u6d41","SJ":"\u90d1\u5dde\u901f\u6377","AAE":"AAE\u5168\u7403\u4e13\u9012","ACS":"ACS\u96c5\u4ed5\u5feb\u9012","ADP":"ADP Express Tracking","ANGUILAYOU":"\u5b89\u572d\u62c9\u90ae\u653f","APAC":"APAC","ARAMEX":"Aramex","AT":"\u5965\u5730\u5229\u90ae\u653f","AUSTRALIA":"Australia Post Tracking","BEL":"\u6bd4\u5229\u65f6\u90ae\u653f","BHT":"BHT\u5feb\u9012","BILUYOUZHE":"\u79d8\u9c81\u90ae\u653f","BR":"\u5df4\u897f\u90ae\u653f","BUDANYOUZH":"\u4e0d\u4e39\u90ae\u653f","CA":"\u52a0\u62ff\u5927\u90ae\u653f","DHL":"DHL","DHL_EN":"DHL(\u82f1\u6587\u7248)","DHL_GLB":"DHL\u5168\u7403","DHLGM":"DHL Global Mail","DK":"\u4e39\u9ea6\u90ae\u653f","DPD":"DPD","DPEX":"DPEX","EMSGJ":"EMS\u56fd\u9645","ESHIPPER":"EShipper","FQ":"FQ","GJEYB":"\u56fd\u9645e\u90ae\u5b9d","GJYZ":"\u56fd\u9645\u90ae\u653f\u5305\u88f9","GE2D":"GE2D","GT":"\u51a0\u6cf0","GLS":"GLS","IADLSQDYZ":"\u5b89\u7684\u5217\u65af\u7fa4\u5c9b\u90ae\u653f","IADLYYZ":"\u6fb3\u5927\u5229\u4e9a\u90ae\u653f","IAEBNYYZ":"\u963f\u5c14\u5df4\u5c3c\u4e9a\u90ae\u653f","IAEJLYYZ":"\u963f\u5c14\u53ca\u5229\u4e9a\u90ae\u653f","IAFHYZ":"\u963f\u5bcc\u6c57\u90ae\u653f","IAGLYZ":"\u5b89\u54e5\u62c9\u90ae\u653f","IAGTYZ":"\u963f\u6839\u5ef7\u90ae\u653f","IAJYZ":"\u57c3\u53ca\u90ae\u653f","IALBYZ":"\u963f\u9c81\u5df4\u90ae\u653f","IALQDYZ":"\u5965\u5170\u7fa4\u5c9b\u90ae\u653f","IALYYZ":"\u963f\u8054\u914b\u90ae\u653f","IAMYZ":"\u963f\u66fc\u90ae\u653f","IASBJYZ":"\u963f\u585e\u62dc\u7586\u90ae\u653f","IASEBYYZ":"\u57c3\u585e\u4fc4\u6bd4\u4e9a\u90ae\u653f","IASNYYZ":"\u7231\u6c99\u5c3c\u4e9a\u90ae\u653f","IASSDYZ":"\u963f\u68ee\u677e\u5c9b\u90ae\u653f","IBCWNYZ":"\u535a\u8328\u74e6\u7eb3\u90ae\u653f","IBDLGYZ":"\u6ce2\u591a\u9ece\u5404\u90ae\u653f","IBDYZ":"\u51b0\u5c9b\u90ae\u653f","IBELSYZ":"\u767d\u4fc4\u7f57\u65af\u90ae\u653f","IBHYZ":"\u6ce2\u9ed1\u90ae\u653f","IBJLYYZ":"\u4fdd\u52a0\u5229\u4e9a\u90ae\u653f","IBJSTYZ":"\u5df4\u57fa\u65af\u5766\u90ae\u653f","IBLNYZ":"\u9ece\u5df4\u5ae9\u90ae\u653f","IBLSD":"\u4fbf\u5229\u901f\u9012","IBLWYYZ":"\u73bb\u5229\u7ef4\u4e9a\u90ae\u653f","IBLYZ":"\u5df4\u6797\u90ae\u653f","IBMDYZ":"\u767e\u6155\u8fbe\u90ae\u653f","IBOLYZ":"\u6ce2\u5170\u90ae\u653f","IBTD":"\u5b9d\u901a\u8fbe","IBYB":"\u8d1d\u90ae\u5b9d","ICKY":"\u51fa\u53e3\u6613","IDFWL":"\u8fbe\u65b9\u7269\u6d41","IDGYZ":"\u5fb7\u56fd\u90ae\u653f","IE":"\u7231\u5c14\u5170\u90ae\u653f","IEGDEYZ":"\u5384\u74dc\u591a\u5c14\u90ae\u653f","IELSYZ":"\u4fc4\u7f57\u65af\u90ae\u653f","IELTLYYZ":"\u5384\u7acb\u7279\u91cc\u4e9a\u90ae\u653f","IFTWL":"\u98de\u7279\u7269\u6d41","IGDLPDEMS":"\u74dc\u5fb7\u7f57\u666e\u5c9bEMS","IGDLPDYZ":"\u74dc\u5fb7\u7f57\u666e\u5c9b\u90ae\u653f","IGJESD":"\u4fc4\u901f\u9012","IGLBYYZ":"\u54e5\u4f26\u6bd4\u4e9a\u90ae\u653f","IGLLYZ":"\u683c\u9675\u5170\u90ae\u653f","IGSDLJYZ":"\u54e5\u65af\u8fbe\u9ece\u52a0\u90ae\u653f","IHGYZ":"\u97e9\u56fd\u90ae\u653f","IHHWL":"\u534e\u7ff0\u7269\u6d41","IHLY":"\u4e92\u8054\u6613","IHSKSTYZ":"\u54c8\u8428\u514b\u65af\u5766\u90ae\u653f","IHSYZ":"\u9ed1\u5c71\u90ae\u653f","IJBBWYZ":"\u6d25\u5df4\u5e03\u97e6\u90ae\u653f","IJEJSSTYZ":"\u5409\u5c14\u5409\u65af\u65af\u5766\u90ae\u653f","IJKYZ":"\u6377\u514b\u90ae\u653f","IJNYZ":"\u52a0\u7eb3\u90ae\u653f","IJPZYZ":"\u67ec\u57d4\u5be8\u90ae\u653f","IKNDYYZ":"\u514b\u7f57\u5730\u4e9a\u90ae\u653f","IKNYYZ":"\u80af\u5c3c\u4e9a\u90ae\u653f","IKTDWEMS":"\u79d1\u7279\u8fea\u74e6EMS","IKTDWYZ":"\u79d1\u7279\u8fea\u74e6\u90ae\u653f","IKTEYZ":"\u5361\u5854\u5c14\u90ae\u653f","ILBYYZ":"\u5229\u6bd4\u4e9a\u90ae\u653f","ILKKD":"\u6797\u514b\u5feb\u9012","ILMNYYZ":"\u7f57\u9a6c\u5c3c\u4e9a\u90ae\u653f","ILSBYZ":"\u5362\u68ee\u5821\u90ae\u653f","ILTWYYZ":"\u62c9\u8131\u7ef4\u4e9a\u90ae\u653f","ILTWYZ":"\u7acb\u9676\u5b9b\u90ae\u653f","ILZDSDYZ":"\u5217\u652f\u6566\u58eb\u767b\u90ae\u653f","IMEDFYZ":"\u9a6c\u5c14\u4ee3\u592b\u90ae\u653f","IMEDWYZ":"\u6469\u5c14\u591a\u74e6\u90ae\u653f","IMETYZ":"\u9a6c\u8033\u4ed6\u90ae\u653f","IMJLGEMS":"\u5b5f\u52a0\u62c9\u56fdEMS","IMLGYZ":"\u6469\u6d1b\u54e5\u90ae\u653f","IMLQSYZ":"\u6bdb\u91cc\u6c42\u65af\u90ae\u653f","IMLXYEMS":"\u9a6c\u6765\u897f\u4e9aEMS","IMLXYYZ":"\u9a6c\u6765\u897f\u4e9a\u90ae\u653f","IMQDYZ":"\u9a6c\u5176\u987f\u90ae\u653f","IMTNKEMS":"\u9a6c\u63d0\u5c3c\u514bEMS","IMTNKYZ":"\u9a6c\u63d0\u5c3c\u514b\u90ae\u653f","IMXGYZ":"\u58a8\u897f\u54e5\u90ae\u653f","INFYZ":"\u5357\u975e\u90ae\u653f","INRLYYZ":"\u5c3c\u65e5\u5229\u4e9a\u90ae\u653f","INWYZ":"\u632a\u5a01\u90ae\u653f","IPTYYZ":"\u8461\u8404\u7259\u90ae\u653f","IQQKD":"\u5168\u7403\u5feb\u9012","IQTWL":"\u5168\u901a\u7269\u6d41","ISDYZ":"\u82cf\u4e39\u90ae\u653f","ISEWDYZ":"\u8428\u5c14\u74e6\u591a\u90ae\u653f","ISEWYYZ":"\u585e\u5c14\u7ef4\u4e9a\u90ae\u653f","ISLFKYZ":"\u65af\u6d1b\u4f10\u514b\u90ae\u653f","ISLWNYYZ":"\u65af\u6d1b\u6587\u5c3c\u4e9a\u90ae\u653f","ISNJEYZ":"\u585e\u5185\u52a0\u5c14\u90ae\u653f","ISPLSYZ":"\u585e\u6d66\u8def\u65af\u90ae\u653f","ISTALBYZ":"\u6c99\u7279\u963f\u62c9\u4f2f\u90ae\u653f","ITEQYZ":"\u571f\u8033\u5176\u90ae\u653f","ITGYZ":"\u6cf0\u56fd\u90ae\u653f","ITLNDHDBGE":"\u7279\u7acb\u5c3c\u8fbe\u548c\u591a\u5df4\u54e5EMS","ITNSYZ":"\u7a81\u5c3c\u65af\u90ae\u653f","ITSNYYZ":"\u5766\u6851\u5c3c\u4e9a\u90ae\u653f","IWDMLYZ":"\u5371\u5730\u9a6c\u62c9\u90ae\u653f","IWGDYZ":"\u4e4c\u5e72\u8fbe\u90ae\u653f","IWKLEMS":"\u4e4c\u514b\u5170EMS","IWKLYZ":"\u4e4c\u514b\u5170\u90ae\u653f","IWLGYZ":"\u4e4c\u62c9\u572d\u90ae\u653f","IWLYZ":"\u6587\u83b1\u90ae\u653f","IWZBKSTEMS":"\u4e4c\u5179\u522b\u514b\u65af\u5766EMS","IWZBKSTYZ":"\u4e4c\u5179\u522b\u514b\u65af\u5766\u90ae\u653f","IXBYYZ":"\u897f\u73ed\u7259\u90ae\u653f","IXFLWL":"\u5c0f\u98de\u9f99\u7269\u6d41","IXGLDNYYZ":"\u65b0\u5580\u91cc\u591a\u5c3c\u4e9a\u90ae\u653f","IXJPEMS":"\u65b0\u52a0\u5761EMS","IXJPYZ":"\u65b0\u52a0\u5761\u90ae\u653f","IXLYYZ":"\u53d9\u5229\u4e9a\u90ae\u653f","IXLYZ":"\u5e0c\u814a\u90ae\u653f","IXPSJ":"\u590f\u6d66\u4e16\u7eaa","IXPWL":"\u590f\u6d66\u7269\u6d41","IXXLYZ":"\u65b0\u897f\u5170\u90ae\u653f","IXYLYZ":"\u5308\u7259\u5229\u90ae\u653f","IYDLYZ":"\u610f\u5927\u5229\u90ae\u653f","IYDNXYYZ":"\u5370\u5ea6\u5c3c\u897f\u4e9a\u90ae\u653f","IYDYZ":"\u5370\u5ea6\u90ae\u653f","IYGYZ":"\u82f1\u56fd\u90ae\u653f","IYLYZ":"\u4f0a\u6717\u90ae\u653f","IYMNYYZ":"\u4e9a\u7f8e\u5c3c\u4e9a\u90ae\u653f","IYMYZ":"\u4e5f\u95e8\u90ae\u653f","IYNYZ":"\u8d8a\u5357\u90ae\u653f","IYSLYZ":"\u4ee5\u8272\u5217\u90ae\u653f","IYTG":"\u6613\u901a\u5173","IYWWL":"\u71d5\u6587\u7269\u6d41","IZBLTYZ":"\u76f4\u5e03\u7f57\u9640\u90ae\u653f","IZLYZ":"\u667a\u5229\u90ae\u653f","JP":"\u65e5\u672c\u90ae\u653f","SYJHE":"\u4f73\u60e0\u5c14","LYT":"\u8054\u8fd0\u901a","LHKDS":"\u8054\u5408\u5feb\u9012","SHLDHY":"\u6797\u9053\u56fd\u9645","NL":"\u8377\u5170\u90ae\u653f","NSF":"\u65b0\u987a\u4e30","ONTRAC":"ONTRAC","OCS":"OCS","QQYZ":"\u5168\u7403\u90ae\u653f","POSTEIBE":"POSTEIBE","PAPA":"\u556a\u556a\u4f9b\u5e94\u94fe","QYHY":"\u79e6\u8fdc\u6d77\u8fd0","VENUCIA":"\u542f\u8fb0\u56fd\u9645","RDSE":"\u745e\u5178\u90ae\u653f","SKYPOST":"SKYPOST","SWCH":"\u745e\u58eb\u90ae\u653f","JYSD":"\u4e0a\u6d77\u4e45\u6613\u56fd\u9645","TAILAND138":"\u6cf0\u56fd138","TNT":"TNT\u5feb\u9012","UPS":"UPS","USPS":"USPS\u7f8e\u56fd\u90ae\u653f","XKGJ":"\u661f\u7a7a\u56fd\u9645","YAMA":"\u65e5\u672c\u5927\u548c\u8fd0\u8f93(Yamato)","YODEL":"YODEL","YHXGJSD":"\u4e00\u53f7\u7ebf","YUEDANYOUZ":"\u7ea6\u65e6\u90ae\u653f","YMSY":"\u73a5\u739b\u901f\u8fd0","YYSD":"\u9e70\u8fd0","YBG":"\u6d0b\u5305\u88f9","AOL":"AOL\uff08\u6fb3\u901a\uff09","BCWELT":"BCWELT","BN":"\u7b28\u9e1f\u56fd\u9645","UEX":"UEX","ZY_AG":"\u7231\u8d2d\u8f6c\u8fd0","ZY_AOZ":"\u7231\u6b27\u6d32","ZY_AUSE":"\u6fb3\u4e16\u901f\u9012","ZY_AXO":"AXO","ZY_AZY":"\u6fb3\u8f6c\u8fd0","ZY_BDA":"\u516b\u8fbe\u7f51","ZY_BEE":"\u871c\u8702\u901f\u9012","ZY_BH":"\u8d1d\u6d77\u901f\u9012","ZY_BL":"\u767e\u5229\u5feb\u9012","ZY_BM":"\u6591\u9a6c\u7269\u6d41","ZY_BOZ":"\u8d25\u6b27\u6d32","ZY_BT":"\u767e\u901a\u7269\u6d41","ZY_BYECO":"\u8d1d\u6613\u8d2d","ZY_CM":"\u7b56\u9a6c\u8f6c\u8fd0","ZY_CTM":"\u8d64\u5154\u9a6c\u8f6c\u8fd0","ZY_CUL":"CUL\u4e2d\u7f8e\u901f\u9012","ZY_DGHT":"\u5fb7\u56fd\u6d77\u6dd8\u4e4b\u5bb6","ZY_DYW":"\u5fb7\u8fd0\u7f51","ZY_EFS":"EFS POST","ZY_ESONG":"\u5b9c\u9001\u8f6c\u8fd0","ZY_ETD":"ETD","ZY_FD":"\u98de\u789f\u5feb\u9012","ZY_FG":"\u98de\u9e3d\u5feb\u9012","ZY_FLSD":"\u98ce\u96f7\u901f\u9012","ZY_FX":"\u98ce\u884c\u5feb\u9012","ZY_FXSD":"\u98ce\u884c\u901f\u9012","ZY_FY":"\u98de\u6d0b\u5feb\u9012","ZY_HC":"\u7693\u6668\u5feb\u9012","ZY_HCYD":"\u7693\u6668\u4f18\u9012","ZY_HDB":"\u6d77\u5e26\u5b9d","ZY_HFMZ":"\u6c47\u4e30\u7f8e\u4e2d\u901f\u9012","ZY_HJSD":"\u8c6a\u6770\u901f\u9012","ZY_HTAO":"360hitao\u8f6c\u8fd0","ZY_HTCUN":"\u6d77\u6dd8\u6751","ZY_HTKE":"365\u6d77\u6dd8\u5ba2","ZY_HTONG":"\u534e\u901a\u5feb\u8fd0","ZY_HXKD":"\u6d77\u661f\u6865\u5feb\u9012","ZY_HXSY":"\u534e\u5174\u901f\u8fd0","ZY_HYSD":"\u6d77\u60a6\u901f\u9012","ZY_IHERB":"LogisticsY","ZY_JA":"\u541b\u5b89\u5feb\u9012","ZY_JD":"\u65f6\u4ee3\u8f6c\u8fd0","ZY_JDKD":"\u9a8f\u8fbe\u5feb\u9012","ZY_JDZY":"\u9a8f\u8fbe\u8f6c\u8fd0","ZY_JH":"\u4e45\u79be\u5feb\u9012","ZY_JHT":"\u91d1\u6d77\u6dd8","ZY_LBZY":"\u8054\u90a6\u8f6c\u8fd0FedRoad","ZY_LPZ":"\u9886\u8dd1\u8005\u5feb\u9012","ZY_LX":"\u9f99\u8c61\u5feb\u9012","ZY_LZWL":"\u91cf\u5b50\u7269\u6d41","ZY_MBZY":"\u660e\u90a6\u8f6c\u8fd0","ZY_MGZY":"\u7f8e\u56fd\u8f6c\u8fd0","ZY_MJ":"\u7f8e\u5609\u5feb\u9012","ZY_MST":"\u7f8e\u901f\u901a","ZY_MXZY":"\u7f8e\u897f\u8f6c\u8fd0","ZY_MZ":"168 \u7f8e\u4e2d\u5feb\u9012","ZY_OEJ":"\u6b27e\u6377","ZY_OZF":"\u6b27\u6d32\u75af","ZY_OZGO":"\u6b27\u6d32GO","ZY_QMT":"\u5168\u7f8e\u901a","ZY_QQEX":"QQ-EX","ZY_RDGJ":"\u6da6\u4e1c\u56fd\u9645\u5feb\u7ebf","ZY_RT":"\u745e\u5929\u5feb\u9012","ZY_RTSD":"\u745e\u5929\u901f\u9012","ZY_SCS":"SCS\u56fd\u9645\u7269\u6d41","ZY_SDKD":"\u901f\u8fbe\u5feb\u9012","ZY_SFZY":"\u56db\u65b9\u8f6c\u8fd0","ZY_SOHO":"SOHO\u82cf\u8c6a\u56fd\u9645","ZY_SONIC":"Sonic-Ex\u901f\u9012","ZY_ST":"\u4e0a\u817e\u5feb\u9012","ZY_TCM":"\u901a\u8bda\u7f8e\u4e2d\u5feb\u9012","ZY_TJ":"\u5929\u9645\u5feb\u9012","ZY_TM":"\u5929\u9a6c\u8f6c\u8fd0","ZY_TN":"\u6ed5\u725b\u5feb\u9012","ZY_TPAK":"TrakPak","ZY_TPY":"\u592a\u5e73\u6d0b\u5feb\u9012","ZY_TSZ":"\u5510\u4e09\u85cf\u8f6c\u8fd0","ZY_TTHT":"\u5929\u5929\u6d77\u6dd8","ZY_TWC":"TWC\u8f6c\u8fd0\u4e16\u754c","ZY_TX":"\u540c\u5fc3\u5feb\u9012","ZY_TY":"\u5929\u7ffc\u5feb\u9012","ZY_TZH":"\u540c\u821f\u5feb\u9012","ZY_UCS":"UCS\u5408\u4f17\u5feb\u9012","ZY_WDCS":"\u6587\u8fbe\u56fd\u9645DCS","ZY_XC":"\u661f\u8fb0\u5feb\u9012","ZY_XDKD":"\u8fc5\u8fbe\u5feb\u9012","ZY_XDSY":"\u4fe1\u8fbe\u901f\u8fd0","ZY_XF":"\u5148\u950b\u5feb\u9012","ZY_XGX":"\u65b0\u5e72\u7ebf\u5feb\u9012","ZY_XIYJ":"\u897f\u90ae\u5bc4","ZY_XJ":"\u4fe1\u6377\u8f6c\u8fd0","ZY_YGKD":"\u4f18\u8d2d\u5feb\u9012","ZY_YJSD":"\u53cb\u5bb6\u901f\u9012(UCS)","ZY_YPW":"\u4e91\u7554\u7f51","ZY_YQ":"\u4e91\u9a91\u5feb\u9012","ZY_YQWL":"\u4e00\u67d2\u7269\u6d41","ZY_YSSD":"\u4f18\u665f\u901f\u9012","ZY_YSW":"\u6613\u9001\u7f51","ZY_YTUSA":"\u8fd0\u6dd8\u7f8e\u56fd","ZY_ZCSD":"\u81f3\u8bda\u901f\u9012"}';
		$this->_a_company_data = json_decode($this->_s_company_data, true);
		return $this->_a_company_data;
	}
	
	// 把快递公司对应代码表的excel文件，转换成变量存储，以便查询使用
	// 生成到当前文件，需要可写权限
	// 删除网站下载文件的标题栏及左边无用的列，默认以第一列为数组下标，第二列为物流公司名
	public function excel_to_json($s_xml_path = './1.xml') {
		$o_tw =& get_instance();
		$o_tw->load->library('wxpay_h5');
		$s_xml = file_get_contents($s_xml_path);
		$a_data = $o_tw->wxpay_h5->xml_to_array($s_xml);
		$a_list = [];
		/*$a_letter = [
			'常用', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P',
			'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'
		];*/
		foreach ($a_data['Worksheet']['Table']['Row'] as $i_key => $a_row) {
			$s_array_0 = trim($a_row['Cell'][0]['Data']);
			$s_array_1 = trim($a_row['Cell'][1]['Data']);
			$s_array_2 = trim($a_row['Cell'][2]['Data']);
			$s_array_3 = trim($a_row['Cell'][3]['Data']);
			
			$a_list[$s_array_1] = $s_array_0;
		}
		$a_list = array_filter($a_list);
		$s_list = json_encode($a_list);
		
		// 开始写入
		$s_content = file_get_contents(BASEPATH . '/libraries/Express_kdniao.php');
		$s_content = str_replace($this->_s_company_data, $s_list, $s_content);
		file_put_contents(BASEPATH . '/libraries/Express_kdniao.php', $s_content);
	}
	
	// 发起请求
	public function get($m_data, $a_header = NULL) {
		// 优先使用curl模式发送数据
		if (function_exists('curl_init') == 1) {
			if (is_array($m_data)) {
				$m_data = http_build_query($m_data);
			}
			$o_curl = curl_init();
			// 超时时间
			curl_setopt($o_curl, CURLOPT_TIMEOUT, 30);
			curl_setopt($o_curl, CURLOPT_RETURNTRANSFER, 1);
			// 这里设置代理，如果有的话
			//curl_setopt($o_curl, CURLOPT_PROXY, '10.206.30.98');
			//curl_setopt($o_curl, CURLOPT_PROXYPORT, 8080);
			curl_setopt($o_curl, CURLOPT_URL, $this->_api_url);
			curl_setopt($o_curl, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($o_curl, CURLOPT_SSL_VERIFYHOST, false);
		 
			// 设置host
			if( is_array($a_header) && ! empty($a_header) ){
				curl_setopt($o_curl, CURLOPT_HTTPHEADER, $a_header);
			}
		 
			curl_setopt($o_curl, CURLOPT_POST, 1);
			curl_setopt($o_curl, CURLOPT_POSTFIELDS, $m_data);
			$s_content = curl_exec($o_curl);
			
		} else {
			$a_temp = array();
			foreach ($a_data as $u_key => $u_value) {
				$a_temp[] = sprintf('%s=%s', $u_key, $u_value);		
			}	
			$s_post_data = implode('&', $a_temp);
			$a_url_info = parse_url($this->_api_url);
			if(empty($a_url_info['port'])) {
				$a_url_info['port'] = 80;	
			}
			$s_httpheader = "POST " . $a_url_info['path'] . " HTTP/1.0\r\n";
			$s_httpheader .= "Host:" . $a_url_info['host'] . "\r\n";
			$s_httpheader .= "Content-Type:application/x-www-form-urlencoded\r\n";
			$s_httpheader .= "Content-Length:" . strlen($s_post_data) . "\r\n";
			$s_httpheader .= "Connection:close\r\n\r\n";
			$s_httpheader .= $s_post_data;
			$o_fd = fsockopen($a_url_info['host'], $a_url_info['port']);
			fwrite($o_fd, $s_httpheader);
			$s_content = '';
			$headerFlag = true;
			while (!feof($o_fd)) {
				if (($header = @fgets($o_fd)) && ($header == "\r\n" || $header == "\n")) {
					break;
				}
			}
			while (!feof($o_fd)) {
				$s_content .= fread($o_fd, 128);
			}
			fclose($o_fd);
		}
		$a_content = json_decode($s_content, true);
		return $a_content;
	}
	
	/**
	 * 电商Sign签名生成
	 * @param s_json_data 内容   
	 * @return DataSign签名
	 */
	public function encrypt($s_json_data) {
		return urlencode(base64_encode(md5($s_json_data . $this->_api_key)));
	}
}
?>