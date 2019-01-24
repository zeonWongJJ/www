<?php
/**
 *
 * @package	TW
 * @author	7duo
 * @copyright	Copyright (c) 7duo
 * 
 * @link	https://7duogo.com
 * @since	Version 1.0.0
 * @filesource
 */
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * File Uploading Manager Class
 *
 * @package		TW
 * @subpackage	Libraries
 * @category	Uploads
 * @author		7duo
 * @link		https://7duogo.com
 */
class TW_File_mgr {

	// --------------------------------------------------------------------

	/**
	 * TW Singleton
	 *
	 * @var	object
	 */
	protected $_TW;

	// --------------------------------------------------------------------

	/**
	 * Constructor
	 *
	 * @param	array	$config
	 * @return	void
	 */
	public function __construct($config = array())
	{

		$this->_TW =& get_instance();
        $this->_TW->load->library('log2');

		$this->_TW->log2->write_log('info', 'File_Mgr Class Initialized');
	}

	// --------------------------------------------------------------------

	/**
	 * 文件移动
	 *
	 * @return	bool
	 */
	public function move($src, $dst, $permissions=0644)
	{
		// With some files we have to create a temporary image.
		// If you try manipulating the original it fails so
		// we have to rename the temp file.
		copy($src, $dst);
		unlink($src);
		chmod($dst, $permissions);	
		return TRUE;
	}

	// --------------------------------------------------------------------

	/**
	 * 生成临时文件名
	 *
	 * @param	string	$dir_path
	 * @return	string
	 */
	public function get_temp_name($dir_path, $ext_name)
	{
		$date_str = date("Ymd");
		$randNum = rand(1000, 9999);

		while(file_exists($dir_path.$date_str.'-'.$randNum.'.'.$ext_name)) {
		    $randNum = rand(1000, 9999);
		}
		return $dir_path.$date_str.'-'.$randNum.'.'.$ext_name;
	}	

	// --------------------------------------------------------------------

	/**
	 * Perform the file manager operation
	 *
	 * @param	string	$path
	 * @param	string	$mod
	 * @param	string	$temp_path
	 * @return	bool
	 */
	public function save_to_temp($path, $mod = 'test', $temp_path='temp')
	{
		// $path = realpath($path);
		$info = pathinfo($path);
		//print_r($info);
		$temp_dst_path = realpath(PROJECTPATH.'/'.$temp_path.'/'.$mod.'/');
		if (!is_dir($temp_dst_path))
   		{
   			mkdir($temp_dst_path, 0777, true);
   		}		

		$temp_dst_full_path = $this->get_temp_name($temp_dst_path.DIRECTORY_SEPARATOR, $info['extension']);
		$this->move($path, $temp_dst_full_path);

		return $temp_dst_full_path;
	}

	// --------------------------------------------------------------------

	/**
	 * Perform the file manager operation
	 *
	 * @param	string	$path
	 * @param	string	$pid
	 * @param	string	$temp_path
	 * @param	string	$pub_path
	 * @return	string
	 */
	public function temp_to_pub($path, $pid, $mod = 'test', $pub_path='upload', $temp_path='temp')
	{
		
		$pub_dst_path = realpath('./'.$pub_path.'/');
		if (!is_dir($pub_dst_path))
   		{
   			mkdir($pub_dst_path, 0777, true);
   		}		
   		$pub_dst_path = $pub_dst_path . DIRECTORY_SEPARATOR . $mod;
		if (!is_dir($pub_dst_path))
   		{
   			mkdir($pub_dst_path, 0777, true);
   		}   

   		$pid_num =  floor(intval($pid)	/ 500) + 1;	

   		$pub_dst_path = $pub_dst_path . DIRECTORY_SEPARATOR . $pid_num;
		if (!is_dir($pub_dst_path))
   		{
   			mkdir($pub_dst_path, 0777, true);
   		}   	

   		$info = pathinfo($path);

		$pub_dst_path = $pub_dst_path . DIRECTORY_SEPARATOR . $pid.'-'.$info['basename'];
		$this->move($path, $pub_dst_path);
		return $pub_dst_path;
	}	
}
