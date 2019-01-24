<?php
/**
 * 文件操作控制器调度
 * @author rusice <liruzihao970302@outlook.com>
 * @version 1.0.0-dev
 */

/**
 * Class File_ctrl
 */
class File_ctrl extends \utils\BaseController
{
    /**
     * 移除图片
     * @router http://server.name/file.remove
     * @return mixed
     */
    public function removeFile()
    {
        if ($files = $this->request->post('files/a', [], 'trim')) {
            foreach ($files as $file) {
                $_file = __ROOT__ . $file;
                file_exists($_file) && unlink($_file);
            }
        }
        return $this->success(false);
    }
}
