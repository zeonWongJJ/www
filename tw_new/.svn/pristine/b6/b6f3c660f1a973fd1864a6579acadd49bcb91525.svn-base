<?php
defined('BASEPATH') OR exit('禁止访问！');
class Rule_ctrl extends TW_Controller {

	private $success=array(
        'status'=>true,
        'message'=>'修改规则成功'
        );

	public function __construct() {
		parent :: __construct();
        $this->load->model('Check_model');


	}

	//首页
	public function update_rule(){
        $config_rule_path=PROJECTPATH.'/config/config_rule.php';

		$post_data=$this->general->post();
        $post_data['field']='junior_certificate_experience';
        $post_data['value']='998';

		//接收值
		$new_field=$post_data['field'];
		$new_value=$post_data['value'];

		//传入参数的规则
		$key_array=array('field'=>null,'value'=>null);
		$check_data_state= $this->Check_model->check_parm($post_data,$key_array);
		if(!$check_data_state){
			echo  $this->error_message("1");
            die;
		}

        //读取配置文件
		$string=file_get_contents($config_rule_path);

        if(!$string){
            echo  $this->error_message("3");
            die;
        }

        //拼凑新的键
		$new_value="'".$new_field."'=>'".$new_value."'";

		$new_string=$this->replace_config($string,$new_field,$new_value);

		if(file_put_contents($config_rule_path,$new_string)){
            echo json_encode($this->success);
        }else{
            echo $this->error_message("2");
        }
	}

    /**
     * [替换相应的数据]
     * @param  [string]  [数组文件的代码]
     * @param  [field]  [键名  如 junior_certificate_experience]
     * @param  [value]  [值]
     */
    public function replace_config($string,$field,$value){

        return preg_replace("/\'$field\'\=>\'(.+?)\'/s",$value,$string);

    }

    /**
     * [错误回馈]
     * @param  [error_num]  [错误号]
     */
    public function error_message($error_num){
        switch ($error_num) {
            case '1':
                $tips="参数错误";
                break;

            case '2':
                $tips="修改规则失败，请联系管理员";
                break;

            case '3':
                $tips="读取文件失败，请联系管理员";
                break;

            default:
                $tips="未知错误，请与管理员联系";
                break;
        }

        $result['status']=false;
        $result['message']=$tips;
        return json_encode($result);
    }


}
