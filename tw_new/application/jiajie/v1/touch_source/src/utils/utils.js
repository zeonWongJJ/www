const utils = {
  is_weixin() {
    const ua = navigator.userAgent.toLowerCase()
    return ua.match(/MicroMessenger/i) == 'micromessenger'
  },
  is_ios() {
    const u = navigator.userAgent;
    return !!u.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/); //ios终端
  },
  is_android() {
    const u = navigator.userAgent;
    return u.indexOf('Android') > -1 || u.indexOf('Adr') > -1; //android终端,一定是app打开才有的
  },
  is_android_app() {
    const u = navigator.userAgent;
    return u.indexOf('agentweb') > -1; // android APP
  },
  /**
   * 调用方法：getUrlParam("id");
   * 假如当网页的网址有这样的参数 test.htm?id=896&s=q&p=5，则调用 GetUrlParam("p")，返回 5
   * @return {string}
   */
  getUrlParam(paraName) {
    const url = document.location.toString();
    const arrObj = url.split("?");

    if (arrObj.length > 1) {
      const arrPara = arrObj[1].split("&");
      let arr;

      for (let i = 0; i < arrPara.length; i++) {
        arr = arrPara[i].split("=");

        if (arr != null && arr[0] == paraName) {
          return arr[1];
        }
      }
    }
    return "";
  },
  /**
   * 转换日期格式
   * 2018年09月20日14时26分 => 2018-9-20 14:26
   * @param dataStr
   */
  convertDataFormat(dataStr) {
    const reg = /^([1-9]\d{3})年(0[1-9]|1[0-2])月(0[0-9]|[1-2][0-9]|3[0-1])日([0-5]\d)时([0-5]\d)分$/;
    if (dataStr.match(reg)) {
      return dataStr.replace(reg, "$1-$2-$3 $4:$5");
    }
    return false;
  },
//酬金省略后两位
//自动补后两位小数
	returnFloat(value){
		var value=Math.floor(parseFloat(value)*100)/100;
		if(!value){return 0}
		var xsd=value.toString().split(".");
		if(xsd.length==1){
			value=value.toString()+".00";
			return value;
		}
		if(xsd.length>1){
			if(xsd[1].length<2){
				value=value.toString()+"0";
			}
			return value;
		}
	}
}

export default utils
