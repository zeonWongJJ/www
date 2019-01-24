<?php

//---------------------------------------------------------
//�Ƹ�ͨ��ʱ����֧��ҳ��ص�ʾ�����̻����մ��ĵ����п�������
//---------------------------------------------------------
require_once ("./classes/ResponseHandler.class.php");
require_once ("./classes/function.php");
require_once ("./tenpay_config.php");

log_result("����ǰ̨�ص�ҳ��");


/* ����֧��Ӧ����� */
$resHandler = new ResponseHandler();
$resHandler->setKey($key);

//�ж�ǩ��
if($resHandler->isTenpaySign()) {
	
	//֪ͨid
	$notify_id = $resHandler->getParameter("notify_id");
	//�̻�������
	$out_trade_no = $resHandler->getParameter("out_trade_no");
	//�Ƹ�ͨ������
	$transaction_id = $resHandler->getParameter("transaction_id");
	//���,�Է�Ϊ��λ
	$total_fee = $resHandler->getParameter("total_fee");
	//�����ʹ���ۿ�ȯ��discount��ֵ��total_fee+discount=ԭ�����total_fee
	$discount = $resHandler->getParameter("discount");
	//֧�����
	$trade_state = $resHandler->getParameter("trade_state");
	//����ģʽ,1��ʱ����
	$trade_mode = $resHandler->getParameter("trade_mode");
	
	
	if("1" == $trade_mode ) {
		if( "0" == $trade_state){ 
			//------------------------------
			//����ҵ��ʼ
			//------------------------------
			
			//ע�⽻�׵���Ҫ�ظ�����
			//ע���жϷ��ؽ��
			
			//------------------------------
			//����ҵ�����
			//------------------------------	
			
			echo "<br/>" . "��ʱ����֧���ɹ�" . "<br/>";
	
		} else {
			//�������ɹ�����
			echo "<br/>" . "��ʱ����֧��ʧ��" . "<br/>";
		}
	}elseif( "2" == $trade_mode  ) {
		if( "0" == $trade_state) {
		
			//------------------------------
			//����ҵ��ʼ
			//------------------------------
			
			//ע�⽻�׵���Ҫ�ظ�����
			//ע���жϷ��ؽ��
			
			//------------------------------
			//����ҵ�����
			//------------------------------	
			
			echo "<br/>" . "�н鵣��֧���ɹ�" . "<br/>";
		
		} else {
			//�������ɹ�����
			echo "<br/>" . "�н鵣��֧��ʧ��" . "<br/>";
		}
	}
	
} else {
	echo "<br/>" . "��֤ǩ��ʧ��" . "<br/>";
	echo $resHandler->getDebugInfo() . "<br>";
}

?>