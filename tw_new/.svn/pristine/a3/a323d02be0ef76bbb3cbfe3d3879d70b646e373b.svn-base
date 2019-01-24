银联网关b2c支付类
======
###### v1.0

##### 用途

```
用于跳转到银联官方网站的在线支付，支付成功后会返回商户指定的前端接收网页
```

##### 类名

    unionpay_b2c

##### API

* undo
    
    * 撤销指定的支付
    * 函数原型 
    
            public function undo($a_param = [])
        
    * 返回值 array()
    * 输入参数 array()
        * orderId 
            
            商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费
        * merId
        
            商户代码，请改成自己的测试商户号
        * origQryId
        
            原消费的queryId，可以从查询接口或者通知接口中获取
        * txnTime
        
            订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费
        * txnAmt
            
            交易金额，消费撤销时需和原消费一致
        * reqReserved
            
            透传信息, 可选参数；请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
    * 调用示例
        
            $this->load->library('unionpay_b2c');
			$result_arr = $this->unionpay_b2c->undo(array(
			    'orderId'=>'12345',
			    'merId' => '777290058110048',
			    'origQryId' => '12345678',
			    'txnTime'=>'20170101010101',
			    'txnAmt'=>'2'
			    ));
			    
			if (!$this->unionpay_b2c->validate ($result_arr) ){
			    echo "应答报文验签失败";
			    die;
		    }
		    
            echo "应答报文验签成功";

		    if ($result_arr["respCode"] == "00"){
		        // 交易已受理，等待接收后台通知更新订单状态，如果通知长时间
		        // 未收到也可发起交易状态查询
		        // TODO
		        echo "受理成功";
		    } else if ($result_arr["respCode"] == "03"
		 	    || $result_arr["respCode"] == "04"
		 	    || $result_arr["respCode"] == "05" ){
		        // 后续需发起交易状态查询交易确定交易状态
		        // TODO
		        echo "处理超时，请稍后查询";
		    } else {
		        // 其他应答码做以失败处理
		        // TODO
		        echo "失败：" . $result_arr["respMsg"];
		    }            
* pay
    
    * 支付
    * 函数原型 
    
            public function pay($a_param = [])
        
    * 返回值 string， 内容是要显示的跳转html代码，简化起见全部返回到统一的回调页面
    * 输入参数 array()
        * orderId 
            
            商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则
        * merId
        
            商户代码，请改自己的测试商户号
        * txnTime
        
            订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
        * txnAmt
            
            交易金额，单位分
        * urlFront
            
            前端回调网址，可选参数，建议使用            
        * reqReserved
            
            透传信息, 可选参数；请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
    * 调用示例
        
            $this->load->library('unionpay_b2c');
			echo $this->unionpay_b2c->pay(array(
			    'orderId'=>'12345678',
			    'merId' => '777290058110048',
			    'txnTime'=>date("YmdHis"),
			    'txnAmt'=>'2',
			    'urlFront'=>'http://wofei2.com/pay-success'
			    ));
			    
			// 支付成功后将返回到前端回调页面， 如果没指定 urlFront 参数，
			// 则由配置文件 
			// config/config_unionpay.php 中的
			// SDK_FRONT_TRANS_URL 指定
* query
    
    * 查询支付订单信息
    * 函数原型 
    
            public function query($a_param = [])
        
    * 返回值 array()
    * 输入参数 array()
        * orderId 
            
            请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”
        * merId
        
            商户代码，请改自己的测试商户号
        * txnTime
        
            请修改被查询的交易的订单发送时间，格式为YYYYMMDDhhmmss
    * 调用示例
        
            $this->load->library('unionpay_b2c');
			$result_arr = $this->unionpay_b2c->query(array(
			    'orderId'=>'12345',
			    'merId' => '777290058110048',
			    'txnTime'=>'20170101010101'
			    ));
			    
			if(count($result_arr)<=0) { //没收到200应答或参数不完整的情况
			    return;
		    }

    		if (!$this->unionpay_b2c->validate ($result_arr) ){
    			echo "应答报文验签失败";
    			return;
    		}
    
    		echo "应答报文验签成功";
    		
    		if ($result_arr["respCode"] == "00"){
    			if ($result_arr["origRespCode"] == "00"){
    				// 交易成功
    				// TODO
    				echo "交易成功";
    			} else if ($result_arr["origRespCode"] == "03"
    					|| $result_arr["origRespCode"] == "04"
    					|| $result_arr["origRespCode"] == "05"){
    				// 后续需发起交易状态查询交易确定交易状态
    				// TODO
    				echo "交易处理中，请稍后查询";
    			} else {
    				// 其他应答码做以失败处理
    				// TODO
    				echo "交易失败：" . $result_arr["origRespMsg"];
    			}
    		} else if ($result_arr["respCode"] == "03"
    				|| $result_arr["respCode"] == "04"
    				|| $result_arr["respCode"] == "05" ){
    			// 后续需发起交易状态查询交易确定交易状态
    			// TODO
    			echo "处理超时，请稍后查询";
    		} else {
    			// 其他应答码做以失败处理
    			// TODO
    			echo "失败：" . $result_arr["respMsg"];
    		}
