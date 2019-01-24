<?php
class Auth_realname_model extends TW_Model {
    //错误码
    private $errorNum;
    //错误信息
    private $errorMessage;
	//身份证名称
    private $id_name;
    //身份证号码
    private $id_card;
    //最终结果
    private $result;

	public function __construct() {
		parent :: __construct();
	}

    /**
     * [id_verification 身份证验证]
     * @return [array] [ture|false,提示信息,跳转url]
     */
	public function id_verification(){
        //接受表单信息
		$this->id_name 	= 	$this->general->post('id_name');
		$this->id_card 	= 	$this->general->post('id_card');
		$s_captcha 		= 	$this->general->post('captcha');

        // 验证码错误
		if($s_captcha != $_SESSION['captcha']){
			return $this->getError(1);
		}

        // 身份证或者身份证姓名为空
		if(empty($this->id_name) || empty($this->id_card)){
			return $this->getError(2);
		}

        //身份证是否符合规格
		$this->load->model('Check_model');
		if(! $this->Check_model->fun_status($this->id_card)){
			return $this->getError(3);
		}

        //身份证必须是中文
        if(! $this->Check_model->check_name($this->id_name)){
            return $this->getError(5);
        }


        //文件上传是否成功
        $result = $this->uploadFile($_FILES['card_picture']);
        if($result['status'] == false){
          $result['url'] = $this->router->url('id_verification');
          return $result;
        }

        //查看数据库该用户是否之前上传过信息
        $a_data = $this->db->get_row('auth_realname', ['uid' => $_SESSION['user_id']], 'realname_a_id,id_image');

        //如果第一次上传保存数据库，如果已上传过删除图片更新数据库
        if($a_data['realname_a_id']){
            $a_res = [
              'username'    => $_SESSION['user_name'],
              'id_number'   => $this->id_card,
              'realname'    => $this->id_name,
              'id_image'    => $result['tips'],
              'start_time'  => $_SERVER['REQUEST_TIME'],
              'auth_status' => 0,
          ];
          $path = './uploads/' . $a_data['id_image'];
          //删除图片
          unlink($path);
          $res = $this->db->update('auth_realname', $a_res, ['uid' => $_SESSION['user_id']]);
          //更新失败
          if($res == false){
            return $this->getError(4);
          }
        } else {
          $a_res = [
              'uid'         => $_SESSION['user_id'],
              'username'    => $_SESSION['user_name'],
              'id_number'   => $this->id_card,
              'realname'    => $this->id_name,
              'id_image'    => $result['tips'],
              'start_time'  => $_SERVER['REQUEST_TIME'],
              'auth_status' => 0,
          ];
          $res = $this->db->insert('auth_realname',$a_res);
          //更新失败
          if($res == false){
            return $this->getError(4);
          }
        }

    // 提交成功插入数据库
    $this->result['status']     = ture;
    $this->result['tips']     = '身份验证提交成功';
    $this->result['code']     = 0;
    $this->result['url']      = 'index';
    return $this->result;

	}

    //错误类型统计
    private function getError($errorNum, $url = '1') {
      switch ($errorNum) {
        case 1: $code = '10'; $case = "验证码错误"; break;
        case 2: $code = '20'; $case = "身份证号码或者身份证名称不能为空"; break;
        case 3: $code = '30'; $case = "身份证格式不正确"; break;
        case 4: $code = '40'; $case = "身份验证提交请重新提交"; break;
        case 5: $code = '50'; $case = "身份证名称必须是中文"; break;
        default: $case= "未知错误";
      }
      switch ($url) {
        case 1: $url = $this->router->url('id_verification'); break;
        default: $url= $this->router->url('id_verification');
      }
      $this->result['status'] 	= false;
      $this->result['tips'] 	= $case;
      $this->result['code'] 	= $code;
      $this->result['url'] 		= $url;

      return $this->result;
    }

    private function uploadFile($fileInfo,$uploadPath='uploads',$flag=true,$allowExt=array('jpeg','jpg','png','gif'),$maxSize = 2097152){
    //判断错误号,只有为0或者是UPLOAD_ERR_OK,没有错误发生，上传成功
        if($fileInfo['error']>0){
            //注意！错误信息没有5
            switch($fileInfo['error']){
                case 1:
                    $mes= '上传文件超过了PHP配置文件中upload_max_filesize选项的值';
                    break;
                case 2:
                    $mes= '超过了HTML表单MAX_FILE_SIZE限制的大小';
                    break;
                case 3:
                    $mes= '文件部分被上传';
                    break;
                case 4:
                    $mes= '没有选择上传文件';
                    break;
                case 6:
                    $mes= '没有找到临时目录';
                    break;
                case 7:
                    $mes= '文件写入失败';
                    break;
                case 8:
                    $mes= '上传的文件被PHP扩展程序中断';
                    break;

            }
            return $result = array(
              'status' => false,
              'tips' => $mes,
              );
        }
        $ext=pathinfo($fileInfo['name'],PATHINFO_EXTENSION);
        //$allowExt=array('jpeg','jpg','png','gif');

        //检测上传文件的类型
        if(! in_array($ext,$allowExt)){
          $mes = '非法文件类型';
          return $result = array(
              'status' => false,
              'tips' => $mes,
              );
        }

        //检测上传文的件大小是否符合规范
        //$maxSize = 2097152;//2M
        if($fileInfo['size']>$maxSize){
            $mes = '上传文件过大';
            return $result = array(
              'status' => false,
              'tips' => $mes,
              );
        }

        //检测图片是否为真实的图片类型
        //$flag=true;
        if($flag){
            if(!getimagesize($fileInfo['tmp_name'])){
                $mes = '不是真实的图片类型';
                return $result = array(
                  'status' => false,
                  'tips' => $mes,
                  );
            }
        }

        //检测是否是通过HTTP POST方式上传上来
        if(!is_uploaded_file($fileInfo['tmp_name'])){
            $mes = '文件不是通过HTTP POST方式上传上来的';
            return $result = array(
                  'status' => false,
                  'tips' => $mes,
                  );
        }

        //$uploadPath='uploads';
        //如果没有这个文件夹，那么就创建一个
        if(!file_exists($uploadPath)){
            mkdir( $uploadPath, 0777, true);
            chmod( $uploadPath, 0777 );
        }
        //新文件名唯一
        $uniName = substr(md5 ( uniqid( microtime(true),true) ),20).'.'.$ext;
        $destination = $uploadPath.'/'.$uniName;
        //@符号是为了不让客户看到错误信息
        if(! @move_uploaded_file($fileInfo['tmp_name'], $destination )){
          $mes = '文件移动失败';
          return $result = array(
                  'status' => false,
                  'tips' => $mes,
                  );
        }

        return $result = array(
                  'status' => ture,
                  'tips' => $uniName,
                  );
    }
}
?>