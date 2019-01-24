<?php

class Upload_model extends TW_Model {

	public function __construct() {
		parent :: __construct();
	}

/************************************* 文件上传 *************************************/

    /**
     * [upload_img 上传文件函数]
     * @param  [array]  $file           [上传文件的信息]
     * @param  [array]  $allow          [允许的文件上传类型]
     * @param  [string] &$error         [引用传递，用来记录错误信息]
     * @param  [string] $path           [文件上传目录]
     * @param  [int]    $maxsize        [1024*1024 允许文件上传的最大大小]
     * @return [string] $target|false   [成功则返回新文件路径 失败返回false]
     */
    public function upload_img($file, $allow, &$error, $path, $maxsize) {

        switch ($file['error']) {
            case 1 : $error = '超出了上传限制大小';
                return false;
            case 2 : $error = '超出了浏览器表单允许的大小';
                return false;
            case 3 : $error = '文件上传不完整';
                return false;
            case 4 : $error = '请先选择需要上传的文件';
                return false;
            case 7 : $error = '服务器繁忙，稍后再试';
                return false;
        }

        // 判断文件大小
        if ($file['size'] > $maxsize) {
            // 超出了规定大小
            $error = '上传错误，超出了上传限制大小';
            return false;
        }

        // 判断文件类型
        if (!in_array($file['type'], $allow)) {
            $error = '上传的文件类型不正确';
            return false;
        }

        // 判断文件夹是否存在 不存在则创建
	    if (!file_exists($path)){
	        mkdir($path);
	    }

        //拼接新的文件名
        $newname = date('Ymdhis',time()) . rand(111, 999) .strrchr($file['name'], '.');
        $target = $path . '/' . $newname;

        // 移动临时文件
        $result = move_uploaded_file($file['tmp_name'] , $target);
        if ($result) {
            // 移动成功则返回新的文件名
            return $target;
        } else {
            $error = "发生未知错误，上传失败！";
            return false;
        }
    }

/********************************************************************************/
}

?>