* refund
    
    * 指定的支付订单退款
    * 函数原型 
    
            public function refund($a_param = [])
        
    * 返回值 array()
    * 输入参数 array()
        * orderId 
            
            商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费
        * merId
        
            商户代码，请改成自己的测试商户号
        * origQryId
        
            原消费的queryId，可以从查询接口或者通知接口中获取
        * txnTime
        
            订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费
        * txnAmt
            
            交易金额，退货总金额需要小于等于原消费
        * reqReserved
            
            透传信息, 可选参数；请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据
    * 调用示例
        
            $this->load->library('unionpay_b2c');
			$result_arr = $this->unionpay_b2c->refund(array(
			    'orderId'=>'12345',
			    'merId' => '777290058110048',
			    'origQryId' => '12345678',
			    'txnTime'=>'20170101010101',
			    'txnAmt'=>'2'
			    ));
			    
			if (!$this->unionpay_b2c->validate ($result_arr) ){
			    echo "应答报文验签失败";
			    die;
		    }
		    
            echo "应答报文验签成功";

		    if ($result_arr["respCode"] == "00"){
		        // 交易已受理，等待接收后台通知更新订单状态，如果通知长时间
		        // 未收到也可发起交易状态查询
		        // TODO
		        echo "受理成功";
    		} else if ($result_arr["respCode"] == "03"
    		 	    || $result_arr["respCode"] == "04"
    		 	    || $result_arr["respCode"] == "05" ){
    		    // 后续需发起交易状态查询交易确定交易状态
    		    // TODO
    		     echo "处理超时，请稍后查询";
    		} else {
    		    // 其他应答码做以失败处理
    		    // TODO
    		    echo "失败：" . $result_arr["respMsg"];
    		}
* validate
    
    * 签名验证
    * 函数原型 
    
            public function validate($result_arr)
        
    * 返回值 bool
    * 输入参数 array()，银联返回的数据
    * 调用示例
        
            $this->load->library('unionpay_b2c');
            // ...
            // $result_r = ...
			echo $this->unionpay_b2c->validate($result_r);

##### 回调页面

* 前端同步回调

    用于支付成功后的返回页面，使用示例为
    
            $this->load->library('unionpay_b2c');
            if (isset ( $_POST ['signature'] )) {
                echo $this->unionpay_b2c->validate ( $_POST ) ? 
                    '验签成功' : '验签失败';
                    
				$orderId = $_POST ['orderId']; 
				// 其他字段也可用类似方式获取
				
				$respCode = $_POST ['respCode']; 
				// 判断respCode=00或A6即可认为交易成功  
				
                $this->view->display('pay-success');
			} else {
			    echo '签名为空';
			    
			    $this->view->display('pay-failed');
			}
        
* 后台异步回调

    用于支付后的后台异步回调， 可防止用户前台中途或意外关闭页面导致的事务不一致，使用示例为
    
            $this->load->library('unionpay_b2c');
            if (isset ( $_POST ['signature'] )) {
                echo $this->unionpay_b2c->validate ( $_POST ) ? 
                    '验签成功' : '验签失败';
                    
				$orderId = $_POST ['orderId']; 
				// 其他字段也可用类似方式获取
				
				$respCode = $_POST ['respCode']; 
				// 判断respCode=00或A6即可认为交易成功  
				
                // TODO
                // 写入数据库
			} else {
			    echo '签名为空';
			    
                // TODO
                // 写入数据库
			}
        
##### 配置文件

* 路径
    
    建议使用项目配置文件， 路径为 `config/config_unionpay.php`
* 必需配置
    
    * SDK_SIGN_CERT_PATH 
    
      签名证书路径
    * SDK_SIGN_CERT_PWD 
     
      签名证书密码
    * SDK_VERIFY_CERT_DIR 
    
      验签证书路径（请配到文件夹，不要配到具体文件）,默认为 D:/certs/
    * SDK_LOG_FILE_PATH 
    
      日志目录，默认为 D:/logs/
    * SDK_FRONT_NOTIFY_URL 
    
      默认前台通知地址 (商户自行配置通知地址)
    * SDK_BACK_NOTIFY_URL 
    
      后台通知地址 (商户自行配置通知地址，需配置外网能访问的地址)




银联代付df支付类
======
###### v1.0

##### 用途

```
用于进行后台的代付业务，目前暂时未包含前台功能(视业务需要待定)
```

##### 类名

    unionpay_df

##### API
           
* pay
    
    * 支付
    * 函数原型 
    
            public function pay($customerInfo, $accNo, $a_param = [])
        
    * 返回值 array()
    * 输入参数 array() $customerInfo 持卡人信息
    * 输入参数 string $accNo    卡号
    * 输入参数 array() $a_param
        * orderId 
            
            商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则
        * merId
        
            商户代码，请改自己的测试商户号
        * txnTime
        
            订单发送时间，格式为YYYYMMDDhhmmss，取北京时间
        * txnAmt
            
            交易金额，单位分            
        * billNo
            
            透传信息, 可选参数；银行附言。会透传给发卡行，完成改造的发卡行会把这个信息在账单、短信中显示给用户的，请按真实情况填写。
    * 调用示例
        
            $this->load->library('unionpay_df');
            
    		// 支付卡要素说明：证件和姓名至少出现一个，其余手机号等要素不送
    		$accNo = '6226388000000095';
    		$customerInfo = array(
    			'certifTp' => '01',
    			'certifId' => '510265790128303',
    			'customerNm' => '张三',
    		);            
			$result_arr = $this->unionpay_df->pay(
			    $customerInfo,
			    $accNo,
			    array(
    			    'orderId'=>date("YmdHis"),
    			    'merId' => '777290058110097',
    			    'txnTime'=>date("YmdHis"),
    			    'txnAmt'=>'2'
			    ));
			    
    		if (!$this->unionpay_df->validate ($result_arr) ){
    		    echo "应答报文验签失败";
    		    return;
    		}
    
    		echo "应答报文验签成功";
    		if ($result_arr["respCode"] == "00"){
    		    // 交易已受理，等待接收后台通知更新订单状态，
    		    // 如果通知长时间未收到也可发起交易状态查询
    		    // TODO
    		    echo "受理成功";
    		} else if ($result_arr["respCode"] == "03"
    		 	    || $result_arr["respCode"] == "04"
    		 	    || $result_arr["respCode"] == "05"
    		 	    || $result_arr["respCode"] == "01"
    		 	    || $result_arr["respCode"] == "12"
    		 	    || $result_arr["respCode"] == "34"
    		 	    || $result_arr["respCode"] == "60" ){
    		    // 后续需发起交易状态查询交易确定交易状态
    		    // TODO
    		     echo "处理超时，请稍后查询";
    		} else {
    		    // 其他应答码做以失败处理
    		    // TODO
    		    echo "失败：" . $result_arr["respMsg"];
    		}			
* query
    
    * 查询支付订单信息
    * 函数原型 
    
            public function query($a_param = [])
        
    * 返回值 array()
    * 输入参数 array()
        * orderId 
            
            请修改被查询的交易的订单号，8-32位数字字母，不能含“-”或“_”
        * merId
        
            商户代码，请改自己的测试商户号
        * txnTime
        
            请修改被查询的交易的订单发送时间，格式为YYYYMMDDhhmmss
    * 调用示例
        
            $this->load->library('unionpay_df');
			$result_arr = $this->unionpay_df->query(array(
			    'orderId'=>'12345',
			    'merId' => '777290058110048',
			    'txnTime'=>'20170101010101'
			    ));
			    
			if(count($result_arr)<=0) { //没收到200应答或参数不完整的情况
			    return;
		    }

    		if (!$this->unionpay_df->validate ($result_arr) ){
    			echo "应答报文验签失败";
    			return;
    		}
    
    		echo "应答报文验签成功";
    		
    		if ($result_arr["respCode"] == "00"){
    			if ($result_arr["origRespCode"] == "00"){
    				// 交易成功
    				// TODO
    				echo "交易成功";
    			} else if ($result_arr["origRespCode"] == "03"
    			 	    || $result_arr["origRespCode"] == "04"
    			 	    || $result_arr["origRespCode"] == "05"
    			 	    || $result_arr["origRespCode"] == "01"
    			 	    || $result_arr["origRespCode"] == "12"
    			 	    || $result_arr["origRespCode"] == "34"
    			 	    || $result_arr["origRespCode"] == "60" ){
    				// 后续需发起交易状态查询交易确定交易状态
    				// TODO
    				echo "交易处理中，请稍后查询";
    			} else {
    				// 其他应答码做以失败处理
    				// TODO
    				echo "交易失败：" . $result_arr["origRespMsg"];
    			}
    		} else if ($result_arr["respCode"] == "03"
    				|| $result_arr["respCode"] == "04"
    				|| $result_arr["respCode"] == "05" ){
    			// 后续需发起交易状态查询交易确定交易状态
    			// TODO
    			echo "处理超时，请稍后查询";
    		} else {
    			// 其他应答码做以失败处理
    			// TODO
    			echo "失败：" . $result_arr["respMsg"];
    		}

* validate
    
    * 签名验证
    * 函数原型 
    
            public function validate($result_arr)
        
    * 返回值 bool
    * 输入参数 array()，银联返回的数据
    * 调用示例
        
            $this->load->library('unionpay_df');
            // ...
            // $result_r = ...
			echo $this->unionpay_df->validate($result_r);
			
* decryptData
    
    * 解密数据
    * 函数原型 
    
            public function decryptData($encryptData)
        
    * 返回值 string
    * 输入参数 string
    * 调用示例
        
            $this->load->library('unionpay_df');
            // ...
            // $encryptData = ...
			echo $this->unionpay_df->decryptData($encryptData);

##### 回调页面
       
* 后台异步回调

    用于支付后的后台异步回调， 可防止用户前台中途或意外关闭页面导致的事务不一致，使用示例为
    
            $this->load->library('unionpay_df');
            if (isset ( $_POST ['signature'] )) {
                echo $this->unionpay_df->validate ( $_POST ) ? 
                    '验签成功' : '验签失败';
                    
				$orderId = $_POST ['orderId']; 
				// 其他字段也可用类似方式获取
				
				$respCode = $_POST ['respCode']; 
				// 判断respCode=00或A6即可认为交易成功  
				
		        //如果卡号我们业务配了会返回且配了需要加密的话，请按此方法解密
                // if(array_key_exists ("accNo", $_POST)){
                // 	$accNo = $this->unionpay_df->
                //      decryptData($_POST["accNo"]);
                // 	echo  "accNo=" . $accNo;
                // }
				
                // TODO
                // 写入数据库
			} else {
			    echo '签名为空';
			    
                // TODO
                // 写入数据库
			}
        
##### 配置文件

* 路径
    
    使用项目配置文件， 路径为 `config/config_unionpay.php`
* 必需配置
    
    * SDK_SIGN_CERT_PATH 
    
      签名证书路径
    * SDK_SIGN_CERT_PWD 
     
      签名证书密码
    * SDK_VERIFY_CERT_DIR 
    
      验签证书路径（请配到文件夹，不要配到具体文件）,默认为 D:/certs/
    * SDK_LOG_FILE_PATH 
    
      日志目录，默认为 D:/logs/
    * SDK_FRONT_NOTIFY_URL 
    
      默认前台通知地址 (商户自行配置通知地址)
    * SDK_BACK_NOTIFY_URL 
    
      后台通知地址 (商户自行配置通知地址，需配置外网能访问的地址)
    * SDK_ENCRYPT_CERT_PATH 
    
      加密证书路径
    * SDK_MIDDLE_CERT_PATH 
    
      验签中级证书路径
    * SDK_ROOT_CERT_PATH 
    
      验签根证书路径
    * SDK_FILE_DOWN_PATH 
    
      银联对账文件或批量查询文件下载路径      